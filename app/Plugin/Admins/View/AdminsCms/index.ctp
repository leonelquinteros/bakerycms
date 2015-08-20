<p class="text-center">
	<a class="btn btn-success" href="<?php echo $this->Html->url('/bakery/admins/edit'); ?>" class="button-large"><?php echo __d('cms', 'New administrator'); ?></a>
</p>

<hr />

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
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
                            <a class="btn btn-success btn-circle" href="<?php echo $this->Html->url('/bakery/admins/edit/' . $admin['AdminsAdmin']['id']); ?>" title="<?php echo __d('cms', 'Edit'); ?>">
                                <i class="fa fa-pencil"></i>
                            </a>
                            
                            <a class="btn btn-info btn-circle" href="<?php echo $this->Html->url('/bakery/admins/rights/' . $admin['AdminsAdmin']['id']); ?>" title="<?php echo __d('cms', 'Administrator rights'); ?>">
                                <i class="fa fa-lock"></i>
                            </a>
                            
                            <a class="btn btn-danger btn-circle" href="<?php echo $this->Html->url('/bakery/admins/delete/' . $admin['AdminsAdmin']['id']); ?>" title="<?php echo __d('cms', 'Delete'); ?>" onclick="return confirm('<?php echo __d('cms', "Are you sure you want to delete ") . $admin['AdminsAdmin']['login']; ?>');">
                                <i class="fa fa-times"></i>
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
