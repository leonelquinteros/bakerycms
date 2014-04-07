<?php
foreach($pages as $page)
{
    ?>
    <tr>
        <td>
            <?php
            if($page['PagesPage']['publish']) {
                ?>
                <img src="/img/bakery/icons/bullet_green.png" alt="Online" title="Online" />
                <?php
            } else {
                ?>
                <img src="/img/bakery/icons/bullet_red.png" alt="Offline" title="Offline" />
                <?php

            }
            ?>
        </td>
        <td><?php echo Sanitize::html($page['PagesPage']['title']); ?></td>
        <td><?php echo $page['PagesPage']['url']; ?></td>
        <td><?php echo Language::name($page['PagesPage']['lang']); ?></td>
        <td><?php echo Inflector::humanize($page['PagesPage']['layout']); ?></td>
        <td>
            <a href="/pages/<?php echo $page['PagesPage']['url']; ?>" title="<?php echo __d('cms', 'Preview'); ?>" onclick="window.open('/<?php echo $page['PagesPage']['url']; ?>'); return false;">
                <img src="<?php echo $this->Html->url('/img'); ?>/bakery/icons/page_white_magnify.png" alt="<?php echo __d('cms', 'Preview'); ?>" />
            </a>
            &nbsp;&nbsp;&nbsp;
            <a href="<?php echo $this->Html->url('/bakery'); ?>/pages/edit/<?php echo $page['PagesPage']['id']; ?>" title="<?php echo __d('cms', 'Edit'); ?>">
                <img src="<?php echo $this->Html->url('/img'); ?>/bakery/icons/application_edit.png" alt="<?php echo __d('cms', 'Edit'); ?>" />
            </a>
            &nbsp;&nbsp;&nbsp;
            <a href="<?php echo $this->Html->url('/bakery'); ?>/pages/edit_content/<?php echo $page['PagesPage']['id']; ?>" target="_blank" title="<?php echo __d('cms', 'Edit content'); ?>">
                <img src="<?php echo $this->Html->url('/img'); ?>/bakery/icons/html.png" alt="<?php echo __d('cms', 'Edit content'); ?>" />
            </a>
            &nbsp;&nbsp;&nbsp;
            <a href="<?php echo $this->Html->url('/bakery'); ?>/pages/delete/<?php echo $page['PagesPage']['id']; ?>" title="<?php echo __d('cms', 'Delete'); ?>" onclick="return confirm('<?php echo __d('cms', "Are you sure you want to delete this page?"); ?>');">
                <img src="<?php echo $this->Html->url('/img'); ?>/bakery/icons/delete.png" alt="<?php echo __d('cms', 'Delete'); ?>" />
            </a>
        </td>
    </tr>
    <?php
}
?>
