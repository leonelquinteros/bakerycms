<div class="container">
    <h1>Categories</h1>

    <div>
        <?php
        foreach($categories as $c)
        {
            ?>
            <a href="/products/<?php echo $c['ProductsCategory']['url']; ?>">
                <img src="/media_gallery/thumb/100/100/<?php echo $c['ProductsCategory']['image']; ?>" alt="" />
            </a>
            <?php
        }
        ?>
    </div>

</div> <!-- /container -->
