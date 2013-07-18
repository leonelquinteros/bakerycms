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
