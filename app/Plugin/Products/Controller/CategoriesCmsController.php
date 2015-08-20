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
class CategoriesCmsController extends ProductsAppController
{
    public $uses = array('ProductsProduct', 'ProductsCategory', 'ProductsImage');

    public $components = array('BakeryLogin', 'Breadcrumb', 'BakeryMenu');

    public $helpers = array('CmsBreadcrumb', 'Form');

    public $paginate = array(
                            'ProductsCategory' => array(
                                            'limit' => 20,
                                            'order' => array(
                                                'ProductsCategory.name' => 'ASC'
                                            )
                            )
    );


    public function beforeFilter()
    {
        // Disables browser cache
        $this->disableCache();

        // Sets layout
        $this->layout = "bakery/default";

        // Checks login
        $this->BakeryLogin->checkAdminLogin();

        $this->Breadcrumb->addCrumb(__d('cms', 'Home'), '/bakery');
        $this->Breadcrumb->addCrumb(__d('cms', 'Products'), '/bakery/products');

        if( $this->action == 'index' )
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Categories'));
        }
        else
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Categories'), '/bakery/products/categories');
        }

        $cmsMenu = $this->BakeryMenu->getMenu();
        $this->set('cmsMenu', $cmsMenu);

        $this->set('pageTitle', 'Categories');
    }


    public function beforeRender()
    {
        parent::beforeRender();

        $this->set( 'breadcrumb', $this->Breadcrumb->getBreadcrumb() );
    }


    public function index()
    {
        $categories = $this->paginate('ProductsCategory');

        $this->set('categories', $categories);
        $this->set('pageTitle', __d('cms', 'Categories') );
    }


    public function edit($id = 0)
    {
        $id = (int) $id;

        // Save
        if( !empty($this->request->data) )
        {
            if( $this->ProductsCategory->save($this->request->data['ProductsCategory']) )
            {
                $this->Session->setFlash(__d('cms', 'The category has been saved'), 'default', array('class' => 'information'));
                return $this->redirect('/bakery/products/categories');
            }
        }
        else // Retrieve info
        {
            $this->data = $this->ProductsCategory->findById($id);
        }


        // Breadcrumb
        if( empty($id) )
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'New Category'));
            $this->set('pageTitle', __d('cms', 'New Category'));
        }
        else
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Edit ') . $this->data['ProductsCategory']['name']);
            $this->set('pageTitle', __d('cms', 'Edit ') . $this->data['ProductsCategory']['name']);
        }
    }


    public function delete($id)
    {
        $id = (int) $id;

        $this->ProductsCategory->id = $id;
        $this->ProductsCategory->delete();

        return $this->redirect('/bakery/products/categories');
    }

}
