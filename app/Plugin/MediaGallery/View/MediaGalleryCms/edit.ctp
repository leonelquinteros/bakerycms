
<?php echo $this->element('help/' . $this->Language->getLanguage() . '/edit'); ?>

<div id="bakery-actions">
    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3>
                <?php echo __d('cms', 'Actions');?>
                <a href="#" class="help" rel="#MediaGalleryActionsHelp" title="<?php echo __d('cms', 'Help'); ?>">
                    <img src="<?php echo $this->Html->url('/img/bakery/icons/help_icon.png'); ?>" alt="<?php echo __d('cms', 'Help'); ?>" />
                </a>
            </h3>
        </div>
        <div class="bakery-action-box-content">
            <p class="bakery-action-boxButtons">
                <a href="#" class="action-button-large" onclick="this.onclick = function(){ return false; }; jQuery('#frmMediaGallery').submit(); return false;"><?php echo __d('cms', 'Save');?></a>
                <br />
                <a href="<?php echo $this->Html->url('/bakery/media_gallery'); ?>" class="button-large"><?php echo __d('cms', 'Back to gallery');?></a>
            </p>
        </div>
        <div class="bakery-action-box-bottom"></div>
    </div>

    <?php
    if(substr($this->data['MediaGalleryFile']['filetype'], 0, 5) == 'image')
    {
        ?>
        <div class="bakery-action-box">
            <div class="bakery-action-box-top">
                <h3>
                    <?php echo __d('cms', 'Image');?>
                    <a href="#" class="help" rel="#MediaGalleryCropHelp" title="<?php echo __d('cms', 'Help'); ?>">
                        <img src="<?php echo $this->Html->url('/img/bakery/icons/help_icon.png'); ?>" alt="<?php echo __d('cms', 'Help'); ?>" />
                    </a>
                </h3>
            </div>
            <div class="bakery-action-box-content">
                <p class="bakery-action-boxButtons">
                    <a href="<?php echo $this->Html->url('/bakery/media_gallery/crop/' . $this->data['MediaGalleryFile']['id']); ?>" id="btnCrop" class="button-large">Crop image</a>
                </p>
            </div>
            <div class="bakery-action-box-bottom"></div>
        </div>
        <?php
    }
    ?>
</div>

<div id="bakery-main">
    <div id="bakery-form">
        <form id="frmMediaGallery" action="<?php echo $this->Html->url('/bakery/media_gallery/edit/' . $this->data['MediaGalleryFile']['id']); ?>" method="post" enctype="multipart/form-data">
            <h2 style="margin-top:0px;">
                <?php echo __d('cms', 'File info'); ?>
                <a href="#" class="help" rel="#MediaGalleryFileHelp" title="<?php echo __d('cms', 'Help'); ?>">
                    <img src="<?php echo $this->Html->url('/img/bakery/icons/help_icon.png'); ?>" alt="<?php echo __d('cms', 'Help'); ?>" />
                </a>
            </h2>
            <?php
            echo $this->Form->input('MediaGalleryFile.id', array('type' => 'hidden'));

            echo $this->Form->input('MediaGalleryFile.title',
                                array(
                                    'label' => __d('cms', 'Title')
                                )
            );

            echo $this->Form->input('MediaGalleryFile.description',
                                array(
                                    'label' => __d('cms', 'Description')
                                )
            );

            ?>

            <div class="bakery-form-footer">
                <a href="#" class="action-button-medium" onclick="this.onclick = function(){ return false; }; jQuery('#frmMediaGallery').submit(); return false;"><?php echo __d('cms', 'Save');?></a>
            </div>
        </form>

        <?php
        if(substr($this->data['MediaGalleryFile']['filetype'], 0, 5) == 'image')
        {
            ?>
            <h2>
                <?php echo __d('cms', 'Preview'); ?>
                <a href="#" class="help" rel="#MediaGalleryPreviewHelp" title="<?php echo __d('cms', 'Help'); ?>">
                    <img src="<?php echo $this->Html->url('/img/bakery/icons/help_icon.png'); ?>" alt="<?php echo __d('cms', 'Help'); ?>" />
                </a>
            </h2>

            <div id="cropContainer">
                <img id="imageCrop" src="<?php echo $this->Html->url('/media_gallery/thumb/720/0/' . $this->data['MediaGalleryFile']['filename'] . '?nocache=' . time()); ?>" alt="Image" />
            </div>

            <span><?php echo $this->data['MediaGalleryFile']['filename']; ?></span>

            <div class="bakery-form-footer">
                <a href="<?php echo $this->Html->url('/bakery/media_gallery/crop/' . $this->data['MediaGalleryFile']['id']); ?>" id="btnCrop" class="button-medium">Crop image</a>
            </div>
            <?php
        }
        elseif(substr($this->data['MediaGalleryFile']['filetype'], 0, 5) == 'video')
        {
            ?>
            <h2>
                <?php echo __d('cms', 'Preview'); ?>
                <a href="#" class="help" rel="#MediaGalleryPreviewHelp" title="<?php echo __d('cms', 'Help'); ?>">
                    <img src="<?php echo $this->Html->url('/img/bakery/icons/help_icon.png'); ?>" alt="<?php echo __d('cms', 'Help'); ?>" />
                </a>
            </h2>
            <div id="videoPlayer" style="width:730px;height:400px;text-align:center;"></div>
            <?php
        }
        ?>
    </div>
</div>

<?php
if(substr($this->data['MediaGalleryFile']['filetype'], 0, 5) == 'video')
{
    ?>
    <script type="text/javascript">
        jQuery(function() {
            jQuery("#videoPlayer").flashembed(
                    {
                        src: '/swf/mediaplayer.swf'
                    },
                    {
                        file: '/media/<?php echo $this->data['MediaGalleryFile']['filename']; ?>',
                        backcolor: '0xcccccc',
                        frontcolor: '0x000000',
                        lightcolor: '0xffffff',
                        screencolor: '0x000000',
                        smoothing: 'true',
                        usefullscreen: 'true',
                        volume: '80',
                        showdigits: 'true',
                        bufferlength: '5',
                        autostart: 'false'
                    }
            );
        });
    </script>
    <?php
}
?>
