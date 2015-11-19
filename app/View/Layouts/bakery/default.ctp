<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	echo $this->fetch('meta');
    ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bakery CMS">
    <meta name="author" content="Leonel Quinteros">

    <title><?php echo $pageTitle; ?> | Bakery CMS</title>

    <!-- Bootstrap Core CSS -->
    <link href="/sbadmin/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/sbadmin/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/sbadmin/dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="/css/bakery/bakery.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/sbadmin/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<?php
	// Custom CSS
	echo $this->fetch('css');
	?>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/bakery">Bakery CMS</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                        	<a href="<?php echo $this->Html->url('/bakery/admins/edit/' . $_SESSION['CMSAdministratorLogin']['AdminsAdmin']['id']); ?>">
                        		<i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['CMSAdministratorLogin']['AdminsAdmin']['name']; ?>
                        	</a>
                        </li>
                        </li>
                        <li class="divider"></li>
                        <li>
                        	<a href="<?php echo $this->Html->url('/bakery/logout/'); ?>">
                        		<i class="fa fa-sign-out fa-fw"></i> <?php echo __d('cms', 'Logout'); ?>
                        	</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                    	<?php
                        foreach($cmsMenu as $menu)
                        {
                            $active = '';
                            if($this->request->params['plugin'] == $menu['plugin'])
                            {
                                $active = 'active';
                            }
                            ?>
                            <li class="<?php echo $active; ?>">
                                <a href="<?php echo $this->Html->url($menu['link']); ?>"><?php echo $menu['name']; ?></a>
                                <?php
                                if(!empty($menu['submenu']))
                                {
                                    ?>
                                    <ul class="nav nav-second-level">
                                        <?php
                                    	foreach($menu['submenu'] as $title => $link)
                                        {
                                            ?>
                                            <li>
                                                <a href="<?php echo $this->Html->url($link); ?>"><?php echo $title; ?></a>
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
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                    	<?php
                        echo $this->CmsBreadcrumb->render($breadcrumb);
                        ?>

                        <?php echo $this->Flash->render(); ?>

                        <h1 class="page-header"><?php echo $pageTitle; ?></h1>

                        <?php
                        echo $this->fetch('content');
                        ?>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-xs-12">
                     	<p>
                     		<br />
                     		<br />
                     		<br />
                     		<br />
                     		<br />
                     		<hr />
                          	Powered by <a href="http://github.com/leonelquinteros/bakerycms">Bakery CMS</a>
                        </p>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="/sbadmin/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/sbadmin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/sbadmin/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="/sbadmin/dist/js/sb-admin-2.js"></script>

    <?php
    // View scripts
    echo $this->fetch('script');
    ?>

</body>

</html>
