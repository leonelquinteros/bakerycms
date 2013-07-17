<?php
class SitemapController extends SitemapAppController
{
    public $uses = array();

    public function beforeFilter()
    {
        // Sets layout
        $this->layout = 'empty';
    }

    public function index()
    {
        header('Content-Type: text/xml; charset=UTF-8');

        App::import('Lib', 'Utils');
        $host = Utils::getUrlHost();

        $map = array();

        // Home page
        $map[] = array(
                        'loc'           => $host,
                        'priority'      => '1',
                        'changefreq'    => 'daily',
        );

        App::import('lib', 'Plugin');

        if(CakePlugin::loaded('Pages'))
        {
            App::import('model', 'Pages.PagesPage');
            $page = new PagesPage();

            $pages = $page->find('all', array('conditions' => array('PagesPage.publish' => 1, 'PagesPage.publish_date <=' => 'NOW()')));

            foreach($pages as $p)
            {
                $map[] = array(
                                'loc'           => $host . '/' . $p['PagesPage']['url'],
                                'priority'      => '1',
                                'changefreq'    => 'daily',
                );
            }
        }

        if(CakePlugin::loaded('Blog'))
        {
            $map[] = array(
                            'loc'           => $host . '/blog',
                            'priority'      => '0.5',
                            'changefreq'    => 'daily',
            );

            App::import('model', 'Blog.BlogPost');
            $blog = new BlogPost();

            $posts = $blog->find('all', array('conditions' => array('BlogPost.publish' => 1, 'BlogPost.publish_date <=' => 'NOW()')));

            foreach($posts as $p)
            {
                $map[] = array(
                                'loc'           => $host . '/post/' . $p['BlogPost']['url'],
                                'priority'      => '0.7',
                                'changefreq'    => 'daily',
                );
            }
        }

        $this->set('map', $map);
    }

}
