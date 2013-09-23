<h1><?php echo $pageTitle; ?></h1>

<div class="hero-unit">
    <div id="main-content" class="bakery-cms-edit">
        <?php
        if( !empty($pageContent['main-content']) )
        {
            echo $pageContent['main-content'];
        }
        ?>
    </div>
</div>
