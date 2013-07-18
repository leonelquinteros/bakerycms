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

App::import('Lib', 'Plugin');

class CmsController extends AppController
{
    public $name = "Cms";
    public $uses = array('Admins.AdminsAdmin', 'Pages.PagesPage');
    public $components = array('CmsLogin', 'Breadcrumb', 'CmsMenu');
    public $helpers = array('CmsBreadcrumb', 'CmsWelcome', 'Text');

    public function beforeFilter()
    {
        // Disables browser cache
        $this->disableCache();

        //Set layout
        $this->layout = 'cms/cms';

        // Checks login
        if($this->request->params['action'] != 'login' && $this->request->params['action'] != 'logout' && $this->request->params['action'] != 'configure')
        {
            $this->CmsLogin->checkAdminLogin();
        }

        $this->Breadcrumb->addCrumb(__d('cms', 'Home'), '');

        $cmsMenu = $this->CmsMenu->getMenu();
        $this->set('cmsMenu', $cmsMenu);

        $this->set('pageTitle', __d('cms', 'Empowered CMS') );
    }


    public function beforeRender()
    {
        parent::beforeRender();

        $this->set('breadcrumb', $this->Breadcrumb->getBreadcrumb());
    }


    /**
     * configure()
     *
     * Shows a message when Admin plugin is not installed.
     * Admin plugin should be a MUST dependency for every plugin with CMS interface.
     * Handled by Login component.
     */
    public function configure()
    {
        echo __d('cms', 'You need to install some modules yet...');
        exit;
    }

    public function index()
    {
        $this->set('pageTitle', __d('cms', 'Home') );

        $pages = $this->PagesPage->find('all', array('order' => 'PagesPage.id DESC', 'limit' => '5'));
        $this->set('pages', $pages);
    }

    public function login()
    {
        if( !empty($_POST) )
        {
            if( !empty($_POST['user']) && !empty($_POST['pass']) )
            {
                if ( !$this->CmsLogin->doLogin($_POST['user'], $_POST['pass']) )
                {
                    $this->Session->setFlash(__d('cms', 'Login incorrect'));
                }
            }
            else
            {
                $this->Session->setFlash(__d('cms', 'Login incorrect'));
            }

        }

        $this->set('pageTitle', __d('cms', 'Welcome') );

        $this->Breadcrumb->clear();
    }

    public function logout()
    {
        $this->CmsLogin->doLogout();
        return $this->redirect('/cms');
    }

}