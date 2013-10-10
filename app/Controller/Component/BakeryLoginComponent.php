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
class BakeryLoginComponent extends Component
{
    public $controller;
    public $components = array('Session', 'Cookie');

    //called before Controller::beforeFilter()
    function initialize( Controller $controller ) {
        $this->controller =& $controller;
    }


    /**
     * isLoggedIn()
     * Returns TRUE if an administrator is logged into the system.
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        $adminLogin = $this->getLoggedInAdmin();
        return !empty($adminLogin);
    }

    /**
     * isSuperAdmin()
     * Checks if the logged administrator is a super-admin.
     *
     * @return (boolean)
     */
    public function isSuperAdmin()
    {
        $return = false;

        if($this->isLoggedIn())
        {
            $admin = $this->getLoggedInAdmin();
            if($admin['AdminsAdmin']['super_admin'])
            {
                $return = true;
            }
        }

        return $return;
    }

    /**
     * getLoggedInAdmin()
     * Returns the SESSION array with the logged administrator's information
     *
     * @return (array)
     */
    public function getLoggedInAdmin()
    {
        $admin = false;

        // Load cookie admin if session expired.
        if(!$this->Session->check('CMSAdministratorLogin'))
        {
            $admin = unserialize(base64_decode($this->Cookie->read('CMSAdministratorLogin')));

            if(!empty($admin))
            {
                App::import('Model', 'Admins.AdminsAdmin');
                $adminModel = new AdminsAdmin();
                $adminData = $adminModel->findById($admin['AdminsAdmin']['id']);

                if( !empty($adminData) )
                {
                    if( $adminData['AdminsAdmin']['pass'] == $admin['AdminsAdmin']['pass'] )
                    {
                        $this->Session->write('CMSAdministratorLogin', $admin);
                        $this->Cookie->write('CMSAdministratorLogin',  base64_encode(serialize($admin)), true, 7200); // 2 hours
                    }
                    else
                    {
                        $admin = false;
                    }
                }
                else
                {
                    $admin = false;
                }
            }
            else
            {
                $admin = false;
            }
        }
        else
        {
            $admin = $this->Session->read('CMSAdministratorLogin');

            // Update cookie time
            $this->Cookie->write('CMSAdministratorLogin',  base64_encode(serialize($admin)), true, 7200); // 2 hours
        }

        return $admin;
    }

    /**
     * checkAdminLogin()
     * Checks for a login session of an administrator.
     * Uses Admins plugin.
     */
    public function checkAdminLogin($restriction = '')
    {
        if( CakePlugin::loaded('Admins') )
        {
            if( !$this->isLoggedIn() && $this->controller->params['action'] != 'login' )
            {
                $goBack = Router::url();
                $this->Session->write('BakeryLoginReturnAddress', $goBack);

                $this->controller->redirect('/bakery/login');
                exit;
            }

            $this->checkAdminRestriction();
        }
        elseif( $this->controller->params['action'] != 'configure' )
        {
            $this->controller->redirect('/bakery/configure');
            exit;
        }
    }


    /**
     * checkAdminRestriction()
     * Checks for restrictions. If the action is not defined, will use the action name to check for 'index', 'edit' and 'delete' rights.
     */
    public function checkAdminRestriction($action = '')
    {
        $admin = $this->getLoggedInAdmin();
        $adminId = $admin['AdminsAdmin']['id'];

        $plugin = $this->controller->params['plugin'];

        // Check for plugin
        if(empty($plugin))
        {
            return true;
        }

        // Check plugin restriction
        $pluginObject = Plugin::loadPluginObject(ucfirst($plugin));

        if($pluginObject->isRestricted() && $admin['AdminsAdmin']['super_admin'] == 0)
        {
            // Not even a message. Just logout, this shouldn't be linked from anywhere. 
            $this->controller->redirect('/bakery/logout');
            exit;
        }

        // Check admin restriction
        if(empty($action) && ($this->controller->params['action'] == 'index' || $this->controller->params['action'] == 'edit' || $this->controller->params['action'] == 'delete') )
        {
            $action = $this->controller->params['action'];
        }

        // Check for valid action
        if($action != 'index' && $action != 'edit' && $action != 'delete')
        {
            return true;
        }

        App::import('Model', 'Admins.AdminsAdminsRestriction');
        $restriction = new AdminsAdminsRestriction();

        $hasRestriction = $restriction->find('all',
                            array('conditions' =>
                                    array(
                                        'AdminsAdminsRestriction.admins_admins_id' => $adminId,
                                        'AdminsAdminsRestriction.plugin' => $plugin,
                                        'AdminsAdminsRestriction.action' => $action
                                    )
                            )
        );

        if(!empty($hasRestriction))
        {
            $this->Session->setFlash(__d('cms', 'You have no rights to perform this action'));
            $this->controller->redirect('/bakery');
            exit;
        }
    }

    /**
     * doLogin()
     * Checks login credentials and sets the $_SESSION information if they are correct.
     *
     * @param string $username
     * @param string $password
     */
    public function doLogin($username, $password)
    {
        App::import('Model', 'Admins.AdminsAdmin');
        $adminModel = new AdminsAdmin();
        $adminData = $adminModel->findByLogin($username);

        if( !empty($adminData) )
        {
            if( $adminData['AdminsAdmin']['pass'] == sha1($password) )
            {
                $this->Session->write('CMSAdministratorLogin', $adminData);
                $this->Cookie->write('CMSAdministratorLogin',  base64_encode(serialize($adminData)), true, 7200);

                echo $goBack = $this->Session->read('BakeryLoginReturnAddress');

                if(!empty($goBack))
                {
                    $this->controller->redirect($goBack);
                }
                else
                {
                    $this->controller->redirect('/bakery');
                }

                return true;
            }
        }

        return false;
    }


    public function doLogout()
    {
        $this->Session->delete('CMSAdministratorLogin');
        $this->Cookie->delete('CMSAdministratorLogin');
        return true;
    }
}
