<?php
/**
 * SubmenuHelper
 * Helper class to retrieve submenu data from entire menu information.
 *
 * @author Leonel Quinteros
 *
 */
class SubmenuHelper extends AppHelper
{
    /**
     * getSubMenu()
     * Returns submenu data array for provided page URL.
     *
     * @author Leonel Quinteros
     *
     * @param (string) $url Page URL.
     * @param (array) $menuData Full menu information array.
     *
     * @return (array) Submenu information.
     */
    public function getSubMenu($url, $menuData)
    {
        // First level menus
        foreach($menuData as $menuName => $menu)
        {
            // First level menu items
            foreach($menu as $index => $menuItem)
            {
                if($menuItem['MenusMenu']['link'] == '/' . $url)
                {
                    // Return first level submenu
                    return $this->markActives($url, $menuItem['subMenu']);
                }
                elseif(!empty($menuItem['subMenu']) && is_array($menuItem['subMenu']))
                {
                    // Browse first level submenu
                    foreach($menuItem['subMenu'] as $subIndex => $subMenu)
                    {
                        if($subMenu['MenusMenu']['link'] == '/' . $url)
                        {
                            // Return first level submenu
                            return $this->markActives($url, $menuItem['subMenu']);
                        }
                        elseif(!empty($subMenu['subMenu']) && is_array($subMenu['subMenu']))
                        {
                            // Browse second level submenu.
                            foreach($subMenu['subMenu'] as $subSubIndex => $subSubMenu)
                            {
                                if($subSubMenu['MenusMenu']['link'] == '/' . $url)
                                {
                                    // Return first level submenu
                                    return $this->markActives($url, $menuItem['subMenu']);
                                }
                                elseif(!empty($subSubMenu['subMenu']) && is_array($subSubMenu['subMenu']))
                                {
                                    // Browse third level submenu.
                                    foreach($subSubMenu['subMenu'] as $thirdSubIndex => $thirdSubMenu)
                                    {
                                        if($thirdSubMenu['MenusMenu']['link'] == '/' . $url)
                                        {
                                            // Return first level submenu
                                            return $this->markActives($url, $menuItem['subMenu']);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // Fallback empty array.
        return array();
    }


    /**
     * markActives()
     * Gets a filtered submenu and marks active menu elements by URL.
     *
     * @author Leonel Quinteros
     *
     * @param (string) $url Page URL.
     * @param (array) $menuData submenu information array.
     *
     * @return (array) Submenu information.
     */
    private function markActives($url, $menuData)
    {
        // First level menu items
        foreach($menuData as $index => $menuItem)
        {
            if($menuItem['MenusMenu']['link'] == '/' . $url)
            {
                $menuData[$index]['active'] = true;
                break;
            }
            elseif(!empty($menuItem['subMenu']) && is_array($menuItem['subMenu']))
            {
                // Browse second level submenu
                foreach($menuItem['subMenu'] as $subIndex => $subMenu)
                {
                    if($subMenu['MenusMenu']['link'] == '/' . $url)
                    {
                        $menuData[$index]['active'] = true;
                        $menuData[$index]['subMenu'][$subIndex]['active'] = true;
                        break(2);
                    }
                    elseif(!empty($subMenu['subMenu']) && is_array($subMenu['subMenu']))
                    {
                        // Browse third level submenu
                        foreach($subMenu['subMenu'] as $thirdIndex => $thirdMenu)
                        {
                            if($thirdMenu['MenusMenu']['link'] == '/' . $url)
                            {
                                $menuData[$index]['active'] = true;
                                $menuData[$index]['subMenu'][$subIndex]['active'] = true;
                                $menuData[$index]['subMenu'][$subIndex]['subMenu'][$thirdIndex]['active'] = true;
                                break(3);
                            }
                        }
                    }
                }
            }
        }

        return $menuData;
    }
}
