<div id="bakery-home">
    <div class="bakery-home-box">
        <div class="bakery-home-box-top">
            <?php echo __d('cms', 'Latest Pages'); ?>
        </div>
        <div class="bakery-home-box-content">
            <?php
            foreach($pages as $p)
            {
                ?>
                <a href="<?php echo $this->Html->url('/bakery/pages/edit/') . $p['PagesPage']['id']; ?>">
                    <img src="/img/bakery/icons/application_edit.png" alt="Edit" />
                    <?php echo $this->Text->truncate($p['PagesPage']['title'], 75, array('ending' => '...')); ?>
                </a>
                <br />
                <?php
            }
            ?>

            <hr />

            <a href="<?php echo $this->Html->url('/bakery/pages/'); ?>">
                <img src="/img/bakery/icons/arrow_right.png" alt="" />
                <?php echo __d('cms', 'Go to Pages'); ?>
            </a>
        </div>
    </div>


    <div class="bakery-home-box">
        <div class="bakery-home-box-top">
            <?php echo __d('cms', 'Latest Menu Items'); ?>
        </div>
        <div class="bakery-home-box-content">
            <?php
            foreach($menus as $m)
            {
                ?>
                <a href="<?php echo $this->Html->url('/bakery/menus/edit/') . $m['MenusMenu']['lang'] . '/' . $m['MenusMenu']['name'] . '/' . $m['MenusMenu']['id']; ?>">
                    <img src="/img/bakery/icons/application_edit.png" alt="Edit" />
                    <?php echo $this->Text->truncate($m['MenusMenu']['title'], 75, array('ending' => '...')); ?>
                </a>
                <br />
                <?php
            }
            ?>

            <hr />

            <a href="<?php echo $this->Html->url('/bakery/menus/'); ?>">
                <img src="/img/bakery/icons/arrow_right.png" alt="" />
                <?php echo __d('cms', 'Go to Menu Structure'); ?>
            </a>
        </div>
    </div>

    <div class="bakery-home-box">
        <div class="bakery-home-box-top">
            <?php echo __d('cms', 'Latest Media Files'); ?>
        </div>
        <div class="bakery-home-box-content">
            <?php
            foreach($media as $m)
            {
                ?>
                <a href="<?php echo $this->Html->url('/bakery/media_gallery/edit/') . $m['MediaGalleryFile']['id']; ?>">
                    <img src="/img/bakery/icons/application_edit.png" alt="Edit" />
                    <?php echo $this->Text->truncate($m['MediaGalleryFile']['title'], 75, array('ending' => '...')); ?>
                </a>
                <br />
                <?php
            }
            ?>

            <hr />

            <a href="<?php echo $this->Html->url('/bakery/media_gallery/'); ?>">
                <img src="/img/bakery/icons/arrow_right.png" alt="" />
                <?php echo __d('cms', 'Go to Media Gallery'); ?>
            </a>
        </div>
    </div>

</div>
