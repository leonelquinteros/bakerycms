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
                                            'rule' => 'notBlank',
                                            'required' => true,
                                            'allowEmpty' => false,
                                            'message' => 'Translate this',
                                    )
                        ),
                        'layout' => array(
                                    'notEmptyRule' => array(
                                            'rule' => 'notBlank',
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
    public function afterSave($created, $options = array())
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

        return $pageData;
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
