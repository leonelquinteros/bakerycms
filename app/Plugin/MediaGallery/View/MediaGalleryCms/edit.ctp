
<?php //echo $this->element('help/' . $this->Language->getLanguage() . '/edit'); ?>

<div class="row">
	<div class="col-md-8">
		<form id="frmMediaGallery" action="<?php echo $this->Html->url('/bakery/media_gallery/edit/' . $this->data['MediaGalleryFile']['id']); ?>" method="post" enctype="multipart/form-data">
            <h2 style="margin-top:0px;">
                <?php echo __d('cms', 'File info'); ?>

                <a href="#" class="pull-right" data-toggle="modal" data-target="#MediaGalleryFileHelp" title="<?php echo __d('cms', 'Help'); ?>">
                    <i class="fa fa-question-circle"></i>
                </a>
            </h2>
            <?php
            $this->Form->inputDefaults(
            		array(
            				'div'	=> array(
            						'class' => 'form-group',
            				),
            				'class' => 'form-control',
            		)
            );

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

            <div>
                <a href="#" class="btn btn-lg btn-success" onclick="this.onclick = function(){ return false; }; jQuery('#frmMediaGallery').submit(); return false;"><?php echo __d('cms', 'Save');?></a>
            </div>
        </form>

        <?php
        if(substr($this->data['MediaGalleryFile']['filetype'], 0, 5) == 'image')
        {
            ?>
            <hr />
            <h2>
                <?php echo __d('cms', 'Preview'); ?>

                <a href="#" class="pull-right" data-toggle="modal" data-target="#MediaGalleryPreviewHelp" title="<?php echo __d('cms', 'Help'); ?>">
                    <i class="fa fa-question-circle"></i>
                </a>
            </h2>

            <div id="cropContainer">
                <img id="imageCrop" src="<?php echo $this->Html->url('/media_gallery/thumb/720/0/' . $this->data['MediaGalleryFile']['filename'] . '?nocache=' . time()); ?>" alt="Image" />
            </div>

			<br />

            <div>
                <a href="<?php echo $this->Html->url('/bakery/media_gallery/crop/' . $this->data['MediaGalleryFile']['id']); ?>" id="btnCrop" class="btn btn-lg btn-primary">
                	<?php echo __d('cms', 'Crop image'); ?>
                </a>
            </div>
            <?php
        }
        elseif(substr($this->data['MediaGalleryFile']['filetype'], 0, 5) == 'video')
        {
            ?>
            <hr />
            <h2>
                <?php echo __d('cms', 'Preview'); ?>

                <a href="#" class="pull-right" data-toggle="modal" data-target="#MediaGalleryPreviewHelp" title="<?php echo __d('cms', 'Help'); ?>">
                    <i class="fa fa-question-circle"></i>
                </a>
            </h2>
            <div id="videoPlayer" style="width:730px;height:400px;text-align:center;"></div>
            <?php
        }
        ?>
	</div>

	<div class="col-md-4">
	    <div class="panel panel-default">
	        <div class="panel-heading">
                <?php echo __d('cms', 'Actions');?>

                <a href="#" class="pull-right" data-toggle="modal" data-target="#MediaGalleryActionsHelp">
		        	<i class="fa fa-question-circle"></i>
		        </a>
	        </div>

	        <div class="panel-body">
	            <p>
	            	<a href="#" class="btn btn-success btn-block" onclick="this.onclick = function(){ return false; }; jQuery('#frmMediaGallery').submit(); return false;">
	            		<?php echo __d('cms', 'Save');?>
	            	</a>
                    <br />
                    <a href="<?php echo $this->Html->url('/bakery/media_gallery'); ?>" class="btn btn-warning btn-block">
                    	<?php echo __d('cms', 'Back to gallery');?>
                    </a>
	            </p>
	        </div>
	    </div>
	</div>
</div>

<?php
if(substr($this->data['MediaGalleryFile']['filetype'], 0, 5) == 'video')
{
    $this->start('script');
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
    $this->end('script');
}
?>
