<?php
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
