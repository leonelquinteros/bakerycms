<?php
$subMenuData = $this->Submenu->getSubMenu($page['PagesPage']['url'], $menuData);

if(!empty($subMenuData))
{
    ?>
    <ul class="submenu">
    <?php
    // First level
    foreach($subMenuData as $subMenuItem)
    {
        if($subMenuItem['MenusMenu']['hide'] == 0)
        {
            ?>
            <li class="submenu-item<?php if(!empty($subMenuItem['active'])) echo ' active'; ?><?php if(!empty($subMenuItem['MenusMenu']['class'])) echo ' ' . $subMenuItem['MenusMenu']['class']; ?>">
                <a class="submenu-link" href="<?php echo $subMenuItem['MenusMenu']['link']; ?>">
                    <?php echo $subMenuItem['MenusMenu']['title']; ?>
                </a>
                <?php
                // Second level
                if(!empty($subMenuItem['active']) && !empty($subMenuItem['subMenu']))
                {
                    ?>
                    <ul class="sub-submenu">
                    <?php

                    foreach($subMenuItem['subMenu'] as $subSubMenuItem)
                    {
                        if($subSubMenuItem['MenusMenu']['hide'] == 0)
                        {
                            ?>
                            <li class="sub-submenu-item<?php if(!empty($subSubMenuItem['active'])) echo ' active'; ?><?php if(!empty($subSubMenuItem['MenusMenu']['class'])) echo ' ' . $subSubMenuItem['MenusMenu']['class']; ?>">
                                <a class="sub-submenu-link" href="<?php echo $subSubMenuItem['MenusMenu']['link']; ?>">
                                    <?php echo $subSubMenuItem['MenusMenu']['title']; ?>
                                </a>
                            </li>
                            <?php
                            // Third level.
                            if(!empty($subSubMenuItem['active']) && !empty($subSubMenuItem['subMenu']))
                            {
                                ?>
                                <ul class="third-submenu">
                                    <?php
                                    foreach($subSubMenuItem['subMenu'] as $thirdSubMenuItem)
                                    {
                                        if($thirdSubMenuItem['MenusMenu']['hide'] == 0)
                                        {
                                            ?>
                                            <li class="third-submenu-item<?php if(!empty($thirdSubMenuItem['active'])) echo ' active'; ?><?php if(!empty($thirdSubMenuItem['MenusMenu']['class'])) echo ' ' . $thirdSubMenuItem['MenusMenu']['class']; ?>">
                                                <a class="third-submenu-link" href="<?php echo $thirdSubMenuItem['MenusMenu']['link']; ?>">
                                                    <?php echo $thirdSubMenuItem['MenusMenu']['title']; ?>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                                <?php
                            }
                        }
                    }

                    ?>
                    </ul>
                    <?php
                }
                ?>
            </li>
            <?php
        }
    }
    ?>
    </ul>
    <?php
}
?>
