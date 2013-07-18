<?php
class PagesPage extends PagesAppModel
{
    public $name = 'PagesPage';
    public $recursive = -1;

    public $galleryTypes = array('tabs', 'vertical-tabs', 'collapsible', 'slider');

    public $hasMany = array(
                        'Content' => array(
                                            'className' => 'PagesPageContent',
                                            'foreignKey' => 'pages_pages_id',
                        )
    );

    public $validate = array(
                        'title' => array(
                                    'notEmptyRule' => array(
                                            'rule' => 'notEmpty',
                                            'required' => true,
                                            'allowEmpty' => false,
                                            'message' => 'Translate this',
                                    )
                        ),
                        'layout' => array(
                                    'notEmptyRule' => array(
                                            'rule' => 'notEmpty',
                                            'required' => true,
                                            'allowEmpty' => false,
                                            'message' => 'Translate this',
                                    )
                        ),
                        'url' => array(
                                    'urlRule' => array(
                                            'rule' => 'isUnique',
                                            'required' => true,
                                            'allowEmpty' => false,
                                            'message' => 'Translate this',
                                    )
                        ),

    );


    /**
     * beforeValidate()
     * Converts URLs to Inflector::slug() before save.
     */
    public function beforeValidate($options = array())
    {
        if( !empty($this->data['PagesPage']['url']) )
        {
            $this->data['PagesPage']['url'] = Inflector::slug( strtolower($this->data['PagesPage']['url']), '-' );
        }
        else
        {
            $this->data['PagesPage']['url'] = Inflector::slug( strtolower($this->data['PagesPage']['title']), '-' );
        }

        return true;
    }

    /**
     * afterSave()
     * Clear page cache
     */
    public function afterSave($created)
    {
        $this->clearPageCache($this->data['PagesPage']['url'], $this->id);

        return true;
    }

    /**
     * beforeDelete()
     * Clear page cache.
     */
    public function beforeDelete($cascade = true)
    {
        $pageData = $this->find('first', array('conditions' => array('PagesPage.id' => $this->id)));
        $this->clearPageCache($pageData['PagesPage']['url'], $this->id);

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
        Cache::delete('plugins-pages-models-pages_page-get_map_link', 'permanent');

        $langs = explode(',', SUPPORTED_LANGUAGES);
        foreach($langs as $lang)
        {
            Cache::delete('plugins-pages-models-pages_page-get_home_page-' . $lang, 'permanent');
        }

        Cache::delete('plugins-pages-models-pages_page-get_content-' . $id, 'permanent');
    }


    /**
     * getPageLayoutsList()
     * Returns a list of CakePHP views in app/plugins/pages/pages_page/ that are suppose to be available to use in any editable page.
     *
     * @return (array)
     */
    public function getPageLayoutsList()
    {
        $path = CakePlugin::path('Pages') . '/View/PagesPage/';
        $dirList = scandir($path);
        $layouts = array();

        for($i = 0; $i < count($dirList); $i++)
        {
            if( is_file($path . $dirList[$i]) )
            {
                $layouts[substr($dirList[$i], 0, -4)] = Inflector::humanize(substr($dirList[$i], 0, -4));
            }
        }

        return $layouts;
    }

    /**
     * getPage()
     * Gets a pages_page table record using the URL as key.
     *
     * @param (string) $url
     */
    public function getPage($url)
    {
        App::import('Lib', 'Empowered');

        $pageData = Cache::read('plugins-pages-models-pages_page-get_page-' . $url, 'permanent');

        if($pageData === false)
        {
            $pageData = $this->find('first', array(
                                                'conditions' =>  array('PagesPage.url' => $url)
                                            )
                    );

            if(!empty($pageData))
            {
                Cache::write('plugins-pages-models-pages_page-get_page-' . $url, $pageData, 'permanent');
            }
        }

        // Get Empowered integration
        $this->getEmpoweredData($pageData);

        return $pageData;
    }

    /**
     * getPublishedPage()
     * Gets a pages_page table record using the URL as key and checking if the page is published now.
     *
     * @param (string) $url
     */
    public function getPublishedPage($url)
    {
        App::import('Lib', 'Empowered');

        $pageData = Cache::read('plugins-pages-models-pages_page-get_published_page-' . $url, 'permanent');

        if($pageData === false)
        {
            $pageData = $this->find('first', array(
                                                'conditions' =>  array('PagesPage.url' => $url, 'PagesPage.publish' => '1', 'PagesPage.publish_date <' => date('Y-m-d H:i:s'))
                                            )
                    );

            if(!empty($pageData))
            {
                Cache::write('plugins-pages-models-pages_page-get_published_page-' . $url, $pageData, 'permanent');
            }
        }

        // Get Empowered integration
        $this->getEmpoweredData($pageData);

        return $pageData;
    }


    /**
     * getEmpoweredData()
     * Fills the pageData array with Empowered information.
     * Receives the array by reference.
     * Doesn't returns anything.
     *
     * @param (array) & $pageData
     *
     */
    public function getEmpoweredData( &$pageData )
    {
        // Get Empowered integration. Empowered lib will handle API caching.
        if(!empty($pageData))
        {
            switch($pageData['PagesPage']['layout'])
            {
                case 'empowered_organization':
                    $pageData['Empowered'] = Empowered::getOrganization($pageData['PagesPage']['emp_organization_id']);
                    break;

                case 'empowered_program':
                    $pageData['Empowered'] = Empowered::getProgram($pageData['PagesPage']['emp_program_id']);
                    break;

            }

        }
    }


    /**
     * getHomePage()
     * Gets a pages_page table record using the 'home' layout as key and checking if the page is published now.
     *
     * @param (string) $url
     */
    public function getHomePage($lang)
    {
        $pageData = Cache::read('plugins-pages-models-pages_page-get_home_page-' . $lang, 'permanent');

        if($pageData === false)
        {
            $pageData = $this->find('first', array(
                                                'conditions' =>  array('PagesPage.layout' => 'home', 'PagesPage.lang' => $lang)
                                            )
                    );

            if(!empty($pageData))
            {
                Cache::write('plugins-pages-models-pages_page-get_home_page-' . $lang, $pageData, 'permanent');
            }
        }

        return $pageData;
    }


    public function getMapLink()
    {
        $link = Cache::read('plugins-pages-models-pages_page-get_map_link', 'permanent');

        if($link === false)
        {
            $pageData = $this->find('first', array(
                                                'conditions' =>  array('PagesPage.layout' => 'chapters_map')
                                            )
                    );

            if(!empty($pageData))
            {
                $link = '/' . $pageData['PagesPage']['url'];
                Cache::write('plugins-pages-models-pages_page-get_map_link', $link, 'permanent');
            }
        }

        return $link;
    }


    /**
     * getContent()
     * Gets all the available contents for the page into an array where the array key is the content_key value.
     *
     * @param (int) $pageId
     * @return (array) Array with contents for this page
     */
    public function getContent($pageId) {
        $return = Cache::read('plugins-pages-models-pages_page-get_content-' . $pageId, 'permanent');

        if($return === false)
        {
            App::import('Model', 'Pages.PagesPageContent');
            $pageContent = new PagesPageContent();
            $data = $pageContent->find('all', array('conditions' => array('PagesPageContent.pages_pages_id' => $pageId)));

            $return = array();

            foreach($data as $content)
            {
                $return[ $content['PagesPageContent']['content_key'] ] = $content['PagesPageContent']['content'];
            }

            if(!empty($return))
            {
                Cache::write('plugins-pages-models-pages_page-get_content-' . $pageId, $return, 'permanent');
            }
        }

        return $return;
    }
}
