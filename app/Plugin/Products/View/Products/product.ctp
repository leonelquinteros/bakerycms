<div class="container">
    <h1><?php echo $product['ProductsProduct']['name']; ?></h1>

    <div>
        <?php
        foreach($product['Images'] as $i)
        {
            ?>
            <img src="/media_gallery/thumb/100/100/<?php echo $i['image']; ?>" alt="" />
            <?php
        }
        ?>
    </div>

</div> <!-- /container -->
