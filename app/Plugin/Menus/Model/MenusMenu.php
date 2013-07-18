<?php
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
