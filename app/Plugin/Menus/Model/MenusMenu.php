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
App::import('Lib', 'Language');

class MenusMenu extends MenusAppModel
{
    public $name = 'MenusMenu';
    public $recursive = -1;

    public $hasMany = array(
                            'SubMenu' => array(
                                        'className' => 'MenusMenu',
                                        'foreignKey' => 'parent_id',
                                        'order'     => 'position',
                                        'dependent' => true,
                        )
    );

    /**
     * clearMenuCache()
     * Deletes all cached menus for every language.
     */
    public function clearMenuCache()
    {
        App::import('Model', 'Pages.PagesPage');
        $page = new PagesPage();

        $pages = $page->find('all', array('conditions' => array('publish' => 1)));
        $langs = Language::getLanguages();

        foreach($langs as $lang => $name)
        {
            Cache::delete('plugins-menus-models-menus_menu-get_page_menu-' . $lang . '-/', 'default');
            Cache::delete('plugins-menus-models-menus_menu-get_page_menu-' . $lang . '-', 'default');

            foreach($pages as $p)
            {
                Cache::delete('plugins-menus-models-menus_menu-get_page_menu-' . $lang . '-/' . $p['PagesPage']['url'], 'default');
            }
        }
    }

    /**
     * afterSave()
     * Clear menu cache
     */
    public function afterSave($created)
    {
        $this->clearMenuCache();
        return true;
    }

    /**
     * afterDelete()
     * Clear menu cache
     */
    public function afterDelete()
    {
        $this->clearMenuCache();
        return true;
    }


    /**
     * getMenu()
     * Retrieves an array where each first level item represents a page menu.
     *
     * @param (string) lang     Language code
     *
     * @return (array)
     */
    public function getPageMenu($lang)
    {
        $menuData = Cache::read('plugins-menus-models-menus_menu-get_page_menu-' . $lang . '-' . $_SERVER['REQUEST_URI'], 'default');
        if($menuData === false)
        {
            $menuData = array();
            $menus = explode(',', SITE_MENUS);

            foreach($menus as $menuName)
            {
                $menuData[$menuName] = $this->find('all', array(
                                                            'conditions' => array('name' => $menuName, 'lang' => $lang, 'parent_id' => '0'),
                                                            'order' => 'MenusMenu.name, MenusMenu.position'
                                                        )
                );

                for($i = 0; $i < count($menuData[$menuName]); $i++)
                {
                    $menuData[$menuName][$i]['subMenu'] = $this->fillSubMenu($menuData[$menuName][$i], $menuData, $menuName, $i);

                    if($menuData[$menuName][$i]['MenusMenu']['link'] == $_SERVER['REQUEST_URI'])
                    {
                        $menuData[$menuName][$i]['active'] = true;
                    }
                }
            }

            Cache::write('plugins-menus-models-menus_menu-get_page_menu-' . $lang . '-' . $_SERVER['REQUEST_URI'], $menuData, 'default');
        }

        return $menuData;
    }

    /**
     * fillSubMenu()
     * Helper function to do recursion on getPageMenu()
     *
     * @param (array) menu  Menu data from model to obtain submenu.
     * @param (array) & menuData Top level menu data array by reference to mark the corresponding top level active item.
     * @param (string) menuName Top level menu name.
     * @param (mixed) meunData Top level menu index.
     *
     * @return (array)
     */
    private function fillSubMenu($menu, & $menuData, $menuName, $index)
    {
        $subMenu = $this->find('all', array(
                                            'conditions' => array('name' => $menu['MenusMenu']['name'], 'lang' => $menu['MenusMenu']['lang'], 'parent_id' => $menu['MenusMenu']['id']),
                                            'order' => 'MenusMenu.name, MenusMenu.position'
                                        )
        );

        for($i = 0; $i < count($subMenu); $i++)
        {
            // Find top level actives.
            if($menuName == 'Main')
            {
                if($subMenu[$i]['MenusMenu']['link'] == $_SERVER['REQUEST_URI'])
                {
                    $menuData[$menuName][$index]['active'] = true;
                }
            }

            // Submenu recursion
            $subMenu[$i]['subMenu'] = $this->fillSubMenu($subMenu[$i], $menuData, $menuName, $index);
        }

        return $subMenu;
    }

}
