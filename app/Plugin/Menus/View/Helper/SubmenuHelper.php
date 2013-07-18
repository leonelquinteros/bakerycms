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
 * SubmenuHelper
 * Helper class to retrieve submenu data from entire menu information.
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
