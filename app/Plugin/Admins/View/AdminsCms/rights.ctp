
<?php echo $this->element('help/' . $this->Language->getLanguage() . '/rights'); ?>

<div id="bakery-actions">
    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3>
                <?php echo __d('cms', 'Actions');?>
                <a href="#" class="help" rel="#AdministratorRightsActionsHelp" title="<?php echo __d('cms', 'Help'); ?>">
                    <img src="<?php echo $this->Html->url('/img/bakery/icons/help_icon.png'); ?>" alt="<?php echo __d('cms', 'Help'); ?>" />
                </a>
            </h3>
        </div>
        <div class="bakery-action-box-content">
            <p class="bakery-action-boxButtons">
                <a href="<?php echo $this->Html->url('/bakery/admins/edit/' . $this->data['AdminsAdmin']['id']); ?>" class="action-button-large"><?php echo __d('cms', 'Edit administrator');?></a>
                <br />
                <a href="<?php echo $this->Html->url('/bakery/admins'); ?>" class="button-large"><?php echo __d('cms', 'Back to administrators');?></a>
            </p>
        </div>
        <div class="bakery-action-box-bottom"></div>
    </div>
</div>

<div id="bakery-main">
    <h2 style="margin-top:0px;">
        <?php echo __d('cms', 'Permissions')?>
        <a href="#" class="help" rel="#AdministratorRightsHelp" title="<?php echo __d('cms', 'Help'); ?>">
            <img src="<?php echo $this->Html->url('/img/bakery/icons/help_icon.png'); ?>" alt="<?php echo __d('cms', 'Help'); ?>" />
        </a>
    </h2>

    <h3><?php echo $this->data['AdminsAdmin']['name'] . ' (' . $this->data['AdminsAdmin']['login'] . ')'; ?></h3>
    <table class="bakery-list">
        <tr>
            <th><?php echo __d('cms', 'Module')?></th>
            <th><?php echo __d('cms', 'View')?></th>
            <th><?php echo __d('cms', 'Edit')?></th>
            <th><?php echo __d('cms', 'Delete')?></th>
        </tr>
        <?php
        foreach($rights as $plugin => $right)
        {
            if(Plugin::hasCmsModule($plugin))
            {
                ?>
                <tr>
                    <td><?php echo Plugin::getPluginName($plugin); ?></td>
                    <td>
                        <?php
                        if(!$right['index']) // Allow
                        {
                            ?>
                            <a href="<?php echo $this->Html->url('/bakery/admins/add_restriction/' . $this->data['AdminsAdmin']['id'] . '/' . $plugin . '/index'); ?>" title="<?php echo __d('cms', 'Change'); ?>">
                                <img src="<?php echo $this->Html->url('/img/bakery/icons/accept.png'); ?>" alt="<?php echo __d('cms', 'Allow'); ?>" />
                            </a>
                            <?php
                        }
                        else // Has restriction id
                        {
                            ?>
                            <a href="<?php echo $this->Html->url('/bakery/admins/remove_restriction/' . $right['index']); ?>" title="<?php echo __d('cms', 'Change'); ?>">
                                <img src="<?php echo $this->Html->url('/img/bakery/icons/delete.png'); ?>" alt="<?php echo __d('cms', 'Deny'); ?>" />
                            </a>
                            <?php
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if(!$right['edit']) // Allow
                        {
                            ?>
                            <a href="<?php echo $this->Html->url('/bakery/admins/add_restriction/' . $this->data['AdminsAdmin']['id'] . '/' . $plugin . '/edit') ?>" title="<?php echo __d('cms', 'Change'); ?>">
                                <img src="<?php echo $this->Html->url('/img/bakery/icons/accept.png'); ?>" alt="<?php echo __d('cms', 'Allow'); ?>" />
                            </a>
                            <?php
                        }
                        else // Has restriction id
                        {
                            ?>
                            <a href="<?php echo $this->Html->url('/bakery/admins/remove_restriction/' . $right['edit']); ?>" title="<?php echo __d('cms', 'Change'); ?>">
                                <img src="<?php echo $this->Html->url('/img/bakery/icons/delete.png'); ?>" alt="<?php echo __d('cms', 'Deny'); ?>" />
                            </a>
                            <?php
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if(!$right['delete']) // Allow
                        {
                            ?>
                            <a href="<?php echo $this->Html->url('/bakery/admins/add_restriction/' . $this->data['AdminsAdmin']['id'] . '/' . $plugin . '/delete'); ?>" title="<?php echo __d('cms', 'Change'); ?>">
                                <img src="<?php echo $this->Html->url('/img/bakery/icons/accept.png'); ?>" alt="<?php echo __d('cms', 'Allow'); ?>" />
                            </a>
                            <?php
                        }
                        else // Has restriction id
                        {
                            ?>
                            <a href="<?php echo $this->Html->url('/bakery/admins/remove_restriction/' . $right['delete']); ?>" title="<?php echo __d('cms', 'Change'); ?>">
                                <img src="<?php echo $this->Html->url('/img/bakery/icons/delete.png'); ?>" alt="<?php echo __d('cms', 'Deny'); ?>" />
                            </a>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</div>
