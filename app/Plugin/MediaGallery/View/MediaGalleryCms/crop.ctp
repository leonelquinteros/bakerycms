
<?php echo $this->element('help/' . $this->Language->getLanguage() . '/crop'); ?>

<div id="bakery-actions">
	<div class="bakery-action-box">
		<div class="bakery-action-box-top">
			<h3><?php echo __d('cms', 'Actions');?></h3>
		</div>
		<div class="bakery-action-box-content">
			<p class="bakery-action-boxButtons">
				<a href="#" class="action-button-large" onclick="this.onclick = function(){ return false; }; jQuery('#frmCrop').submit(); return false;"><?php echo __d('cms', 'Save crop');?></a>
				<br />
				<a href="<?php echo $this->Html->url('/cms/media_gallery/edit/' . $this->data['MediaGalleryFile']['id']); ?>" class="button-large"><?php echo __d('cms', 'Back to image');?></a>
			</p>
		</div>
		<div class="bakery-action-box-bottom"></div>
	</div>
</div>

<div id="bakery-main">
	<div id="bakery-form">
		<form name="frmCrop" id="frmCrop" method="post" action="<?php echo $this->Html->url('/cms/media_gallery/crop/' . $this->data['MediaGalleryFile']['id']); ?>">	
			<?php 
			if(substr($this->data['MediaGalleryFile']['filetype'], 0, 5) == 'image')
			{
				$imgSize = getimagesize(ROOT . DS . APP_DIR . DS . WEBROOT_DIR . '/media/' . $this->data['MediaGalleryFile']['filename']);
				$trueW = $imgSize[0];
				$trueH = $imgSize[1];
				?>
				<h2 style="margin-top:0px;">
					<?php echo __d('cms', 'Crop image'); ?>
					<a href="#" class="help" rel="#MediaGalleryCropHelp" title="<?php echo __d('cms', 'Help'); ?>">
						<img src="<?php echo $this->Html->url('/img/cms/icons/help_icon.png'); ?>" alt="<?php echo __d('cms', 'Help'); ?>" />
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
				
				<div class="bakery-form-footer">
					<a href="#" class="action-button-medium" onclick="this.onclick = function(){ return false; }; jQuery('#frmCrop').submit(); return false;"><?php echo __d('cms', 'Save crop');?></a>
				</div>
				<?php 
			}
			?>
		</form>
	</div>	
</div>


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
?>
