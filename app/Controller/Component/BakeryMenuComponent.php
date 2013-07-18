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

/**
 * BakeryMenu
 * CMS menu generator.
 * It searches into the plugins for the ones that have a [PluginName]CmsController.
 * Generates the menu using a "Plugin CMS Controller Class" convention that is:
 *      - Every Plugin's CMS module will have a method called "getCmsModuleName" and will map the standard route:
 *          /cms/[PluginName]/
 *          Where the "index" Action will be the one that shows the "Module's Home" in the CMS.
 *      - Every Plugin's CMS module will use the "cms" layout.
 *      - Every Plugin's CMS module MUST implement the route:
 *          /cms/[PluginName]/
 *
 */

App::import('Lib', 'Plugin');

class BakeryMenuComponent extends Component
{
    public $components = array('I18n');

    private $_menu;

    public function __construct( ComponentCollection $collection, $settings = array() )
    {
        parent::__construct($collection, $settings);

        $this->_menu = array();
    }


    /**
     * getMenu()
     * Obtains the top menu from Plugin library.
     * Handles cache.
     *
     * @return (array)
     */
    public function getMenu()
    {
        $lang = $this->I18n->getLanguage();

        $menu = Cache::read('components-BakeryMenu-getMenu-' . $lang, 'default');

        if($menu === false)
        {
            $menu = Plugin::getCmsModulesMenu();
            Cache::write('components-BakeryMenu-getMenu-' . $lang, $menu, 'default');
        }

        return $menu;
    }
}
