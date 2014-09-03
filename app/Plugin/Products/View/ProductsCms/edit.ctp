<div id="bakery-actions">
    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3>
                <?php echo __d('cms', 'Actions');?>
            </h3>
        </div>
        <div class="bakery-action-box-content">
            <p class="bakery-action-boxButtons">
                <a href="#" class="action-button-large" onclick="this.onclick = function(){ return false; }; jQuery('#frmProduct').submit(); return false;">
                    <?php echo __d('cms', 'Save');?>
                </a>
                <br />
                <a href="<?php echo $this->Html->url('/bakery/products'); ?>" class="button-large">
                    <?php echo __d('cms', 'Back to products list');?>
                </a>
            </p>
        </div>
        <div class="bakery-action-box-bottom"></div>
    </div>
</div>

<div id="bakery-main">
    <h2 style="margin-top:0px;">
        <?php echo __d('cms', 'Product information'); ?>
    </h2>
    <form id="frmProduct" action="<?php echo $this->Html->url('/bakery/products/edit'); ?>" method="post" enctype="multipart/form-data">
        <div id="bakery-form">
            <?php
            if( !empty($this->data['ProductsProduct']['id']) )
            {
                echo $this->Form->input('ProductsProduct.id', array('type' => 'hidden'));
            }

            echo $this->Form->input('ProductsProduct.name',
                                array(
                                    'label' => __d('cms', 'Name'),
                                )
            );

            echo $this->Form->input('ProductsProduct.url',
                                array(
                                    'label' => __d('cms', 'URL'),
                                )
            );

            echo $this->Form->input('ProductsProduct.category_id',
                                array(
                                    'label' => __d('cms', 'Category'),
                                    'options' => $categories,
                                    'empty' => true,
                                )
            );

            echo $this->Form->input('ProductsProduct.description',
                                array(
                                    'type' => 'textarea',
                                    'label' => __d('cms', 'Description')
                                )
            );

            echo $this->Form->input('ProductsProduct.price',
                                array(
                                    'label' => __d('cms', 'Price'),
                                )
            );
            ?>
        </div>

        <div class="bakery-form-footer">
            <a href="#" class="action-button-medium" onclick="this.onclick = function(){ return false; }; jQuery('#frmProduct').submit(); return false;"><?php echo __d('cms', 'Save');?></a>
        </div>
    </form>
</div>
