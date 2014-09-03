<div id="bakery-actions">
    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3><?php echo __d('cms', 'Create'); ?></h3>
        </div>
        <div class="bakery-action-box-content">
            <p class="bakery-action-boxButtons">
                <a href="<?php echo $this->Html->url('/bakery'); ?>/products/categories/edit" class="button-large"><?php echo __d('cms', 'New category'); ?></a>
            </p>
        </div>
        <div class="bakery-action-box-bottom"></div>
    </div>

    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3><?php echo __d('cms', 'Products'); ?></h3>
        </div>
        <div class="bakery-action-box-content">
            <p class="bakery-action-boxButtons">
                <a href="<?php echo $this->Html->url('/bakery'); ?>/products" class="action-button-large"><?php echo __d('cms', 'View Products'); ?></a>
                </br />
                <a href="<?php echo $this->Html->url('/bakery'); ?>/products/edit" class="button-large"><?php echo __d('cms', 'New Product'); ?></a>
            </p>
        </div>
        <div class="bakery-action-box-bottom"></div>
    </div>
</div>

<div id="bakery-main">
    <table class="bakery-list">
        <thead>
            <tr>
                <th><?php echo $this->paginator->sort('ProductsCategory.name', __d('cms', 'Name')); ?></th>
                <th><?php echo $this->paginator->sort('ProductsCategory.url', __d('cms', 'URL')); ?></th>
                <th style="width:170px;"><?php echo __d('cms', 'Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($categories as $category)
            {
                ?>
                <tr>
                    <td><?php echo Sanitize::html($category['ProductsCategory']['name']); ?></td>
                    <td><?php echo $category['ProductsCategory']['url']; ?></td>
                    <td>
                        <a href="<?php echo $this->Html->url('/bakery'); ?>/products/categories/edit/<?php echo $category['ProductsCategory']['id']; ?>"
                            title="<?php echo __d('cms', 'Edit'); ?>">
                                <img src="<?php echo $this->Html->url('/img'); ?>/bakery/icons/application_edit.png" alt="<?php echo __d('cms', 'Edit'); ?>" />
                        </a>
                        &nbsp;&nbsp;&nbsp;
                        <a href="<?php echo $this->Html->url('/bakery'); ?>/products/categories/delete/<?php echo $category['ProductsCategory']['id']; ?>"
                            title="<?php echo __d('cms', 'Delete'); ?>"
                            onclick="return confirm('<?php echo __d('cms', "Are you sure you want to delete this category?"); ?>');">
                                <img src="<?php echo $this->Html->url('/img'); ?>/bakery/icons/delete.png" alt="<?php echo __d('cms', 'Delete'); ?>" />
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>

        </tbody>
    </table>

    <?php echo $this->element('paginator_pages'); ?>
</div>
