<?php
/**
 * Bakery CMS
 *
 * @author: Leonel Quinteros <leonel.quinteros@gmail.com>, http://leonelquinteros.github.io
 * @copyright: Copyright (c) 2013, Leonel Quinteros. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and
 * the following disclaimer in the documentation and/or other materials provided with the distribution.
 * Neither the name "Bakery CMS" nor the names of its contributors may be used to endorse or promote
 * products derived from this software without specific prior written permission.
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
 * STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */
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
                                            'rule' => 'notBlank',
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
    public function afterSave($created, $options = array())
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
