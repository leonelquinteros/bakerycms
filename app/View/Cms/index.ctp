<div id="bakery-home">
    <div class="bakery-home-box">
        <div class="bakery-home-box-top">
            Latest Pages
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

            <a href="<?php echo $this->Html->url('/bakery/pages/edit/'); ?>">
                <img src="/img/bakery/icons/add.png" alt="" />
                <?php echo __d('cms', 'Create Page'); ?>
            </a>
            <br />
            <a href="<?php echo $this->Html->url('/bakery/pages/'); ?>">
                <img src="/img/bakery/icons/arrow_right.png" alt="" />
                <?php echo __d('cms', 'Go to Pages'); ?>
            </a>
        </div>
    </div>

</div>
