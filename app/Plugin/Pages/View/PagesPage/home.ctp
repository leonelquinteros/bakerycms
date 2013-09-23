<div class="hero-unit">
    <div id="home-content" class="bakery-cms-edit">
        <?php
        if( !empty($pageContent['home-content']) )
        {
            echo $pageContent['home-content'];
        }
        else
        {
            ?>
            <h1>Welcome</h1>
            <p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
            <p><a class="btn btn-primary btn-large" href="#">Learn more &raquo;</a></p>
            <?php
        }
        ?>
    </div>
</div>

<!-- Example row of columns -->
<div class="row">
    <div class="span4">
        <div id="bottom-column-1" class="bakery-cms-edit">
            <?php
            if( !empty($pageContent['bottom-column-1']) )
            {
                echo $pageContent['bottom-column-1'];
            }
            else
            {
                ?>
                <h2>Heading</h2>
                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                <p><a class="btn" href="#">View details &raquo;</a></p>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="span4">
        <div id="bottom-column-2" class="bakery-cms-edit">
            <?php
            if( !empty($pageContent['bottom-column-2']) )
            {
                echo $pageContent['bottom-column-2'];
            }
            else
            {
                ?>
                <h2>Heading</h2>
                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                <p><a class="btn" href="#">View details &raquo;</a></p>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="span4">
        <div id="bottom-column-3" class="bakery-cms-edit">
            <?php
            if( !empty($pageContent['bottom-column-3']) )
            {
                echo $pageContent['bottom-column-3'];
            }
            else
            {
                ?>
                <h2>Heading</h2>
                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                <p><a class="btn" href="#">View details &raquo;</a></p>
                <?php
            }
            ?>
        </div>
    </div>
</div>
