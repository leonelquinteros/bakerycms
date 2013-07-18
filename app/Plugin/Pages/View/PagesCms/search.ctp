<div id="bakery-actions">
    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3><?php echo __d('cms', 'Create'); ?></h3>
        </div>
        <div class="bakery-action-box-content">
            <p class="bakery-action-boxButtons">
                <a href="<?php echo $this->Html->url('/cms'); ?>/pages/edit" class="button-large"><?php echo __d('cms', 'New page'); ?></a>
            </p>
        </div>
        <div class="bakery-action-box-bottom"></div>
    </div>

    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3><?php echo __d('cms', 'Filter'); ?></h3>
        </div>
        <div class="bakery-action-box-content">
            <div class="bakery-action-form">
                <div class="bakery-action-form-top"></div>

                <form id="frmSearchPages" action="<?php echo $this->Html->url('/cms'); ?>/pages/search" method="post">
                    <p class="bakery-action-form-content">
                        <span><?php echo __d('cms', 'Keyword'); ?></span>
                        <br />
                        <input type="text" name="q" class="textBox" value="<?php echo $keyword; ?>" />
                        <br />
                        <a href="#" class="button-small" onclick="jQuery('#frmSearchPages').submit(); return false;"><?php echo __d('cms', 'Search'); ?></a>
                    </p>
                </form>

                <div class="bakery-action-form-bottom"></div>
            </div>

            <p class="bakery-action-boxButtons">
                <a href="<?php echo $this->Html->url('/cms'); ?>/pages/" class="button-large"><?php echo __d('cms', 'All pages'); ?></a>
            </p>
        </div>

        <div class="bakery-action-box-bottom"></div>
    </div>
</div>

<div id="bakery-main">
    <table class="bakery-list">
        <thead>
            <tr>
                <th>&nbsp;</th>
                <th><?php echo __d('cms', 'Title'); ?></th>
                <th><?php echo __d('cms', 'URL'); ?></th>
                <th><?php echo __d('cms', 'Language'); ?></th>
                <th><?php echo __d('cms', 'Layout'); ?></th>
                <th style="width:150px;"><?php echo __d('cms', 'Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            echo $this->element('cms_list');
            ?>
        </tbody>
    </table>
</div>
