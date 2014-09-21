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

class ProductsCategory extends ProductsAppModel
{
    public $name = 'ProductsCategory';
    public $recursive = -1;

    public $hasMany = array(
                            'Products' => array(
                                        'className' => 'Products.ProductsProduct',
                                        'foreignKey' => 'category_id',
                                        'order'     => 'name',
                                        'dependent' => true,
                        )
    );


    /**
     * afterSave()
     * Clear cache
     */
    public function afterSave($created, $options = array())
    {
        $this->clearCache($this->data['ProductsCategory']['url'], $this->id);

        return true;
    }

    /**
     * beforeDelete()
     * Clear cache.
     */
    public function beforeDelete($cascade = true)
    {
        $data = $this->find('first', array('conditions' => array('ProductsCategory.id' => $this->id)));
        $this->clearPageCache($data['ProductsCategory']['url'], $this->id);

        return true;
    }

    /**
     * clearCache()
     * Deletes cached information.
     */
    public function clearCache($url, $id = 0)
    {
        Cache::delete('plugins-products-models-products_category-get_category-' . $url, 'permanent');
    }


    public function getCategory($url)
    {
        $data = Cache::read('plugins-products-models-products_category-get_category-' . $url, 'permanent');

        if($data === false)
        {
            $data = $this->find('first', array(
                                            'conditions' =>  array('ProductsCategory.url' => $url),
                                            'recursive' => 2,
                                        )
                    );

            if(!empty($data))
            {
                Cache::write('plugins-products-models-products_category-get_category-' . $url, $data, 'permanent');
            }
        }

        return $data;
    }
}
