<?php
class PagesCmsController extends PagesAppController
{
    public $uses = array('Pages.PagesPage', 'Pages.PagesPageContent', 'Menus.MenusMenu');
    public $components = array('CmsLogin', 'Breadcrumb', 'CmsMenu');
    public $helpers = array('CmsBreadcrumb', 'CmsWelcome', 'Form');

    public $paginate = array(
                            'PagesPage' => array(
                                            'limit' => 20,
                                            'order' => array(
                                                'PagesPage.title' => 'ASC'
                                            )
                            )
    );

    public function beforeFilter()
    {
        // Disables browser cache
        $this->disableCache();

        // Sets layout
        $this->layout = "cms/cms";

        // Checks login
        $this->CmsLogin->checkAdminLogin();

        // Breadcrumb
        $this->Breadcrumb->addCrumb(__d('cms', 'Home'), '/cms');
        if( $this->action == 'index' )
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Pages'));
        }
        else
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Pages'), '/cms/pages');
        }

        // Menu
        $cmsMenu = $this->CmsMenu->getMenu();
        $this->set('cmsMenu', $cmsMenu);

        // Default title. To override.
        $this->set('pageTitle', 'Pages');
    }


    public function beforeRender()
    {
        parent::beforeRender();

        $this->set( 'breadcrumb', $this->Breadcrumb->getBreadcrumb() );
    }


    public function index()
    {
        $pages = $this->paginate('PagesPage');

        $this->set('pages', $pages);
        $this->set('pageTitle', __d('cms', 'CMS Pages') );
    }

    public function search()
    {
        $this->CmsLogin->checkAdminRestriction('index');

        App::import('Core', 'Sanitize');

        if(!empty($_POST['q']))
        {
            $this->set('keyword', $_POST['q']);
            $keyword = Sanitize::escape($_POST['q']);

            $pages = $this->PagesPage->query(
                "SELECT DISTINCT PagesPage.*
                    FROM pages_pages AS PagesPage
                    LEFT JOIN pages_page_contents AS PagesPageContent
                        ON PagesPageContent.pages_pages_id = PagesPage.id
                    WHERE   PagesPage.title LIKE '%$keyword%' OR
                            PagesPage.url LIKE '%$keyword%' OR
                            PagesPage.seo_title LIKE '%$keyword%' OR
                            PagesPage.seo_keywords LIKE '%$keyword%' OR
                            PagesPage.seo_description LIKE '%$keyword%' OR
                            PagesPageContent.content LIKE '%$keyword%'"
            );

            $this->set('pages', $pages);
            $this->set('pageTitle', __d('cms', 'CMS Pages search') );
        }
        else
        {
            return $this->redirect('/cms/pages');
        }
    }

    public function edit($id = 0)
    {
        $id = (int) $id;

        // Save
        if( !empty($this->data) )
        {
            // Save basic data
            if( $this->PagesPage->save($this->data['PagesPage']) )
            {
                // Go edit content handler
                if( !empty($_POST['goEditContent']) )
                {
                    $this->data = $this->PagesPage->read();
                    $id = $this->PagesPage->id;
                    $this->set('goEditContent', true);
                }
                else
                {
                    $this->Session->setFlash(__d('cms', 'The page has been saved'), 'default', array('class' => 'information'));
                    return $this->redirect('/cms/pages');
                }
            }
        }
        else // Retrieve info
        {
            $this->data = $this->PagesPage->findById($id);
        }

        // Layouts
        $this->set('layouts', $this->PagesPage->getPageLayoutsList());

        // Languages
        $langs = Language::getLanguages();
        $this->set('languages', $langs);

        // Menu
        $menus = explode(',', SITE_MENUS);
        $aMenus = array();

        if(!empty($id))
        {
            foreach($langs as $lang => $languageName)
            {
                $aMenus[$lang] = array();

                foreach($menus as $menu)
                {
                    $m = $this->MenusMenu->find('first', array('conditions' => array(
                                                                        'MenusMenu.name' => $menu,
                                                                        'MenusMenu.lang' => $lang,
                                                                        'MenusMenu.link' => '/' . $this->data['PagesPage']['url']
                                                                    )
                                                            )
                    );

                    $aMenus[$lang][$menu] = $m;
                }
            }

            $this->set('menus', $aMenus);
        }

        // Breadcrumb
        if( empty($id) )
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'New Page'));
            $this->set('pageTitle', __d('cms', 'New Page'));
        }
        else
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Edit Page '));
            $this->set('pageTitle', __d('cms', 'Edit Page '));
        }
    }


    public function edit_content($id)
    {
        $this->CmsLogin->checkAdminRestriction('edit');

        $this->layout = 'default';

        $this->set('editMode', true);

        // Retrieves menu for layout
        $this->set('menuData', $this->MenusMenu->getPageMenu(DEFAULT_SUPPORTED_LANGUAGE));

        // Gets and sets content
        $pageData = $this->PagesPage->findById(intval($id));

        $this->set('page', $pageData);

        $this->set('pageContent', $this->PagesPage->getContent( $pageData['PagesPage']['id']) );

        $this->set('pageTitle', $pageData['PagesPage']['title']);
        $this->set('seoTitle', $pageData['PagesPage']['seo_title']);
        $this->set('seoKeywords', $pageData['PagesPage']['seo_keywords']);
        $this->set('seoDescription', $pageData['PagesPage']['seo_description']);
    }


    public function delete($id)
    {
        $id = (int) $id;

        $this->PagesPage->id = $id;
        $this->PagesPage->delete();

        return $this->redirect('/cms/pages');
    }

}
