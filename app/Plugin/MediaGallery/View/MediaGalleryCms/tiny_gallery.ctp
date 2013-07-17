<style type="text/css">
	#tinyMediaGalleryForm {
		position: relative;
		text-align: left;
		border: 1px solid #ffffff;
		padding: 10px;
	}
	
	a.button-large {
		display: inline-block;
		width: 224px;
		height: 31px;
		padding-top: 13px;
		background: url('/img/cms/big_button_xl.png') no-repeat top center;
		text-align: center;
		font-size: 14px;
		color: #285D8B;
		text-shadow: #ffffff 0px 1px 1px;
	}
	
	#tinyMediaGalleryForm #uploadResult {
		margin-left: 40px;
		font-weight: bold;
		color: #285D8B;
	}
	
	#tinyMediaGalleryForm img {
		position: absolute;
		top: 15px;
		left: 240px;
		visibility: hidden;
	}
	
	#tinyMediaGalleryFiles {
		position: relative;
		text-align: center;
		width: 765px;
		height: 420px;
		overflow: scroll;
	}
	
	#tinyMediaGalleryInsert {
		display: none;
	}
	
		#tinyMediaGalleryInsert label {
			display: inline-block;
			width: 50px;
		}
		
		#tinyMediaGalleryInsert input {
			position: relative;
			display: inline-block;
			width: 150px;
			margin-left: 10px;
		}
	
	.prevPage {
		float: left;
		cursor: pointer;
		color: #285D8B;
	}
	
	.nextPage {
		float: right;
		cursor: pointer;
		color: #285D8B;
	}
</style>

<div id="tinyMediaGalleryContainer">
	<div id="tinyMediaGalleryForm">
		<a href="#" id="uploadFile" class="button-large"><?php echo __d('cms', 'Upload file'); ?></a>
		
		<img src="<?php echo $this->Html->url('/img/cms/loader.gif'); ?>" alt="Loading" id="imgLoading" /><span id="uploadResult"></span>
	</div>
	
	<div id="tinyMediaGalleryFiles"></div>
</div>

<div id="tinyMediaGalleryInsert">
	<input type="hidden" name="filename" id="filename" class="tiny-filename" value="" />
	<input type="hidden" name="filetype" id="filetype" class="tiny-filetype" value="" />
	
	<label for="title"><?php echo __d('cms', 'Title');?></label>
	<input type="text" name="title" id="title" class="tiny-title" />
	<br />
	
	<div class="tiny-imageProperties">
		<label for="width"><?php echo __d('cms', 'Width');?></label>
		<input type="text" name="width" id="width" class="tiny-width" />
		<br />
		
		<label for="height"><?php echo __d('cms', 'Height');?></label>
		<input type="text" name="height" id="height" class="tiny-height" />
		<br />
	</div>
	<a href="#" onclick="tinyInsertMedia();" class="button-large"><?php echo __d('cms', 'Insert media');?></a>
</div>

<script type="text/javascript">
	new qq.FileUploader({
        element: jQuery('#uploadFile')[0],
		action: '/cms/media_gallery_ajax/upload',
		name: 'galleryUpload',
		onSubmit: function(id, fileName) {
			jQuery('#imgLoading').css('visibility', 'visible');
			jQuery('#uploadResult').html('Sending file...');
		},
		onComplete: function(id, fileName) {
			jQuery('#imgLoading').css('visibility', 'hidden');
			jQuery('#uploadResult').html('');
			
			loadGalleryFiles();
		}
	});
	
	function loadGalleryFiles() {
		jQuery('#tinyMediaGalleryFiles').html('<img src="<?php echo $this->Html->url('/img/cms/loader.gif'); ?>" alt="Loading gallery files..." id="imgLoading" />');
		
		jQuery.ajax(
				{
					url: '/cms/media_gallery_ajax/files',
					success: function(data) {
				    	jQuery('#tinyMediaGalleryFiles').html(data);
				  	}
									
				}
		);
	}
	loadGalleryFiles();

	function tinyInsertMediaForm(data) {
		if(data.type != 'image') {
			jQuery('#imageProperties').hide();
		} else {
			jQuery('#imageProperties').show();
		}
		
		jQuery('#tinyMediaGalleryInsert').dialog({
					width: 250,
					modal: true,
					resizable: false,
					title: '<?php echo __d('cms', 'Insert media'); ?>',
					open: function() {
							jQuery('#filename').val(data.src);
							jQuery('#filetype').val(data.type);
							jQuery('#title').val(data.title);
							jQuery('#width').val('320');
							jQuery('#height').val('0');
					},
					close: function() {
							jQuery('#tinyMediaGalleryInsert').dialog('destroy');
					}
		});
	}

	function tinyInsertMedia() {
		if(jQuery('#filetype').val() == 'image') {
			content = '<img src="<?php echo $this->Html->url('/media_gallery/thumb'); ?>/' +
										jQuery('#width').val() + '/' +
										jQuery('#height').val() + '/' +
										jQuery('#filename').val() +
										'" alt="' + jQuery('#title').val() + '" />';
		} else {
			content = '<a href="<?php echo $this->Html->url('/media'); ?>/' + jQuery('#filename').val() + '">' + jQuery('#title').val() + '</a>';
		}
		
		tinyMCE.activeEditor.execCommand('mceInsertContent', false, content);

		jQuery('#tinyMediaGalleryInsert').dialog('close');
		jQuery('.mediagallery-dialog').dialog('close');
	}
</script>
