<?php echo $this->Html->docType('html5'); ?>

<html>
    <head>
        <title>Bakery CMS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php
        echo $this->fetch('meta');

        if(empty($editMode))
        {
            // Get inserted by TinyMCE
            echo $this->Html->css('bootstrap/css/bootstrap.min');
            echo $this->Html->css('bootstrap/css/bootstrap-responsive.min');
        }

        echo $this->fetch('css');

        $this->Html->script('jquery-1.9.1', array('inline' => false));

        echo $this->fetch('script');
        ?>
    </head>

    <body>
        <div class="navbar navbar-inverse">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="/">Bakery CMS Demo</a>
                    <div class="nav-collapse collapse">
                        <?php
                        if(!empty($menuData['Main']))
                        {
                            ?>
                            <ul class="nav">
                                <?php
                                foreach($menuData['Main'] as $menuItem)
                                {
                                    ?>
                                    <li <?php if(!empty($menuItem['subMenu'])) echo 'class="dropdown"'; ?>>
                                        <a href="<?php echo $menuItem['MenusMenu']['link']; ?>" <?php if(!empty($menuItem['subMenu'])) echo 'class="dropdown-toggle" data-toggle="dropdown"'; ?>>
                                            <?php
                                            echo $menuItem['MenusMenu']['title'];

                                            if(!empty($menuItem['subMenu']))
                                            {
                                                echo ' <b class="caret"></b>';
                                            }
                                            ?>
                                        </a>
                                        <?php
                                        if(!empty($menuItem['subMenu']))
                                        {
                                            ?>
                                            <ul class="dropdown-menu">
                                                <?php
                                                foreach($menuItem['subMenu'] as $subMenuItem)
                                                {
                                                    ?>
                                                    <li>
                                                        <a href="<?php echo $subMenuItem['MenusMenu']['link']; ?>">
                                                            <?php echo $subMenuItem['MenusMenu']['title']; ?>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                            <?php
                                        }
                                        ?>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <?php
                        }

                        /**
                         * Bootstrap menu code. for reference
                         *
                        <ul class="nav">
                            <li class="active"><a href="/">Home</a></li>
                            <li><a href="#about">About</a></li>
                            <li><a href="#contact">Contact</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header">Nav header</li>
                                    <li><a href="#">Separated link</a></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>
                        </ul -->
                        *
                        */
                        ?>
                    </div><!--/.nav-collapse -->


                </div>
            </div>
        </div>

        <div class="container">
            <?php echo $content_for_layout; ?>

            <hr>

            <footer>
                <p>
                    &copy; Bakery CMS 2013

                    <?php
                    foreach($menuData['Bottom'] as $menuItem)
                    {
                        ?>
                        | <a href="<?php echo $menuItem['MenusMenu']['link']; ?>"><?php echo $menuItem['MenusMenu']['title']; ?></a>
                        <?php
                    }
                    ?>
                </p>
            </footer>
        </div> <!-- /container -->

        <script src="/css/bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
