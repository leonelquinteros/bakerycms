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
class ProductsCmsController extends ProductsAppController
{
    public $uses = array('Products.ProductsProduct', 'Products.ProductsCategory', 'Products.ProductsImage');

    public $components = array('BakeryLogin', 'Breadcrumb', 'BakeryMenu');

    public $helpers = array('CmsBreadcrumb', 'Form');

    public $paginate = array(
                            'ProductsProduct' => array(
                                            'limit' => 20,
                                            'order' => array(
                                                'ProductsProduct.name' => 'ASC'
                                            ),
                                            'contain' => array('Products.ProductsCategory'),
                            ),
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

        if( $this->action == 'index' )
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Products'));
        }
        else
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Products'), '/bakery/products');
        }

        $cmsMenu = $this->BakeryMenu->getMenu();
        $this->set('cmsMenu', $cmsMenu);

        $this->set('pageTitle', 'Products');
    }


    public function beforeRender()
    {
        parent::beforeRender();

        $this->set( 'breadcrumb', $this->Breadcrumb->getBreadcrumb() );
    }


    public function index()
    {
        $products = $this->paginate('ProductsProduct');

        $this->set('products', $products);
        $this->set('pageTitle', __d('cms', 'Products') );
    }


    public function search()
    {
        $this->BakeryLogin->checkAdminRestriction('index');

        App::import('Core', 'Sanitize');

        if(!empty($_POST['q']))
        {
            $this->set('keyword', $_POST['q']);
            $keyword = Sanitize::escape($_POST['q']);

            $products = $this->ProductsProduct->query(
                "SELECT DISTINCT ProductsProduct.*
                    FROM products_products AS ProductsProduct
                    LEFT JOIN products_categories AS ProductsCategory
                        ON ProductsProduct.category_id = ProductsCategory.id
                    WHERE   ProductsProduct.name LIKE '%$keyword%' OR
                            ProductsProduct.url LIKE '%$keyword%' OR
                            ProductsProduct.description LIKE '%$keyword%' OR
                            ProductsCategory.name LIKE '%$keyword%'"
            );

            $this->set('products', $products);
            $this->set('pageTitle', __d('cms', 'Product search') );
        }
        else
        {
            return $this->redirect('/bakery/products');
        }

        $this->Breadcrumb->addCrumb(__d('cms', 'Search'));
    }


    public function edit($id = 0)
    {
        $id = (int) $id;

        // Save
        if( !empty($this->request->data) )
        {
            if( $this->ProductsProduct->save($this->request->data['ProductsProduct']) )
            {
                $this->Session->setFlash(__d('cms', 'The product has been saved'), 'default', array('class' => 'information'));
                return $this->redirect('/bakery/products');
            }
        }
        else // Retrieve info
        {
            $this->data = $this->ProductsProduct->findById($id);
        }

        $this->set('categories', $this->ProductsCategory->find('list'));

        // Breadcrumb
        if( empty($id) )
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'New Product'));
            $this->set('pageTitle', __d('cms', 'New Product'));
        }
        else
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Edit ') . $this->data['ProductsProduct']['name']);
            $this->set('pageTitle', __d('cms', 'Edit ') . $this->data['ProductsProduct']['name']);
        }
    }


    public function add_image()
    {
        $this->layout = false;
        $this->autoRender = false;

        $this->ProductsImage->save($_POST);
    }


    public function delete($id)
    {
        $id = (int) $id;

        $this->ProductsProduct->id = $id;
        $this->ProductsProduct->delete();

        return $this->redirect('/bakery/products');
    }


    public function delete_image($id, $productId)
    {
        $id = (int) $id;

        $this->ProductsImage->id = $id;
        $this->ProductsImage->delete();

        return $this->redirect('/bakery/products/edit/' . $productId);
    }

}
