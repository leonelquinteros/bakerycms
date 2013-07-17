<div class="cmsMediaGalleryFilesScroller">
	<?php
	foreach($files as $file)
	{
		?>
		<div style="float:left;margin:10px;padding:10px;width:64px;height:100px;border:1px solid #285D8B;position:relative;overflow:hidden;">
			<?php
			if(substr($file['MediaGalleryFile']['filetype'], 0, 5) == 'image')
			{
			?>
				<a href="#" class="cmsMediaGalleryFile" data-type="image" data-id="<?php echo $file['MediaGalleryFile']['id']; ?>" data-src="<?php echo $file['MediaGalleryFile']['filename']; ?>" data-title="<?php echo $file['MediaGalleryFile']['title']; ?>">
					<img src="<?php echo $this->Html->url('/media_gallery/thumb/64/0/' . $file['MediaGalleryFile']['filename']); ?>" style="max-height:64px;" alt="" />
				</a>
				<br />
				<span style="font-size:0.7em;"><?php echo $file['MediaGalleryFile']['title']; ?></span>
			<?php
			}
			else
			{
				switch(substr($file['MediaGalleryFile']['filetype'], 0, 5))
				{
					case 'video':
					case 'audio':
						$mediaType = substr($file['MediaGalleryFile']['filetype'], 0, 5);
						break;
						
					default:
						$mediaType = 'application';
						 
				}
				?>
				<a href="#" class="cmsMediaGalleryFile" data-type="<?php echo $mediaType; ?>" data-id="<?php echo $file['MediaGalleryFile']['id']; ?>" data-src="<?php echo $file['MediaGalleryFile']['filename']; ?>" data-title="<?php echo $file['MediaGalleryFile']['title']; ?>">
					<img src="<?php echo $this->Html->url('/media_gallery/thumb/64/0/document-icon.png'); ?>" style="max-height:64px;" alt="" />
				</a>
				<br />
				<span style="font-size:0.7em;"><?php echo $file['MediaGalleryFile']['title']; ?></span>
				<?php
			}
			?>
		</div>
		<?php
	}
	?>
</div>
