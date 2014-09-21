
<div id="bakery-actions">
    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3>
                <?php echo __d('cms', 'Actions');?>
            </h3>
        </div>
        <div class="bakery-action-box-content">
            <p class="bakery-action-boxButtons">
                <a href="#" class="action-button-large" onclick="this.onclick = function(){ return false; }; jQuery('#frmCategory').submit(); return false;">
                    <?php echo __d('cms', 'Save');?>
                </a>
                <br />
                <a href="<?php echo $this->Html->url('/bakery/products/categories'); ?>" class="button-large">
                    <?php echo __d('cms', 'Back to categories list');?>
                </a>
            </p>
        </div>
        <div class="bakery-action-box-bottom"></div>
    </div>
</div>

<div id="bakery-main">
    <h2 style="margin-top:0px;">
        <?php echo __d('cms', 'Category information'); ?>
    </h2>
    <form id="frmCategory" action="<?php echo $this->Html->url('/bakery/products/categories/edit'); ?>" method="post" enctype="multipart/form-data">
        <div id="bakery-form">
            <?php
            if( !empty($this->data['ProductsCategory']['id']) )
            {
                echo $this->Form->input('ProductsCategory.id', array('type' => 'hidden'));
            }

            echo $this->Form->input('ProductsCategory.name',
                                array(
                                    'label' => __d('cms', 'Name'),
                                )
            );

            echo $this->Form->input('ProductsCategory.url',
                                array(
                                    'label' => __d('cms', 'URL'),
                                )
            );

            echo $this->Form->input('ProductsCategory.description',
                                array(
                                    'type' => 'textarea',
                                    'label' => __d('cms', 'Description')
                                )
            );

            echo $this->Form->input('ProductsCategory.image',
                                array(
                                    'label' => __d('cms', 'Image'),
                                    'readonly' => 'readonly',
                                )
            );

            ?>

            <a href="#" class="button-medium" id="categoryImage"><?php echo __d('cms', 'Pick an image'); ?></a>

            <?php

            if(!empty($this->data['ProductsCategory']['image']))
            {
                ?>
                <br />
                <h4><?php echo __d('cms', 'Image preview'); ?></h4>
                <img src="/media_gallery/thumb/400/0/<?php echo $this->data['ProductsCategory']['image']; ?>" alt="" />
                <br />
                <?php
            }
            ?>
        </div>

        <div class="bakery-form-footer">
            <a href="#" class="action-button-medium" onclick="this.onclick = function(){ return false; }; jQuery('#frmCategory').submit(); return false;"><?php echo __d('cms', 'Save');?></a>
        </div>
    </form>
</div>

<div id="mediagallery-container" class="mediagallery-dialog" style="display:none;z-index:9999"></div>

<script type="text/javascript">
    // OnDomReady
    jQuery(document).ready( function() {
        // Media Gallery
        jQuery('#mediagallery-container').bakeryMediaGallery({
                handler: '#categoryImage',
                type: 'image',
                onClick: function(element) {
                    jQuery('#ProductsCategoryImage').val(jQuery(element).data('src'));
                    jQuery('#mediagallery-container').dialog('close');

                    return false;
                }
        });
    });
</script>
