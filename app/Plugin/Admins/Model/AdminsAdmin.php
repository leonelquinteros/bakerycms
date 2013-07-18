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
class AdminsAdmin extends AdminsAppModel
{
    public $name = 'AdminsAdmin';
    public $recursive = -1;

    public $hasMany = array(
                        'AdminsAdminsRestriction' => array(
                                            'className' => 'AdminsAdminsRestriction',
                                            'foreignKey' => 'admins_admins_id',
                        )
    );


    public $validate = array(
                        'login' => array(
                                    'loginRequiredRule' => array(
                                            'rule' => 'alphaNumeric',
                                            'required' => true,
                                            'allowEmpty' => false,
                                            'message' => 'Translate this',
                                    ),
                                    'loginUniqueRule' => array(
                                            'rule' => 'isUnique',
                                            'message' => 'Translate this',
                                    ),
                        ),
                        'pass' => array(
                                    'passwordRule' => array(
                                        'rule' => 'validateAdminPassword',
                                        'message' => 'Translate this',
                                    )
                        ),
                        'name' => array(
                                    'notEmpty' => array(
                                            'rule' => array('minLength', 1),
                                            'required' => true,
                                            'allowEmpty' => false,
                                            'message' => 'Translate this',
                                    ),
                        ),
    );


    /**
     * validateAdminPassword()
     * Custom validation method for Administrator's passwords.
     * If it's a new record, validates that password are not empty.
     *
     * @param (array) $check
     * @return (boolean)
     */
    public function validateAdminPassword($check)
    {
        // If it's a new record, this field is mandatory.
        if( empty($this->data['AdminsAdmin']['id']) )
        {
            return !empty( $check['pass'] );
        }
        else
        {
            return true;
        }
    }


    /**
     * beforeSave()
     * Converts passwords to SHA1 before save, or retrieves old password if empty.
     *
     * @see cake/libs/model/Model#beforeSave($options)
     */
    public function beforeSave($options = array())
    {
        if( !empty($this->data['AdminsAdmin']['pass']) )
        {
            $this->data['AdminsAdmin']['pass'] = sha1( $this->data['AdminsAdmin']['pass'] );
        }
        else
        {
            // We assume that this is not a new admin, because if the password is empty will not validate on validateAdminPassword().
            $oldAdmin = $this->findById($this->data['AdminsAdmin']['id']);

            $this->data['AdminsAdmin']['pass'] = $oldAdmin['AdminsAdmin']['pass'];
        }

        return true;
    }
}
