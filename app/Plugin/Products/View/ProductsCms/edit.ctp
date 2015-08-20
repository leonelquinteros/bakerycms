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
            $this->Form->inputDefaults(
            		array(
            				'div'	=> array(
            						'class' => 'form-group',
            				),
            				'class' => 'form-control',
            		)
            );
            
            if( !empty($this->data['ProductsProduct']['id']) )
            {
                echo $this->Form->input('ProductsProduct.id', array('type' => 'hidden'));
            }

            echo $this->Form->input('ProductsProduct.name',
                                array(
                                    'label' => __d('cms', 'Name'),
                                    'error' => __d('cms', 'Please fill in a name for this product'),
                                )
            );

            echo $this->Form->input('ProductsProduct.url',
                                array(
                                    'label' => __d('cms', 'URL'),
                                    'error' => __d('cms', "If you don't fill in an URL now, the product name will be used."),
                                )
            );

            echo $this->Form->input('ProductsProduct.category_id',
                                array(
                                    'label' => __d('cms', 'Category'),
                                    'options' => $categories,
                                    'empty' => true,
                                    'error' => __d('cms', 'Please select a category for this product'),
                                )
            );

            echo $this->Form->input('ProductsProduct.description',
                                array(
                                    'type' => 'textarea',
                                    'label' => __d('cms', 'Description'),
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
            <a href="#" class="action-button-medium" onclick="this.onclick = function(){ return false; }; jQuery('#frmProduct').submit(); return false;">
                <?php echo __d('cms', 'Save'); ?>
            </a>
        </div>


        <?php
        // Images
        if( !empty($this->data['ProductsProduct']['id']) )
        {
            ?>
            <h2>
                <?php echo __d('cms', 'Product images'); ?>
            </h2>

            <div class="product-images">
                <?php
                foreach($this->data['Images'] as $image)
                {
                    ?>
                    <div class="product-image">
                        <img src="/media_gallery/resizecrop/100/100/<?php echo $image['image']; ?>" alt="" />
                        <br />
                        <a href="/bakery/products/delete_image/<?php echo $image['id']; ?>/<?php echo $this->data['ProductsProduct']['id']; ?>">
                            <?php echo __d('cms', 'Delete'); ?>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>

            <a href="#" id="addImage" class="button-medium">
                <?php echo __d('cms', 'Add image'); ?>
            </a>
            <?php
        }
        ?>
    </form>
</div>


<?php
// Images
if( !empty($this->data['ProductsProduct']['id']) )
{
    ?>
    <div id="mediagallery-container" class="mediagallery-dialog" style="display:none;z-index:9999"></div>

    <script type="text/javascript">
        // OnDomReady
        jQuery(document).ready( function() {
            // Media Gallery
            jQuery('#mediagallery-container').bakeryMediaGallery({
                    handler: '#addImage',
                    type: 'image',
                    onClick: function(element) {
                        jQuery.ajax({
                            url: "/bakery/products/add_image",
                            type: 'POST',
                            data: {
                                product_id: <?php echo $this->data['ProductsProduct']['id']; ?>,
                                image: jQuery(element).data('src')
                            },
                            success: function() {
                                location.reload();
                            },
                        });

                        jQuery('#mediagallery-container').dialog('close');

                        return false;
                    }
            });
        });
    </script>
    <?php
}
?>
