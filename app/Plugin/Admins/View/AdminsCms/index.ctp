<div id="bakery-actions">
    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3><?php echo __d('cms', 'Create'); ?></h3>
        </div>
        <div class="bakery-action-box-content">
            <p class="bakery-action-boxButtons">
                <a href="<?php echo $this->Html->url('/cms/admins/edit'); ?>" class="button-large"><?php echo __d('cms', 'New administrator'); ?></a>
            </p>
        </div>
        <div class="bakery-action-box-bottom"></div>
    </div>
</div>

<div id="bakery-main">
    <table class="bakery-list">
        <thead>
            <tr>
                <th><?php echo __d('cms', 'Login'); ?></th>
                <th><?php echo __d('cms', 'Name'); ?></th>
                <th><?php echo __d('cms', 'E-mail'); ?></th>
                <th style="width:120px;"><?php echo __d('cms', 'Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($admins as $admin)
            {
                if($isSuperAdmin || ($admin['AdminsAdmin']['super_admin'] == 0))
                {
                    ?>
                    <tr>
                        <td><?php echo $admin['AdminsAdmin']['login']; ?></td>
                        <td><?php echo $admin['AdminsAdmin']['name']; ?></td>
                        <td><?php echo $admin['AdminsAdmin']['email']; ?></td>
                        <td>
                            <a href="<?php echo $this->Html->url('/cms/admins/edit/' . $admin['AdminsAdmin']['id']); ?>" title="<?php echo __d('cms', 'Edit'); ?>">
                                <img src="<?php echo $this->Html->url('/img/cms/icons/application_edit.png'); ?>" alt="<?php echo __d('cms', 'Edit'); ?>" />
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="<?php echo $this->Html->url('/cms/admins/rights/' . $admin['AdminsAdmin']['id']); ?>" title="<?php echo __d('cms', 'Administrator rights'); ?>">
                                <img src="<?php echo $this->Html->url('/img/cms/icons/group_key.png'); ?>" alt="<?php echo __d('cms', 'Rights'); ?>" />
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="<?php echo $this->Html->url('/cms/admins/delete/' . $admin['AdminsAdmin']['id']); ?>" title="<?php echo __d('cms', 'Delete'); ?>" onclick="return confirm('<?php echo __d('cms', "Are you sure you want to delete ") . $admin['AdminsAdmin']['login']; ?>');">
                                <img src="<?php echo $this->Html->url('/img/cms/icons/delete.png'); ?>" alt="<?php echo __d('cms', 'Delete'); ?>" />
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
