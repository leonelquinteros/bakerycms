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
class PagesPageController extends PagesAppController
{
    public $name = 'PagesPage'; // Jimmy Page
    public $uses = array('Pages.PagesPage', 'Pages.PagesPageContent', 'Menus.MenusMenu');
    public $components = array('CmsLogin');
    public $helpers = array('Text', 'Menus.Submenu');

    public function beforeFilter()
    {
        // Retrieves menu for layout
        $this->set('menuData', $this->MenusMenu->getPageMenu($this->I18n->getLanguage()));

        $this->set('SessionLanguage', $this->I18n->getLanguage());

        // Default meta data
        $this->set('pageTitle', 'Page');
        $this->set('seoTitle', '');
        $this->set('seoDescription', '');
        $this->set('seoKeywords', '');
    }

    public function page($url = '')
    {
        // If an administrator is logged in, he can access to any non-published page.
        // Used for CMS's "Live Edit"
        if(!empty($url))
        {
            if( $this->CmsLogin->isLoggedIn() )
            {
                $pageData = $this->PagesPage->getPage($url);
            }
            else
            {
                $pageData = $this->PagesPage->getPublishedPage($url);
            }

            // Not found.
            if(empty($pageData))
            {
                return $this->notFound();
            }
        }
        else // Look for home page.
        {
            $pageData = $this->PagesPage->getHomePage( $this->I18n->getLanguage() );
        }

        if(empty($pageData))
        {
            return $this->notFound();
        }

        // Page data
        $this->set('page', $pageData);

        // Page content
        $this->set('pageContent', $this->PagesPage->getContent( $pageData['PagesPage']['id']) );

        // Meta data
        $this->set('pageTitle', $pageData['PagesPage']['title']);
        $this->set('seoTitle', $pageData['PagesPage']['seo_title']);
        $this->set('seoDescription', $pageData['PagesPage']['seo_description']);
        $this->set('seoKeywords', $pageData['PagesPage']['seo_keywords']);

        // Renders page layout if is set.
        if( !empty($pageData['PagesPage']['layout'])
            && array_key_exists( $pageData['PagesPage']['layout'], $this->PagesPage->getPageLayoutsList() )
        )
        {
            $this->render($pageData['PagesPage']['layout']);
        }
    }

    public function notFound()
    {
        header('HTTP/1.0 404 Not Found');
        header('Status: 404 Not Found');

        $pageData = $this->PagesPage->find('first', array(
                                                        'conditions' =>  array('PagesPage.layout' => 'not_found')
                                                    )
        );

        if(empty($pageData))
        {
            echo __d('cms', 'Error 404, page not found');
            exit;
        }

        // Page data
        $this->set('page', $pageData);

        // Page content
        $this->set('pageContent', $this->PagesPage->getContent( $pageData['PagesPage']['id']) );

        // Meta data
        $this->set('pageTitle', $pageData['PagesPage']['title']);
        $this->set('seoTitle', $pageData['PagesPage']['seo_title']);
        $this->set('seoDescription', $pageData['PagesPage']['seo_description']);
        $this->set('seoKeywords', $pageData['PagesPage']['seo_keywords']);

        $this->render('not_found');
    }
}
