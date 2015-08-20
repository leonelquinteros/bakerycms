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
class AdminsCmsController extends AdminsAppController
{
    public $uses = array('Admins.AdminsAdmin', 'Admins.AdminsAdminsRestriction', 'Pages.PagesPage');

    public $components = array('BakeryLogin', 'Breadcrumb', 'BakeryMenu');

    public $helpers = array('CmsBreadcrumb', 'Form');


    public function beforeFilter()
    {
        // Disables browser cache
        $this->disableCache();

        // Sets layout
        $this->layout = "bakery/default";

        // Checks login
        $this->BakeryLogin->checkAdminLogin();

        $this->Breadcrumb->addCrumb(__d('cms', 'Home'), '/bakery');

        if( $this->action == 'index' )
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Administrators'));
        }
        else
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Administrators'), '/bakery/admins');
        }

        $cmsMenu = $this->BakeryMenu->getMenu();
        $this->set('cmsMenu', $cmsMenu);

        $this->set('pageTitle', 'Administrators');
    }


    public function beforeRender()
    {
        parent::beforeRender();

        $this->set( 'breadcrumb', $this->Breadcrumb->getBreadcrumb() );
    }


    public function index()
    {
        $admins = $this->AdminsAdmin->find( 'all', array('order' => 'AdminsAdmin.login') );
        $this->set('admins', $admins);
        $this->set('pageTitle', __d('cms', 'Administrators') );
        $this->set('isSuperAdmin', $this->BakeryLogin->isSuperAdmin());
    }


    public function edit($id = 0)
    {
        $id = (int) $id;

        // Save
        if( !empty($this->request->data) )
        {
            if( $this->AdminsAdmin->save($this->request->data['AdminsAdmin']) )
            {
                $this->Flash->success(__d('cms', 'The administrator has been saved'));
                
                return $this->redirect('/bakery/admins');
            }
        }
        else // Retrieve info
        {
            $this->data = $this->AdminsAdmin->findById($id);

            // Clear password.
            $this->request->data['AdminsAdmin']['pass'] = '';
        }


        // Breadcrumb
        if( empty($id) )
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'New Administrator'));
            $this->set('pageTitle', __d('cms', 'New Administrator'));
        }
        else
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Edit ') . $this->data['AdminsAdmin']['name']);
            $this->set('pageTitle', __d('cms', 'Edit ') . $this->data['AdminsAdmin']['name']);
        }
    }


    public function rights($id)
    {
        $this->BakeryLogin->checkAdminRestriction('edit');

        $this->data = $this->AdminsAdmin->findById($id);

        $restrictions = $this->AdminsAdminsRestriction->find('all', array('conditions' => array('AdminsAdminsRestriction.admins_admins_id' => $id)));
        $plugins = CakePlugin::loaded();

        $rights = array();
        foreach($plugins as $plugin)
        {
            // All rights by default
            $rights[$plugin] = array('index' => false, 'edit' => false, 'delete' => false);

            // Check restrictions
            if(!empty($restrictions))
            {
                foreach($restrictions as $res)
                {
                    if($res['AdminsAdminsRestriction']['plugin'] == $plugin)
                    {
                        $rights[$plugin][$res['AdminsAdminsRestriction']['action']] = $res['AdminsAdminsRestriction']['id'];
                    }
                }
            }
        }

        $this->set('adminId', $id);

        $this->set('rights', $rights);

        // Breadcrumb
        $this->Breadcrumb->addCrumb(__d('cms', 'Administrator rights'));
        $this->set('pageTitle', __d('cms', 'Administrator rights'));
    }


    public function add_restriction($adminId, $plugin, $operation)
    {
        $this->BakeryLogin->checkAdminRestriction('edit');

        App::import('Model', 'Admins.AdminsAdminsRestriction');

        $restriction = new AdminsAdminsRestriction();
        $data = $restriction->create();

        $data['AdminsAdminsRestriction']['admins_admins_id'] = $adminId;
        $data['AdminsAdminsRestriction']['plugin'] = $plugin;
        $data['AdminsAdminsRestriction']['action'] = $operation;

        $restriction->save($data['AdminsAdminsRestriction']);

        return $this->redirect('/bakery/admins/rights/' . $adminId);
    }


    public function remove_restriction($restrictionId)
    {
        $this->BakeryLogin->checkAdminRestriction('edit');

        App::import('Model', 'Admins.AdminsAdminsRestriction');
        $restriction = new AdminsAdminsRestriction();

        $data = $restriction->findById($restrictionId);

        $restriction->delete($restrictionId);

        return $this->redirect('/bakery/admins/rights/' . $data['AdminsAdminsRestriction']['admins_admins_id']);
    }

    public function remove_access($accessId)
    {
        $this->BakeryLogin->checkAdminRestriction('edit');

        $data = $this->AdminsAdminsPage->findById($accessId);

        $this->AdminsAdminsPage->delete($accessId);

        return $this->redirect('/bakery/admins/rights/' . $data['AdminsAdminsPage']['id_admins_admins']);
    }

    public function add_access($adminId, $pageId, $galleryId)
    {
        $this->BakeryLogin->checkAdminRestriction('edit');

        $data = $this->AdminsAdminsPage->create();
        $data['AdminsAdminsPage']['id_admins_admins'] = $adminId;
        $data['AdminsAdminsPage']['id_pages_pages'] = $pageId;
        $data['AdminsAdminsPage']['id_slides_galleries'] = $galleryId;

        $this->AdminsAdminsPage->save($data);

        return $this->redirect('/bakery/admins/rights/' . $adminId);
    }


    public function delete($id)
    {
        $id = (int) $id;

        $this->AdminsAdmin->id = $id;
        $this->AdminsAdmin->delete();

        return $this->redirect('/bakery/admins');
    }

}
