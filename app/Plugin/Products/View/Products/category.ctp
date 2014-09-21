<div class="container">
    <h1><?php echo $category['ProductsCategory']['name']; ?></h1>

    <div>
        <?php
        foreach($category['Products'] as $p)
        {
            if(!empty($p['Images']))
            {
                ?>
                <a href="/products/<?php echo $category['ProductsCategory']['url']; ?>/<?php echo $p['url']; ?>">
                    <img src="/media_gallery/thumb/100/100/<?php echo $p['Images'][0]['image']; ?>" alt="" />
                </a>
                <?php
            }
        }
        ?>
    </div>

</div> <!-- /container -->
