
<?php // echo $this->element('help/' . $this->Language->getLanguage() . '/index'); ?>

<div class="row">
	<div class="col-md-8">
		<div class="table-responsive">
		    <table class="table table-striped table-bordered table-hover">
		        <thead>
		            <tr>
		                <th><?php echo $this->Paginator->sort('MediaGalleryFile.filetype', __d('cms', 'File'));?></th>
		                <th><?php echo $this->Paginator->sort('MediaGalleryFile.title', __d('cms', 'Title'));?></th>
		                <th><?php echo __d('cms', 'Actions');?></th>
		            </tr>
		        </thead>
		        <tbody>
		            <?php
		            foreach($files as $file)
		            {
		                ?>
		                <tr>
		                    <td class="text-center">
		                        <?php
		                        if(substr($file['MediaGalleryFile']['filetype'], 0, 5) == 'image')
		                        {
		                            ?>
		                            <img src="<?php echo $this->Html->url('/media_gallery/thumb/48/48/' . $file['MediaGalleryFile']['filename']); ?>" alt="Image" title="Image" />
		                            <?php
		                        }
		                        elseif(substr($file['MediaGalleryFile']['filetype'], 0, 5) == 'video')
		                        {
		                            ?>
		                            <button class="btn btn-info disabled">
		                            	<i class="fa fa-video-camera"></i>
		                            </button>
		                            <?php
		                        }
		                        elseif(substr($file['MediaGalleryFile']['filename'], -3) == 'xls' ||
		                                substr($file['MediaGalleryFile']['filename'], -3) == 'xlsx' ||
		                                substr($file['MediaGalleryFile']['filename'], -3) == 'csv')
		                        {
		                            ?>
		                            <button class="btn btn-info disabled">
		                            	<i class="fa fa-file-excel-o"></i>
		                            </button>
		                            <?php
		                        }
		                        elseif(substr($file['MediaGalleryFile']['filename'], -3) == 'doc' ||
		                                substr($file['MediaGalleryFile']['filename'], -3) == 'docx' ||
		                                substr($file['MediaGalleryFile']['filename'], -3) == 'rtf')
		                        {
		                            ?>
		                            <button class="btn btn-info disabled">
		                            	<i class="fa fa-file-word-o"></i>
		                            </button>
		                            <?php
		                        }
		                        elseif(substr($file['MediaGalleryFile']['filename'], -3) == 'pps' ||
		                                substr($file['MediaGalleryFile']['filename'], -3) == 'ppt')
		                        {
		                            ?>
		                            <button class="btn btn-info disabled">
		                            	<i class="fa fa-file-powerpoint-o"></i>
		                            </button>
		                            <?php
		                        }
		                        else
		                        {
		                            ?>
		                            <button class="btn btn-info disabled">
		                            	<i class="fa fa-file-o"></i>
		                            </button>
		                            <?php
		                        }
		                        ?>
		                    </td>
		                    <td><?php echo Sanitize::html($file['MediaGalleryFile']['title']); ?></td>
		                    <td class="text-center">
		                        <a class="btn btn-success btn-circle" href="<?php echo $this->Html->url('/bakery/media_gallery/edit/' . $file['MediaGalleryFile']['id']); ?>" title="<?php echo __d('cms', 'Edit'); ?>">
		                            <i class="fa fa-pencil"></i>
		                        </a>
		                        
		                        <a class="btn btn-danger btn-circle" href="<?php echo $this->Html->url('/bakery/media_gallery/delete/' . $file['MediaGalleryFile']['id']); ?>" title="<?php echo __d('cms', 'Delete'); ?>" onclick="return confirm('<?php echo __d('cms', "Are you sure you want to delete ") . $file['MediaGalleryFile']['title']; ?>');">
		                            <i class="fa fa-times"></i>
		                        </a>
		                    </td>
		                </tr>
		                <?php
		            }
		            ?>
		        </tbody>
		    </table>
		</div>
	
	    <?php echo $this->element('paginator_pages'); ?>
	</div>
	
	<div class="col-md-4">
	    <div class="panel panel-default">
	        <div class="panel-heading">
                <?php echo __d('cms', 'Add');?>
                
                <a href="#" class="pull-right" data-toggle="modal" data-target="#MediaGalleryAddHelp">
                    <i class="fa fa-question-circle"></i>
                </a>
	        </div>
	        
	        <div class="panel-body">
	            <p>
	                <a href="#" class="btn btn-success btn-lg btn-block" id="uploadFile"><?php echo __d('cms', 'Upload file');?></a>
	            </p>
	        </div>
	    </div>
	
	    <div class="panel panel-default">
	        <div class="panel-heading">
                <?php echo __d('cms', 'File type');?>
                <a href="" class="pull-right" data-toggle="modal" data-target="#MediaGalleryFilterHelp">
                    <i class="fa fa-question-circle"></i>
                </a>
	        </div>
	        
	        <div class="panel-body">
	            <p>
	                <a href="<?php echo $this->Html->url('/bakery/media_gallery/'); ?>" class="btn btn-info btn-block"><?php echo __d('cms', 'All');?></a>
	                <br />
	                <a href="<?php echo $this->Html->url('/bakery/media_gallery/index/image'); ?>" class="btn btn-info btn-block"><?php echo __d('cms', 'Images');?></a>
	                <br />
	                <a href="<?php echo $this->Html->url('/bakery/media_gallery/index/video'); ?>" class="btn btn-info btn-block"><?php echo __d('cms', 'Videos');?></a>
	                <br />
	                <a href="<?php echo $this->Html->url('/bakery/media_gallery/index/audio'); ?>" class="btn btn-info btn-block"><?php echo __d('cms', 'Audio');?></a>
	                <br />
	                <a href="<?php echo $this->Html->url('/bakery/media_gallery/index/application'); ?>" class="btn btn-info btn-block"><?php echo __d('cms', 'Others');?></a>
	                <br />
	            </p>
	        </div>
	    </div>
	
	    <div class="panel panel-default">
	        <div class="panel-heading">
                <?php echo __d('cms', 'Search'); ?>
                
                <a href="#" class="pull-right" data-toggle="modal" data-target="#MediaGallerySearchHelp">
                    <i class="fa fa-question-circle"></i>
                </a>
	        </div>
	        
	        <div class="panel-body">
                <form id="frmSearchFiles" action="<?php echo $this->Html->url('/bakery/media_gallery/search'); ?>" method="post">
                    <div class="form-group">
                        <label><?php echo __d('cms', 'Keyword'); ?></label>
                        <br />
                        <input type="text" name="q" class="form-control" />
                        <br />
                        <a href="#" class="btn btn-primary" onclick="jQuery('#frmSearchFiles').submit(); return false;">
                        	<?php echo __d('cms', 'Search'); ?>
                        </a>
                    </div>
                </form>
	        </div>
	    </div>
	</div>
</div>

<script type="text/javascript">
    var myUpload = new qq.FileUploader({
        element: jQuery('#uploadFile')[0],
        action: '<?php echo $this->Html->url('/bakery/media_gallery_ajax/upload'); ?>',
        onSubmit: function(id, fileName) {
            jQuery('#imgLoading').show();
            jQuery('#uploadResult').html('Sending file...');
        },
        onComplete: function(id, fileName) {
            jQuery('#imgLoading').hide();
            jQuery('#uploadResult').html('');
            window.location.reload();
        }
    });
</script>
