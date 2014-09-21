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

class ProductsProduct extends ProductsAppModel
{
    public $name = 'ProductsProduct';
    public $recursive = 1;

    public $belongsTo = array(
                            'Category' => array(
                                        'className' => 'Products.ProductsCategory',
                                        'foreignKey' => 'category_id',
                        )
    );

    public $hasMany = array(
                            'Images' => array(
                                        'className' => 'Products.ProductsImage',
                                        'foreignKey' => 'product_id',
                            )
    );


    public $validate = array(
                        'name' => array(
                                    'notEmptyRule' => array(
                                            'rule' => 'notEmpty',
                                            'required' => true,
                                            'allowEmpty' => false,
                                            'message' => 'Translate this',
                                    )
                        ),
                        'url' => array(
                                    'urlRule' => array(
                                            'rule' => 'isUnique',
                                            'required' => true,
                                            'allowEmpty' => false,
                                            'message' => 'Translate this',
                                    )
                        ),
    );


    /**
     * beforeValidate()
     * Converts URLs to Inflector::slug() before save.
     */
    public function beforeValidate($options = array())
    {
        if( !empty($this->data['ProductsProduct']['url']) )
        {
            $this->data['ProductsProduct']['url'] = Inflector::slug( strtolower($this->data['ProductsProduct']['url']), '-' );
        }
        else
        {
            $this->data['ProductsProduct']['url'] = Inflector::slug( strtolower($this->data['ProductsProduct']['name']), '-' );
        }

        return true;
    }

}
