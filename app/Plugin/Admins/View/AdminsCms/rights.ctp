
<?php echo $this->element('help/' . $this->Language->getLanguage() . '/rights'); ?>

<div class="row">
	<div class="col-md-8">
	    <h3>
	    	<?php echo $this->data['AdminsAdmin']['name'] . ' (' . $this->data['AdminsAdmin']['login'] . ')'; ?>
	    	
	    	<a href="#" class="pull-right" data-toggle="modal" data-target="#AdministratorRightsHelp">
	            <i class="fa fa-question-circle"></i>
	        </a>
	    </h3>
	    
	    <div class="table-responsive">
		    <table class="table table-striped table-bordered table-hover">
		        <tr>
		            <th><?php echo __d('cms', 'Module')?></th>
		            <th class="text-center"><?php echo __d('cms', 'View')?></th>
		            <th class="text-center"><?php echo __d('cms', 'Edit')?></th>
		            <th class="text-center"><?php echo __d('cms', 'Delete')?></th>
		        </tr>
		        <?php
		        foreach($rights as $plugin => $right)
		        {
		            if(Plugin::hasCmsModule($plugin))
		            {
		                ?>
		                <tr>
		                    <td><?php echo Plugin::getPluginName($plugin); ?></td>
		                    <td class="text-center">
		                        <?php
		                        if(!$right['index']) // Allow
		                        {
		                            ?>
		                            <a href="<?php echo $this->Html->url('/bakery/admins/add_restriction/' . $this->data['AdminsAdmin']['id'] . '/' . $plugin . '/index'); ?>"
		                            	title="<?php echo __d('cms', 'Change'); ?>" class="btn btn-success btn-circle">
		                            	
		                                <i class="fa fa-check"></i>
		                            </a>
		                            <?php
		                        }
		                        else // Has restriction id
		                        {
		                            ?>
		                            <a href="<?php echo $this->Html->url('/bakery/admins/remove_restriction/' . $right['index']); ?>"
		                            	title="<?php echo __d('cms', 'Change'); ?>" class="btn btn-danger btn-circle">
		                                
		                                <i class="fa fa-times"></i>
		                            </a>
		                            <?php
		                        }
		                        ?>
		                    </td>
		                    <td class="text-center">
		                        <?php
		                        if(!$right['edit']) // Allow
		                        {
		                            ?>
		                            <a href="<?php echo $this->Html->url('/bakery/admins/add_restriction/' . $this->data['AdminsAdmin']['id'] . '/' . $plugin . '/edit') ?>"
		                            	title="<?php echo __d('cms', 'Change'); ?>" class="btn btn-success btn-circle">
		                                <i class="fa fa-check"></i>
		                            </a>
		                            <?php
		                        }
		                        else // Has restriction id
		                        {
		                            ?>
		                            <a href="<?php echo $this->Html->url('/bakery/admins/remove_restriction/' . $right['edit']); ?>"
		                            	title="<?php echo __d('cms', 'Change'); ?>" class="btn btn-danger btn-circle">
		                                <i class="fa fa-times"></i>
		                            </a>
		                            <?php
		                        }
		                        ?>
		                    </td>
		                    <td class="text-center">
		                        <?php
		                        if(!$right['delete']) // Allow
		                        {
		                            ?>
		                            <a href="<?php echo $this->Html->url('/bakery/admins/add_restriction/' . $this->data['AdminsAdmin']['id'] . '/' . $plugin . '/delete'); ?>"
		                            	title="<?php echo __d('cms', 'Change'); ?>" class="btn btn-success btn-circle">
		                                <i class="fa fa-check"></i>
		                            </a>
		                            <?php
		                        }
		                        else // Has restriction id
		                        {
		                            ?>
		                            <a href="<?php echo $this->Html->url('/bakery/admins/remove_restriction/' . $right['delete']); ?>"
		                            	title="<?php echo __d('cms', 'Change'); ?>" class="btn btn-danger btn-circle">
		                                <i class="fa fa-times"></i>
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
	</div>
	
	<div class="col-md-4">
	    <div class="panel panel-default">
	        <div class="panel-heading">
                <?php echo __d('cms', 'Actions');?>
                
                <a href="#" class="pull-right" data-toggle="modal" data-target="#AdministratorRightsActionsHelp">
                    <i class="fa fa-question-circle"></i>
                </a>
	        </div>
	        <div class="panel-body">
	            <p>
	                <a href="<?php echo $this->Html->url('/bakery/admins/edit/' . $this->data['AdminsAdmin']['id']); ?>" class="btn btn-success btn-lg btn-block">
	                	<?php echo __d('cms', 'Edit administrator'); ?>
	                </a>
	                <br />
	                <a href="<?php echo $this->Html->url('/bakery/admins'); ?>" class="btn btn-warning btn-lg btn-block">
	                	<?php echo __d('cms', 'Back to administrators'); ?>
	                </a>
	            </p>
	        </div>
	    </div>
	</div>
	
</div>
