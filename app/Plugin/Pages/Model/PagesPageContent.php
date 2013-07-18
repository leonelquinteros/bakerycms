<?php
class PagesPageContent extends PagesAppModel
{
    public $name = 'PagesPageContent';
    public $recursive = -1;

    public $belongsTo = array (
                            'Page' => array(
                                            'className' => 'PagesPage',
                                            'foreignKey' => 'pages_pages_id',
                            )
    );

    public $validate = array(
                        'pages_pages_id' => array(
                                    'notEmptyRule' => array(
                                            'rule' => 'notEmpty',
                                            'required' => true,
                                            'allowEmpty' => false,
                                            'message' => 'Translate this',
                                    )
                        ),

    );

    /**
     * saveContent()
     *
     * @param (array) $post $_POST data.
     * @return (boolean)
     */
    public function saveContent($data, $pageId)
    {
        foreach($data as $key => $value)
        {
            if($key != 'goEditContent' && $key != 'data')
            {
                $contentData = $this->find('first', array(
                                        'conditions' => array(
                                                            'PagesPageContent.pages_pages_id' => $pageId,
                                                            'PagesPageContent.content_key' => $key
                                        )
                                    )
                );

                if(empty($contentData))
                {
                    $contentData = $this->create();

                    $contentData['PagesPageContent']['content_key'] = $key;
                    $contentData['PagesPageContent']['pages_pages_id'] = $pageId;
                }

                $contentData['PagesPageContent']['content'] = $value;

                $this->save($contentData);
            }
        }
    }


    /**
     * afterSave()
     * Clear menu cache
     */
    public function afterSave($created)
    {
        $pageId = $this->data['PagesPageContent']['pages_pages_id'];

        App::import('Model', 'Pages.PagesPage');
        $page = new PagesPage();
        $pageData = $page->findById($pageId);

        $this->clearPageCache($pageData['PagesPage']['url'], $pageId);

        return true;
    }

    /**
     * beforeDelete()
     * Clear menu cache
     */
    public function beforeDelete($cascade = true)
    {
        $pageContentData = $this->find('first', array('conditions' => array('PagesPageContent.id' => $this->id)));
        $pageId = $pageContentData['PagesPageContent']['pages_pages_id'];

        App::import('Model', 'Pages.PagesPage');
        $page = new PagesPage();
        $pageData = $page->findById($pageId);

        $this->clearPageCache($pageData['PagesPage']['url'], $pageId);

        return true;
    }

    /**
     * clearPageCache()
     * Deletes cached page information.
     */
    public function clearPageCache($url, $id)
    {
        Cache::delete('plugins-pages-models-pages_page-get_page-' . $url, 'permanent');
        Cache::delete('plugins-pages-models-pages_page-get_published_page-' . $url, 'permanent');

        $langs = explode(',', SUPPORTED_LANGUAGES);
        foreach($langs as $lang)
        {
            Cache::delete('plugins-pages-models-pages_page-get_home_page-' . $lang, 'permanent');
        }

        Cache::delete('plugins-pages-models-pages_page-get_content-' . $id, 'permanent');
    }
}
