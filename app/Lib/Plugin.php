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
class Plugin
{
    /**
     * hasCMsModule()
     * Checks if it has a CMS module following the path controller convention:
     *      app/plugins/[pluginName]/controllers/[pluginName]_cms_controller.php
     *
     * @param (string) $pluginName The plugin name to check.
     *
     * @return (boolean) TRUE if it has a CMS module. FALSE if not.
     */
    public static function hasCmsModule($pluginName)
    {
        if( CakePlugin::loaded($pluginName) )
        {
            if( is_file(CakePlugin::path($pluginName) . "/Controller/$pluginName" . "CmsController.php") )
            {
                return true;
            }
        }

        return false;
    }


    /**
     * loadPluginObject()
     * Loads and return an instance of the plugin configuration object.
     *
     * @param (string) $pluginName
     * @return ([pluginName]Plugin) Plugin object instance
     */
    public static function loadPluginObject($pluginName)
    {
        $className  = $pluginName . 'Plugin';
        $path       = CakePlugin::path($pluginName) . '/Config/plugin.php';

        $pluginObject = false;

        if( is_file($path) )
        {
            include_once($path);
            $pluginObject = new $className();
        }

        return $pluginObject;
    }


    /**
     * getPluginName()
     * Returns the display name for a given plugin
     *
     * @param (string) $plugin
     * @return (string) Plugin name
     *
     */
    public static function getPluginName($plugin)
    {
        $pluginObject = self::loadPluginObject($plugin);

        if(!empty($pluginObject))
        {
            return $pluginObject->getCmsModuleName();
        }
        else
        {
            return false;
        }
    }


    /**
     * getCmsModulesMenu()
     * Creates an array with all the CMS menu items retrieved from the installed plugins.
     *
     * @return (array) The CMS menu array.
     */
    public static function getCmsModulesMenu()
    {
        $modulesMenu = array();
        $installedPlugins = CakePlugin::loaded();

        // First load main menu.
        foreach($installedPlugins as $pluginName)
        {
            $pluginObject = self::loadPluginObject($pluginName);

            if($pluginObject && $pluginObject->showInBakeryMenu() && !$pluginObject->isCmsSubMenu())
            {
                $modulesMenu[] = array( 'plugin' => $pluginName,
                                        'name' => $pluginObject->getCmsModuleName(),
                                        'link' => '/bakery/' . Inflector::underscore($pluginName),
                                        'submenu' => array()
                );
            }
        }

        // Then searches for submenu
        foreach($installedPlugins as $pluginName)
        {
            $pluginObject = self::loadPluginObject($pluginName);

            if($pluginObject && $pluginObject->showInBakeryMenu() && $pluginObject->isCmsSubMenu())
            {
                for($i = 0; $i < count($modulesMenu); $i++)
                {
                    if($modulesMenu[$i]['plugin'] == $pluginObject->getBakeryMenuFather())
                    {
                        $modulesMenu[$i]['submenu'][] = array(
                                                            'plugin' => $pluginName,
                                                            'name' => $pluginObject->getCmsModuleName(),
                                                            'link' => '/bakery/' . Inflector::underscore($pluginName),
                        );
                    }
                }
            }
        }

        // Returns the array
        return $modulesMenu;
    }
}
