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
class MenusCmsController extends MenusAppController
{
    public $uses = array('Menus.MenusMenu', 'Pages.PagesPage');

    public $components = array('BakeryLogin', 'Breadcrumb', 'BakeryMenu');

    public $helpers = array('CmsBreadcrumb', 'CmsWelcome', 'Language', 'Form');


    public function beforeFilter()
    {
        // Disables browser cache
        $this->disableCache();

        // Sets layout
        $this->layout = "cms/cms";

        // Checks login
        $this->BakeryLogin->checkAdminLogin();

        $this->Breadcrumb->addCrumb(__d('cms', 'Home'), '/cms');

        if( $this->action == 'index' )
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Menu structure'));
        }
        else
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Menu structure'), '/cms/menus');
        }

        $cmsMenu = $this->BakeryMenu->getMenu();
        $this->set('cmsMenu', $cmsMenu);

        $this->set('pageTitle', 'Menu structure');
    }


    public function beforeRender()
    {
        parent::beforeRender();

        $this->set( 'breadcrumb', $this->Breadcrumb->getBreadcrumb() );
    }


    public function index()
    {
        $langs = explode(',', SUPPORTED_LANGUAGES);
        $menus = explode(',', SITE_MENUS);

        $this->set('langs', $langs);
        $this->set('menus', $menus);
    }


    public function view($lang, $menuName)
    {
        $this->BakeryLogin->checkAdminRestriction('index');

        App::import('Lib', 'Language');

        // Save
        if( !empty($this->data) )
        {
            if( $this->AdminsAdmin->save($this->data['AdminsAdmin']) )
            {
                return $this->redirect('/cms/admins');
            }
        }
        else // Retrieve info
        {
            $this->MenusMenu->recursive = 1;
            $this->data = $this->MenusMenu->find(   'all',
                                                    array(
                                                        'conditions' => array('name' => $menuName, 'lang' => $lang, 'parent_id' => 0),
                                                        'order' => 'MenusMenu.position'));
            $this->MenusMenu->recursive = -1;
        }

        // Pages
        $pages = $this->PagesPage->find( 'all', array(
                                                'order' => 'PagesPage.title',
                                                'conditions' => array('PagesPage.publish' => 1, 'PagesPage.lang' => $lang) )
        );

        // Filter pages that are already in this menu
        foreach($pages as $key => $page)
        {
            $menuCheck = $this->MenusMenu->find('all', array(
                                                        'conditions' => array(
                                                            'MenusMenu.lang' => $lang,
                                                            'MenusMenu.name' => $menuName,
                                                            'MenusMenu.link' => '/' . $page['PagesPage']['url']
                                                        )
                                                    )
            );

            if(!empty($menuCheck))
            {
                unset($pages[$key]);
            }
        }
        $this->set('pages', $pages);
        $this->set('langName', Language::name($lang));

        // Data
        $this->set('lang', $lang);
        $this->set('menuName', $menuName);

        // Breadcrumb
        $this->Breadcrumb->addCrumb( Language::name($lang) . ' ' . $menuName . ' ' . __d('cms', 'menu') );
        $this->set('pageTitle', Language::name($lang) . ' ' . $menuName . ' ' . __d('cms', 'menu'));
    }


    public function edit($lang, $menuName, $id = 0, $parentId = 0)
    {
        $id = (int) $id;

        // Save
        if( !empty($this->data) )
        {
            // Set data
            $data = $this->data['MenusMenu'];
            $data['name'] = $menuName;
            $data['lang'] = $lang;

            if(empty($data['position']))
            {
                $data['position'] = 0;
            }

            if( $this->MenusMenu->save($data) )
            {
                $this->Session->setFlash(__d('cms', 'The menu item has been saved'), 'default', array('class' => 'information'));

                if(empty($this->data['MenusMenu']['parent_id']))
                {
                    return $this->redirect("/cms/menus/view/$lang/$menuName");
                }
                else
                {
                    return $this->redirect("/cms/menus/edit/$lang/$menuName/" . $this->data['MenusMenu']['parent_id']);
                }
            }
        }
        else // Retrieve info
        {
            $this->data = $this->MenusMenu->findById($id);
        }

        // data
        $this->set('lang', $lang);
        $this->set('menuName', $menuName);
        $this->set('parentId', $parentId);

        // SubMenu
        if($id != 0)
        {
            $this->MenusMenu->recursive = 1;
            $subMenus = $this->MenusMenu->find('all', array('conditions' => array('parent_id' => $id), 'order' => 'MenusMenu.position'));
        }
        else
        {
            $subMenus = array();
        }
        $this->set('subMenus', $subMenus);

        // Pages
        $pages = $this->PagesPage->find( 'all', array(
                                                'order' => 'PagesPage.title',
                                                'conditions' => array('PagesPage.publish' => 1, 'PagesPage.lang' => $lang) )
        );

        // Filter pages that are already in this menu
        foreach($pages as $key => $page)
        {
            $menuCheck = $this->MenusMenu->find('all', array(
                                                        'conditions' => array(
                                                            'MenusMenu.lang' => $lang,
                                                            'MenusMenu.name' => $menuName,
                                                            'MenusMenu.link' => '/' . $page['PagesPage']['url']
                                                        )
                                                    )
            );

            if(!empty($menuCheck))
            {
                unset($pages[$key]);
            }
        }
        $this->set('pages', $pages);
        $this->set('langName', Language::name($lang));

        if(!empty($parentId))
        {
            $menuSub = 'sub-menu';
        }
        else
        {
            $menuSub = 'menu';
        }

        // Breadcrumb
        if( empty($id) )
        {
            $this->Breadcrumb->addCrumb(__d('cms', "New $menuSub item"));
            $this->set('pageTitle', __d('cms', "New $menuSub item"));
        }
        else
        {
            $this->Breadcrumb->addCrumb(__d('cms', "Edit $menuSub item"));
            $this->set('pageTitle', __d('cms', "Edit $menuSub item"));
        }
    }


    public function delete($lang, $menuName, $id, $parentId = 0)
    {
        $id = (int) $id;

        $this->MenusMenu->id = $id;
        $this->MenusMenu->delete($id);

        if(empty($parentId))
        {
            return $this->redirect('/cms/menus/view/' . $lang . '/' . $menuName);
        }
        else
        {
            return $this->redirect('/cms/menus/edit/' . $lang . '/' . $menuName . '/' . $parentId);
        }
    }

}
