<?php echo $this->Html->docType('html5'); ?>

<html>
    <head>
        <title><?php echo $pageTitle; ?> | Bakery CMS</title>

        <?php
        echo $this->Html->charset();

        $this->Html->css('bakery/bakery', null, array('inline' => false));
        $this->Html->css('flick/jquery-ui-1.10.3.custom.min', null, array('inline' => false));
        $this->Html->css('MediaGallery.jquery.Jcrop.min', null, array('inline' => false));

        echo $this->fetch('css');

        $this->Html->script('jquery-1.9.1', array('inline' => false));
        $this->Html->script('jquery.tools.min', array('inline' => false));
        $this->Html->script('jquery-ui-1.10.3.custom.min', array('inline' => false));

        if(!empty($this->request->params['plugin']))
        {
            $this->Html->script('fileuploader', array('inline' => false));
            $this->Html->script('tinymce/tinymce.min', array('inline' => false));
            $this->Html->script('tinymce/jquery.tinymce.min', array('inline' => false));
            $this->Html->script('MediaGallery.cms.media.gallery', array('inline' => false));
            $this->Html->script('MediaGallery.jquery.Jcrop.min', array('inline' => false));
        }

        echo $this->fetch('script');
        ?>

        <script type="text/javascript">
            jQuery( function() {
                if(jQuery('#flashMessage')) {
                    jQuery('#flashMessage').html( '<div>' + jQuery('#flashMessage').html() + '</div>' );

                    jQuery('#flashMessage').prepend('<img src="<?php echo $this->Html->url('/img/bakery/close_help.png'); ?>" id="closeFlashMessage" alt="X" style="cursor:pointer;position:absolute;right:15px;top:15px;" />');

                    jQuery('#flashMessage').overlay({
                        close: '#closeFlashMessage',
                        load: true,
                        mask: {
                            color: '#000000',
                            loadSpeed: 100,
                            opacity: 0.5,
                            zIndex: 999
                        },
                        onLoad: function() {
                            setTimeout( function() { jQuery('#flashMessage').data('overlay').close(); }, 3000 );
                        }
                    });

                    var h = jQuery('#flashMessage div').height();
                    var margin = 61 - ( h / 2 );
                    jQuery('#flashMessage div').css('margin-top', margin);
                }

                jQuery('.help').overlay({
                    close: '.helpClose',
                    closeOnClick: false,
                    mask: {
                        color: '#000000',
                        loadSpeed: 100,
                        opacity: 0.5,
                        zIndex: 999
                    }
                });

            });
        </script>

    </head>

    <body>
        <div id="bakery-top-back"></div>

        <div id="bakery-wrapper">
            <div id="bakery-top">
                <a href="<?php echo $this->Html->url('/bakery'); ?>">
                    <h1>Bakery CMS</h1>
                </a>

                <div id="bakery-topFlags"><?php echo $this->Language->flags(); ?></div>

                <div id="bakery-topMessage"><?php echo $this->CmsWelcome->render(); ?></div>

                <div class="bakery-nav">
                    <ul class="bakery-nav">
                        <?php
                        foreach($cmsMenu as $menu)
                        {
                            $active = '';
                            if($this->request->params['plugin'] == $menu['plugin'])
                            {
                                $active = 'active';
                            }
                            ?>
                            <li class="bakery-nav <?php echo $active; ?>">
                                <a class="bakery-nav <?php echo $active; ?>" href="<?php echo $this->Html->url($menu['link']); ?>"><?php echo $menu['name']; ?></a>
                                <?php
                                if(!empty($menu['submenu']))
                                {
                                    ?>
                                    <div class="bakery-nav-submenu-wrap">
                                        <ul class="bakery-nav-submenu">
                                        <?php
                                        foreach($menu['submenu'] as $subMenu)
                                        {
                                            ?>
                                            <li class="bakery-nav-submenu">
                                                <a class="bakery-nav-submenu" href="<?php echo $this->Html->url($subMenu['link']); ?>"><?php echo $subMenu['name']; ?></a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                        </ul>
                                    </div>
                                    <?php
                                }
                                ?>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <div id="bakery-content">
                <?php
                echo $this->CmsBreadcrumb->render($breadcrumb);

                echo "<h1>" . $pageTitle . "</h1>";

                echo $this->fetch('content');
                ?>

                <div style="clear:both;"></div>

                <?php echo $this->Session->flash(); ?>
            </div>

        </div>

        <div id="bakery-bottom">
            &copy; Copyright 2013 <?php if(date('Y') > 2013) echo '- ' . date('Y'); ?> <a href="http://leonelquinteros.github.io/bakerycms">Bakery CMS</a>
        </div>

        <?php
        /**
         * SQL Debug dump.
         * Remove on production.
         */
        //echo $this->element('sql_dump');
        ?>
    </body>
</html>
