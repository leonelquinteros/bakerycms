<?php
class MenusCmsController extends MenusAppController
{
    public $uses = array('Menus.MenusMenu', 'Pages.PagesPage');

    public $components = array('CmsLogin', 'Breadcrumb', 'CmsMenu');

    public $helpers = array('CmsBreadcrumb', 'CmsWelcome', 'Language', 'Form');


    public function beforeFilter()
    {
        // Disables browser cache
        $this->disableCache();

        // Sets layout
        $this->layout = "cms/cms";

        // Checks login
        $this->CmsLogin->checkAdminLogin();

        $this->Breadcrumb->addCrumb(__d('cms', 'Home'), '/cms');

        if( $this->action == 'index' )
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Menu structure'));
        }
        else
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Menu structure'), '/cms/menus');
        }

        $cmsMenu = $this->CmsMenu->getMenu();
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
        $this->CmsLogin->checkAdminRestriction('index');

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
