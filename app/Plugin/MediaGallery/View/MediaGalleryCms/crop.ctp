
<?php // echo $this->element('help/' . $this->Language->getLanguage() . '/crop'); ?>

<div class="row">
	<div class="col-md-8">
		<form name="frmCrop" id="frmCrop" method="post" action="<?php echo $this->Html->url('/bakery/media_gallery/crop/' . $this->data['MediaGalleryFile']['id']); ?>">
			<?php
			if(substr($this->data['MediaGalleryFile']['filetype'], 0, 5) == 'image')
			{
				$imgSize = getimagesize(ROOT . DS . APP_DIR . DS . WEBROOT_DIR . '/media/' . $this->data['MediaGalleryFile']['filename']);
				$trueW = $imgSize[0];
				$trueH = $imgSize[1];
				?>
				<h2 style="margin-top:0px;">
					<?php echo __d('cms', 'Crop image'); ?>
					<a href="#" class="pull-right" data-toggle="modal" data-target="#MediaGalleryCropHelp" title="<?php echo __d('cms', 'Help'); ?>">
						<i class="fa fa-question-circle"></i>
					</a>
				</h2>

				<div style="margin:20px 0px;">
					<strong><?php echo $this->data['MediaGalleryFile']['filename']; ?></strong>
				</div>

				<div id="cropContainer">
					<img id="imageCrop" src="<?php echo $this->Html->url('/media_gallery/thumb/730/0/' . $this->data['MediaGalleryFile']['filename'] . '?nocache=' . time()); ?>" alt="Image" />
				</div>

				<div style="margin-top:20px;font-size:1.2em;">
					<?php echo __d('cms', 'Crop width'); ?>: <strong id="cropWidth">0</strong>px.
					<br />
					<?php echo __d('cms', 'Crop height'); ?>: <strong id="cropHeight">0</strong>px.
				</div>

				<input type="hidden" id="cropX" name="x" value="" />
				<input type="hidden" id="cropY" name="y" value="" />
				<input type="hidden" id="cropW" name="w" value="" />
				<input type="hidden" id="cropH" name="h" value="" />
				<?php
			}
			?>
		</form>
	</div>

	<div class="col-md-4">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	        	<?php echo __d('cms', 'Actions');?>
	        </div>

	        <div class="panel-body">
	        	<p>
    				<a href="#" class="btn btn-success btn-block" onclick="this.onclick = function(){ return false; }; jQuery('#frmCrop').submit(); return false;">
    					<?php echo __d('cms', 'Save crop');?>
    				</a>
    				<br />
    				<a href="<?php echo $this->Html->url('/bakery/media_gallery/edit/' . $this->data['MediaGalleryFile']['id']); ?>" class="btn btn-warning btn-block">
    					<?php echo __d('cms', 'Back to image');?>
    				</a>
    			</p>
	        </div>
	    </div>
	</div>
</div>

<?php
$this->start('script');
?>
<script type="text/javascript" src="/media_gallery/js/jquery.Jcrop.min.js" />
<?php
if(substr($this->data['MediaGalleryFile']['filetype'], 0, 5) == 'image')
{
	?>
	<script type="text/javascript">
		var setCrop = function(c) {
			jQuery('#cropX').val(c.x);
			jQuery('#cropY').val(c.y);
			jQuery('#cropW').val(c.w);
			jQuery('#cropH').val(c.h);

			// Show fields
			jQuery('#cropWidth').html(c.w);
			jQuery('#cropHeight').html(c.h);
		};

		jQuery('#imageCrop').load( function() {
			var imgCrop = jQuery.Jcrop('#imageCrop',
					{
						onChange: setCrop,
						trueSize: [<?php echo $trueW; ?>, <?php echo $trueH; ?>],
						keySupport: false
					}
			);
		});
	</script>
	<?php
}

$this->end('script');
?>
