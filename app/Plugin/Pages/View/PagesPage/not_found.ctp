<h1><?php echo $pageTitle; ?></h1>

<div id="big-page" class="big-page">
    <div id="mainContent" class="bakery-cms-edit">
        <?php
        if( !empty($pageContent['mainContent']) )
        {
            echo $pageContent['mainContent'];
        }
        ?>
    </div>
</div>
