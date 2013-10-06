
<?php echo $this->element('help/' . $this->Language->getLanguage() . '/view'); ?>

<div id="bakery-actions">
    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3>
                <?php echo __d('cms', 'Actions'); ?>
                <a href="#" class="help" rel="#MenusActionsHelp" title="<?php echo __d('cms', 'Help'); ?>">
                    <img src="<?php echo $this->Html->url('/img/bakery/icons/help_icon.png'); ?>" alt="<?php echo __d('cms', 'Help'); ?>" />
                </a>
            </h3>
        </div>
        <div class="bakery-action-box-content">
            <p class="bakery-action-boxButtons">
                <a href="<?php echo $this->Html->url('/bakery/menus/edit/' . $lang . '/' . $menuName); ?>" class="button-large"><?php echo __d('cms', 'Add item by URL');?></a>
                <br />
                <a href="#" onclick="openPagesDialog(); return false;" class="button-large"><?php echo __d('cms', 'Select page to link');?></a>
                <br />
                <a href="<?php echo $this->Html->url('/bakery/menus'); ?>" class="button-large"><?php echo __d('cms', 'Back to menu overview');?></a>
            </p>
        </div>
        <div class="bakery-action-box-bottom"></div>
    </div>
</div>

<div id="bakery-main">
    <ul class="sortable-menu" id="sortable-menu">
        <?php
        foreach($this->data as $item)
        {
            ?>
            <li class="sortable-menu-item" id="menu-<?php echo $item['MenusMenu']['id']; ?>">
                <span><?php echo $item['MenusMenu']['title']; ?></span>

                <a href="<?php echo $this->Html->url('/bakery/menus/edit/' . $lang . '/' . $menuName . '/' . $item['MenusMenu']['id']); ?>" style="position:absolute;right:40px;" title="<?php echo __d('cms', 'Edit'); ?>">
                    <img src="<?php echo $this->Html->url('/img/bakery/icons/application_edit.png'); ?>" alt="<?php echo __d('cms', 'Edit'); ?>" />
                </a>
                <a href="<?php echo $this->Html->url('/bakery/menus/delete/' . $lang . '/' . $menuName . '/' . $item['MenusMenu']['id']); ?>" onclick="return confirm('Do you want to delete this menu item?');" style="position:absolute;right:10px;" title="<?php echo __d('cms', 'Delete'); ?>">
                    <img src="<?php echo $this->Html->url('/img/bakery/icons/delete.png'); ?>" alt="<?php echo __d('cms', 'Delete'); ?>" />
                </a>

                <?php
                foreach($item['SubMenu'] as $subMenu)
                {
                    ?>
                    <br />
                    <span style="margin-left:30px;margin-top:5px;">&raquo; <?php echo $subMenu['title']; ?></span>
                    <?php
                }
                ?>
            </li>
            <?php
        }
        ?>
    </ul>
</div>

<div id="cmsAddMenuPageDialog" style="display:none;text-align:left;">
    <h3><?php echo __d('cms', 'Pages in') . ' ' . $langName; ?></h3>
    <br />
    <?php
    foreach($pages as $page)
    {
        ?>
        <a href="#" style="font-size:1.2em;color:#285D8B;" onclick="addMenuItem('<?php echo $page['PagesPage']['title']; ?>', '/<?php echo $page['PagesPage']['url']; ?>','0'); return false;" title="<?php echo __d('cms', 'Add this page'); ?>"><?php echo $page['PagesPage']['title']; ?></a>
        <br />
        <?php
    }
    ?>
</div>

<script type="text/javascript">
    <?php include_once(CakePlugin::path('Menus') . '/webroot/js/menueditor.js'); ?>
</script>
