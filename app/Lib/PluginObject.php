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
abstract class PluginObject {
    /**
     * @var (boolean) This plugin has a CMS module. This means that implements the [pluginName]_cms_controller.php convention.
     */
    protected $_hasCmsModule = true;

    /**
     * @var (string) Show in CMS home.
     */
    protected $_showInCmsHome = true;

    /**
     * @var (string) Show in CMS menu.
     */
    protected $_showInBakeryMenu = true;

    /**
     * @var (boolean) Is a submenu.
     */
    protected $_isCmsSubMenu = false;

    /**
     * @var (string) Plugin name of the father menu.
     */
    protected $_cmsMenuFather = '';

    /**
     * @var (boolean) Only Super Admins have access.
     */
    protected $_restricted = false;


    /*
     * Getters
     */
    // MUST be implemented.
    public function getCmsModuleName()
    {
        return __d('cms', 'No name');
    }

    public function hasCmsModule()
    {
        return $this->_hasCmsModule;
    }

    public function showInCmsHome() {
        return ($this->_hasCmsModule && $this->_showInCmsHome);
    }

    public function showInBakeryMenu() {
        return ($this->_hasCmsModule && $this->_showInBakeryMenu);
    }

    public function isCmsSubMenu() {
        return ($this->_hasCmsModule && $this->_isCmsSubMenu);
    }

    public function getBakeryMenuFather()
    {
        return $this->_cmsMenuFather;
    }

    public function isRestricted()
    {
        return $this->_restricted;
    }
}
