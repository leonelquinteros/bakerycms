<div id="bakery-actions">
    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3><?php echo __d('cms', 'Create'); ?></h3>
        </div>
        <div class="bakery-action-box-content">
            <p class="bakery-action-boxButtons">
                <a href="<?php echo $this->Html->url('/bakery'); ?>/products/edit" class="button-large"><?php echo __d('cms', 'New product'); ?></a>
            </p>
        </div>
        <div class="bakery-action-box-bottom"></div>
    </div>

    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3>
                <?php echo __d('cms', 'Search'); ?>
            </h3>
        </div>
        <div class="bakery-action-box-content">
            <div class="bakery-action-form">
                <div class="bakery-action-form-top"></div>

                <form id="frmSearchProducts" action="<?php echo $this->Html->url('/bakery'); ?>/products/search" method="post">
                    <p class="bakery-action-form-content">
                        <span><?php echo __d('cms', 'Keyword'); ?></span>
                        <br />
                        <input type="text" name="q" class="textBox" />
                        <br />
                        <a href="#" class="button-small" onclick="jQuery('#frmSearchProducts').submit(); return false;"><?php echo __d('cms', 'Search'); ?></a>
                    </p>
                </form>

                <div class="bakery-action-form-bottom"></div>
            </div>
        </div>
        <div class="bakery-action-box-bottom"></div>
    </div>

    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3><?php echo __d('cms', 'Categories'); ?></h3>
        </div>
        <div class="bakery-action-box-content">
            <p class="bakery-action-boxButtons">
                <a href="<?php echo $this->Html->url('/bakery'); ?>/products/categories" class="action-button-large"><?php echo __d('cms', 'View Categories'); ?></a>
                </br />
                <a href="<?php echo $this->Html->url('/bakery'); ?>/products/categories/edit" class="button-large"><?php echo __d('cms', 'New Category'); ?></a>
            </p>
        </div>
        <div class="bakery-action-box-bottom"></div>
    </div>
</div>

<div id="bakery-main">
    <table class="bakery-list">
        <thead>
            <tr>
                <th><?php echo $this->paginator->sort('ProductsProduct.name', __d('cms', 'Name')); ?></th>
                <th><?php echo $this->paginator->sort('ProductsProduct.url', __d('cms', 'URL')); ?></th>
                <th><?php echo $this->paginator->sort('ProductsProduct.Category.name', __d('cms', 'Category')); ?></th>
                <th style="width:170px;"><?php echo __d('cms', 'Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            echo $this->element('cms_list');
            ?>
        </tbody>
    </table>

    <?php echo $this->element('paginator_pages'); ?>
</div>
