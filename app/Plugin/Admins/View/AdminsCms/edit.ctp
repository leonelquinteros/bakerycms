<?php
echo $this->element('help/' . $this->Language->getLanguage() . '/edit');
?>
<div class="row">
	<div class="col-md-8">
	    <h4>
	        <?php echo __d('cms', 'Login information'); ?>
	        
	        <a href="#" class="pull-right" data-toggle="modal" data-target="#AdministratorInformationHelp">
	        	<i class="fa fa-question-circle"></i>
	        </a>
	    </h4>
	    <hr />
	    
	    <form id="frmAdmins" action="<?php echo $this->Html->url('/bakery/admins/edit'); ?>" method="post" enctype="multipart/form-data">
            <?php
            $this->Form->inputDefaults(
            				array(
			            		'div'	=> array(
			            				'class' => 'form-group',
			            		),
			            		'class' => 'form-control',
            				)
            );
            
            if( !empty($this->data['AdminsAdmin']['id']) )
            {
                echo $this->Form->input('AdminsAdmin.id', array('type' => 'hidden'));
            }

            echo $this->Form->input('AdminsAdmin.login',
                                array(
                                    'label' => __d('cms', 'Username'),
                                    'error' => __d('cms', 'This username is invalid or has already been taken, pick another one using alphabets and numbers only'),
                                )
            );

            echo $this->Form->input('AdminsAdmin.pass',
                                array(
                                    'type' => 'password',
                                    'label' => __d('cms', 'Password (use only to change)'),
                                    'error' => __d('cms', 'Invalid password'),
                                )
            );
            ?>
            
            <hr />
            <h4>Personal information</h4>
            <hr />
            
            <?php
            echo $this->Form->input('AdminsAdmin.name',
                                array(
                                    'label' => __d('cms', 'Full name'),
                                    'error' => __d('cms', 'This field cannot be empty.'),
                                )
            );

            echo $this->Form->input('AdminsAdmin.email',
                                array(
                                    'label' => __d('cms', 'E-Mail'),
                                    'error' => __d('cms', 'Invalid E-Mail'),
                                )
            );

            echo $this->Form->input('AdminsAdmin.comments',
                                array(
                                    'type' => 'textarea',
                                    'label' => __d('cms', 'Comments')
                                )
            );
            ?>
	    </form>
	    
	    <hr />
	    <div>
            <a href="#" class="btn btn-lg btn-success" onclick="this.onclick = function(){ return false; }; jQuery('#frmAdmins').submit(); return false;"><?php echo __d('cms', 'Save');?></a>
        </div>
	</div>
	
	<div class="col-md-4">
	    <div class="panel panel-default">
	        <div class="panel-heading">
                <?php echo __d('cms', 'Actions');?>
                
                <a href="#" class="pull-right" data-toggle="modal" data-target="#AdministratorActionsHelp">
		        	<i class="fa fa-question-circle"></i>
		        </a>
	        </div>
	        
	        <div class="panel-body">
	            <p>
	                <a href="#" class="btn btn-success btn-lg btn-block" onclick="this.onclick = function(){ return false; }; jQuery('#frmAdmins').submit(); return false;">
	                	<?php echo __d('cms', 'Save');?>
	                </a>
	                <br />
	                <a href="<?php echo $this->Html->url('/bakery/admins'); ?>" class="btn btn-warning btn-lg btn-block">
	                	<?php echo __d('cms', 'Back to administrators');?>
	                </a>
	            </p>
	        </div>
	    </div>
	
	    <?php
	    if( !empty($this->data['AdminsAdmin']['id']) )
	    {
	        ?>
	        <div class="panel panel-default">
	            <div class="panel-heading">
                    <?php echo __d('cms', 'Permissions');?>
                    
                    <a href="#" class="pull-right" data-toggle="modal" data-target="#AdministratorPermissionsHelp">
			        	<i class="fa fa-question-circle"></i>
			        </a>
	            </div>
	            <div class="panel-body">
	                <p>
	                    <a href="<?php echo $this->Html->url('/bakery/admins/rights/' . $this->data['AdminsAdmin']['id']); ?>" class="btn btn-info btn-lg btn-block">
	                    	<?php echo __d('cms', 'Administrator rights');?>
	                    </a>
	                </p>
	            </div>
	        </div>
	        <?php
	    }
	    ?>
	</div>
</div>
