<div class="container">
    <h1><?php echo $pageTitle; ?></h1>

    <div id="page-content" class="bakery-cms-edit">
        <?php
        if( !empty($pageContent['page-content']) )
        {
            echo $pageContent['page-content'];
        }
        ?>
    </div>

</div> <!-- /container -->
