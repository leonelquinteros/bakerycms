<div id="bakery-actions">
    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3><?php echo __d('cms', 'Menu structure'); ?></h3>
        </div>
        <div class="bakery-action-box-content">
            <p class="bakery-action-text">
                <?php echo __d('cms', 'All the current menus are listed (by language) on the right.'); ?>
                <br /><br />
                <?php echo __d('cms', 'To edit a menu, click on the corresponding Edit icon'); ?> <img src="<?php echo $this->Html->url('/img/cms/icons/application_edit.png'); ?>" alt="<?php echo __d('cms', 'Edit'); ?>" />
                <br /><br />
            </p>
        </div>
        <div class="bakery-action-box-bottom"></div>
    </div>
</div>

<div id="bakery-main">
    <table class="bakery-list">
        <thead>
            <tr>
                <th><?php echo __d('cms', 'Language'); ?></th>
                <th><?php echo __d('cms', 'Menu'); ?></th>
                <th><?php echo __d('cms', 'Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($langs as $lang)
            {
                foreach($menus as $menu)
                {
                    ?>
                    <tr>
                        <td><?php echo $this->Language->name($lang); ?></td>
                        <td><?php echo $menu; ?></td>
                        <td>
                            <a href="<?php echo $this->Html->url('/cms/menus/view/' . $lang . '/' . $menu); ?>" title="<?php echo __d('cms', 'Edit'); ?>">
                                <img src="<?php echo $this->Html->url('/img/cms/icons/application_edit.png'); ?>" alt="<?php echo __d('cms', 'Edit'); ?>" />
                            </a>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
