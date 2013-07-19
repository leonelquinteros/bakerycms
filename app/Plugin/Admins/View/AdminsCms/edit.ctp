<?php
$this->Html->script('passwordStrengthMeter', array('inline' => false));

echo $this->element('help/' . $this->Language->getLanguage() . '/edit');
?>

<div id="bakery-actions">
    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3>
                <?php echo __d('cms', 'Actions');?>
                <a href="#" class="help" rel="#AdministratorActionsHelp" title="<?php echo __d('cms', 'Help'); ?>">
                    <img src="<?php echo $this->Html->url('/img/bakery/icons/help_icon.png'); ?>" alt="<?php echo __d('cms', 'Help'); ?>" />
                </a>
            </h3>
        </div>
        <div class="bakery-action-box-content">
            <p class="bakery-action-boxButtons">
                <a href="#" class="action-button-large" onclick="this.onclick = function(){ return false; }; jQuery('#frmAdmins').submit(); return false;"><?php echo __d('cms', 'Save');?></a>
                <br />
                <a href="<?php echo $this->Html->url('/bakery/admins'); ?>" class="button-large"><?php echo __d('cms', 'Back to administrators');?></a>
            </p>
        </div>
        <div class="bakery-action-box-bottom"></div>
    </div>

    <?php
    if( !empty($this->data['AdminsAdmin']['id']) )
    {
        ?>
        <div class="bakery-action-box">
            <div class="bakery-action-box-top">
                <h3>
                    <?php echo __d('cms', 'Permissions');?>
                    <a href="#" class="help" rel="#AdministratorPermissionsHelp" title="<?php echo __d('cms', 'Help'); ?>">
                        <img src="<?php echo $this->Html->url('/img/bakery/icons/help_icon.png'); ?>" alt="<?php echo __d('cms', 'Help'); ?>" />
                    </a>
                </h3>
            </div>
            <div class="bakery-action-box-content">
                <p class="bakery-action-boxButtons">
                    <a href="<?php echo $this->Html->url('/bakery/admins/rights/' . $this->data['AdminsAdmin']['id']); ?>" class="action-button-large"><?php echo __d('cms', 'Administrator rights');?></a>
                </p>
            </div>
            <div class="bakery-action-box-bottom"></div>
        </div>
        <?php
    }
    ?>
</div>

<div id="bakery-main">
    <h2 style="margin-top:0px;">
        <?php echo __d('cms', 'Login information'); ?>
        <a href="#" class="help" rel="#AdministratorInformationHelp" title="<?php echo __d('cms', 'Help'); ?>">
            <img src="<?php echo $this->Html->url('/img/bakery/icons/help_icon.png'); ?>" alt="<?php echo __d('cms', 'Help'); ?>" />
        </a>
    </h2>
    <form id="frmAdmins" action="<?php echo $this->Html->url('/bakery/admins/edit'); ?>" method="post" enctype="multipart/form-data">
        <div id="bakery-form">
            <?php
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

            <div id="passwordStrength" style="margin-top:-20px;margin-bottom:20px;padding:5px;font-weight:bold;color:#000000;">&nbsp;</div>

            <h2>Personal information</h2>
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
        </div>

        <div class="bakery-form-footer">
            <a href="#" class="action-button-medium" onclick="this.onclick = function(){ return false; }; jQuery('#frmAdmins').submit(); return false;"><?php echo __d('cms', 'Save');?></a>
        </div>
    </form>
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#AdminsAdminPass').keyup( function() {
                                if(jQuery('#AdminsAdminPass').val() == '') {
                                    jQuery('#passwordStrength').css('background-color', 'transparent');
                                    jQuery('#passwordStrength').html('&nbsp;');
                                } else {
                                    var result = passwordStrength( jQuery('#AdminsAdminPass').val(), jQuery('#AdminsAdminLogin').val() );
                                    switch(result) {
                                        case 'Too short':
                                            jQuery('#passwordStrength').css('background-color', '#FA5A6D');
                                            jQuery('#passwordStrength').html('Too short');
                                            break;

                                        case 'Bad':
                                            jQuery('#passwordStrength').css('background-color', '#FA5A6D');
                                            jQuery('#passwordStrength').html('Weak');
                                            break;

                                        case 'Good':
                                            jQuery('#passwordStrength').css('background-color', '#F2FA98');
                                            jQuery('#passwordStrength').html('Good');
                                            break;

                                        case 'Strong':
                                            jQuery('#passwordStrength').css('background-color', '#77F78A');
                                            jQuery('#passwordStrength').html('Strong');
                                            break;

                                    }
                                }
        });
    });

</script>
