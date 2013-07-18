
<?php echo $this->element('help/' . $this->Language->getLanguage() . '/edit'); ?>

<div id="bakery-actions">
    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3><?php echo __d('cms', 'Actions');?></h3>
        </div>
        <div class="bakery-action-box-content">
            <p class="bakery-action-boxButtons">
                <a href="#" class="action-button-large" onclick="this.onclick = function(){ return false; }; jQuery('#frmMenus').submit(); return false;"><?php echo __d('cms', 'Save');?></a>
                <br />
                <?php
                if(empty($this->data['MenusMenu']['parent_id']))
                {
                    ?>
                    <a href="<?php echo $this->Html->url('/cms/menus/view/' . $lang . '/' . $menuName); ?>" class="button-large">
                            <?php echo __d('cms', 'Back to menu overview');?>
                    </a>
                    <?php
                }
                else
                {
                    ?>
                    <a href="<?php echo $this->Html->url('/cms/menus/edit/' . $lang . '/' . $menuName); ?>/<?php echo $this->data['MenusMenu']['parent_id']; ?>"
                        class="button-large" onclick="return confirm('<?php echo __d('cms', 'Your changes will not be saved. Are you sure you want to proceed?')?>')">
                            <?php echo __d('cms', 'Back to parent menu');?>
                    </a>
                    <?php
                }
                ?>

            </p>
        </div>
        <div class="bakery-action-box-bottom"></div>
    </div>

    <?php
    if(!empty($this->data['MenusMenu']['id']))
    {
        ?>
        <div class="bakery-action-box">
            <div class="bakery-action-box-top">
                <h3>
                    <?php echo __d('cms', 'Sub-menu');?>
                    <a href="#" class="help" rel="#MenusEditSubMenuHelp" title="<?php echo __d('cms', 'Help'); ?>">
                        <img src="<?php echo $this->Html->url('/img/cms/icons/help_icon.png'); ?>" alt="<?php echo __d('cms', 'Help'); ?>" />
                    </a>
                </h3>
            </div>
            <div class="bakery-action-box-content">
                <p class="bakery-action-boxButtons">
                    <a href="<?php echo $this->Html->url('/cms/menus/edit/' . $lang . '/' . $menuName . '/0/' . $this->data['MenusMenu']['id']); ?>" class="button-large"><?php echo __d('cms', 'Add link to sub-menu');?></a>
                    <a href="#" onclick="openPagesDialog(); return false;" class="button-large"><?php echo __d('cms', 'Add page link to sub-menu');?></a>
                </p>
            </div>
            <div class="bakery-action-box-bottom"></div>
        </div>
        <?php
    }
    ?>
</div>

<div id="bakery-main">
    <h2 style="margin-top:0px;">
        <?php echo __d('cms', 'Menu item information');?>
        <a href="#" class="help" rel="#MenusEditInfoHelp" title="<?php echo __d('cms', 'Help'); ?>">
            <img src="<?php echo $this->Html->url('/img/cms/icons/help_icon.png'); ?>" alt="<?php echo __d('cms', 'Help'); ?>" />
        </a>
    </h2>

    <form id="frmMenus" action="<?php echo $this->Html->url('/cms/menus/edit/' . $lang .'/' . $menuName); ?>" method="post" enctype="multipart/form-data">
        <div id="bakery-form">
            <?php
            if( !empty($this->data['MenusMenu']['id']) )
            {
                echo $this->Form->input('MenusMenu.id', array('type' => 'hidden'));
            }

            echo $this->Form->input('MenusMenu.parent_id', array('type' => 'hidden', 'default' => $parentId));

            echo $this->Form->input('MenusMenu.position', array('type' => 'hidden'));

            echo $this->Form->input('MenusMenu.title',
                                array(
                                    'label' => __d('cms', 'Menu title')
                                )
            );

            echo $this->Form->input('MenusMenu.link',
                                array(
                                    'label' => __d('cms', 'Menu link'),
                                    'default' => 'http://'
                                )
            );
            ?>
        </div>

        <div class="bakery-form-footer">
            <a href="#" class="action-button-medium" onclick="this.onclick = function(){ return false; }; jQuery('#frmMenus').submit(); return false;"><?php echo __d('cms', 'Save');?></a>
        </div>
    </form>

    <?php
    if(!empty($subMenus))
    {
        ?>
        <h2>Sub Menu</h2>

        <ul class="sortable-menu" id="sortable-menu">
        <?php
        foreach($subMenus as $subMenu)
        {
            ?>
            <li class="sortable-menu-item" id="menu-<?php echo $subMenu['MenusMenu']['id']; ?>">
                <span><?php echo $subMenu['MenusMenu']['title']; ?></span>

                <a href="<?php echo $this->Html->url('/cms/menus/edit/' . $lang . '/' . $menuName . '/' . $subMenu['MenusMenu']['id']); ?>" style="position:absolute;right:40px;" title="<?php echo __d('cms', 'Edit'); ?>">
                    <img src="<?php echo $this->Html->url('/img/cms/icons/application_edit.png'); ?>" alt="<?php echo __d('cms', 'Edit'); ?>" />
                </a>
                <a href="<?php echo $this->Html->url('/cms/menus/delete/' . $lang . '/' . $menuName . '/' . $subMenu['MenusMenu']['id'] . '/' . intval($subMenu['MenusMenu']['parent_id'])); ?>" onclick="return confirm('Do you want to delete this menu item?');" style="position:absolute;right:10px;" title="<?php echo __d('cms', 'Delete'); ?>">
                    <img src="<?php echo $this->Html->url('/img/cms/icons/delete.png'); ?>" alt="<?php echo __d('cms', 'Delete'); ?>" />
                </a>

                <?php
                foreach($subMenu['SubMenu'] as $subSubMenu)
                {
                    ?>
                    <br />
                    <span style="margin-left:30px;margin-top:5px;">&raquo; <?php echo $subSubMenu['title']; ?></span>
                    <?php
                }
                ?>
            </li>
            <?php
        }
        ?>
        </ul>
        <?php
    }
    ?>
</div>

<div id="cmsAddMenuPageDialog" style="display:none;text-align:left;">
    <h4><?php echo __d('cms', 'Pages in') . ' ' . $langName; ?></h4>
    <br />
    <?php
    foreach($pages as $page)
    {
        ?>
        <a href="#" style="font-size:1.2em;color:#285D8B;" onclick="addMenuItem('<?php echo $page['PagesPage']['title']; ?>', '/<?php echo $page['PagesPage']['url']; ?>', '<?php echo intval($this->data['MenusMenu']['id']); ?>'); return false;" title="<?php echo __d('cms', 'Add this page'); ?>">
            <?php echo $page['PagesPage']['title']; ?>
        </a>
        <br />
        <?php
    }
    ?>
</div>

<script type="text/javascript">
    <?php include_once(CakePlugin::path('Menus') . '/webroot/js/menueditor.js'); ?>
</script>
