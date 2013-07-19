<div id="cmsLogin">
    <p>
        <br /><br /><br />
        <?php echo __d('cms', 'Please enter your username and password to login'); ?>
    </p>

    <form id="frmLogin" method="post" action="<?php echo $this->Html->url('/bakery/login'); ?>">
        <div id="bakery-login-form">
            <label><?php echo __d('cms', 'Username'); ?></label><input type="text" name="user" />
            <br />
            <label><?php echo __d('cms', 'Password'); ?></label><input type="password" name="pass" />
            <br />
            <label></label><a href="#" onclick="jQuery('#frmLogin').submit(); return false;" class="button-large">Login</a>
        </div>

        <input type="submit" value="" style="visibility:hidden;" />
    </form>

</div>

<script type="text/javascript">
    jQuery( function() {
        jQuery('input[name="user"]').focus();
    });
</script>
