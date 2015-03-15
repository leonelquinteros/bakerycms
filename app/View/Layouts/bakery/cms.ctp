<?php echo $this->Html->docType('html5'); ?>

<html>
    <head>
        <?php
        echo $this->Html->charset();

        echo $this->fetch('meta');
        ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $pageTitle; ?> | Bakery CMS</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

        <?php
        $this->Html->css('bakery/bakery', null, array('inline' => false));

        echo $this->fetch('css');

        /*
         * TO DELETE
         *

        $this->Html->css('flick/jquery-ui-1.10.3.custom.min', null, array('inline' => false));
        $this->Html->css('MediaGallery.jquery.Jcrop.min', null, array('inline' => false));



        $this->Html->script('jquery-1.9.1', array('inline' => false));
        $this->Html->script('jquery.tools.min', array('inline' => false));
        $this->Html->script('jquery-ui-1.10.3.custom.min', array('inline' => false));

        if(!empty($this->request->params['plugin']))
        {
            $this->Html->script('fileuploader', array('inline' => false));
            $this->Html->script('tinymce/tinymce.min', array('inline' => false));
            $this->Html->script('tinymce/jquery.tinymce.min', array('inline' => false));
            $this->Html->script('MediaGallery.bakery.media.gallery', array('inline' => false));
            $this->Html->script('MediaGallery.jquery.Jcrop.min', array('inline' => false));
        }
        */
        ?>

        <script type="text/javascript">
            /*
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
            */
        </script>

    </head>

    <body>
        <div id="wrapper" class="container-fluid">
            <div id="top-bar" class="row">
                <div class="col-md-12">
                    <a href="<?php echo $this->Html->url('/bakery'); ?>">
                        <h4>Bakery CMS</h4>
                    </a>
                </div>
            </div>

            <div class="row">
                <div id="nav-bar" class="col-md-2">
                    <div id="bakery-topFlags"><?php echo $this->Language->flags(); ?></div>

                    <div id="bakery-topMessage"><?php echo $this->CmsWelcome->render(); ?></div>

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

                <div id="main" class="col-md-10">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-header">
                                <h1>
                                    <?php echo $pageTitle; ?>
                                </h1>
                            </div>

                            <?php
                            echo $this->CmsBreadcrumb->render($breadcrumb);

                            echo $this->fetch('content');
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            Powered by <a href="http://leonelquinteros.github.io/bakerycms">Bakery CMS</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

        <?php
        echo $this->fetch('script');

        echo $this->Session->flash();
        ?>

        <?php
        /**
         * SQL Debug dump.
         * Remove on production.
         */
        //echo $this->element('sql_dump');
        ?>
    </body>
</html>
