
<?php echo $this->element('help/' . $this->Language->getLanguage() . '/index'); ?>

<div id="bakery-actions">
	<div class="bakery-action-box">
		<div class="bakery-action-box-top">
			<h3>
				<?php echo __d('cms', 'File type');?>
				<a href="" class="help" rel="#MediaGalleryFilterHelp" title="<?php echo __d('cms', 'Help'); ?>">
					<img src="<?php echo $this->Html->url('/img/cms/icons/help_icon.png'); ?>" alt="<?php echo __d('cms', 'Help'); ?>" />
				</a>
			</h3>
		</div>
		<div class="bakery-action-box-content">
			<p class="bakery-action-boxButtons">
				<a href="<?php echo $this->Html->url('/cms/media_gallery/'); ?>" class="button-large"><?php echo __d('cms', 'All');?></a>
				<br />
				<a href="<?php echo $this->Html->url('/cms/media_gallery/index/image'); ?>" class="button-large"><?php echo __d('cms', 'Images');?></a>
				<br />
				<a href="<?php echo $this->Html->url('/cms/media_gallery/index/video'); ?>" class="button-large"><?php echo __d('cms', 'Videos');?></a>
				<br />
				<a href="<?php echo $this->Html->url('/cms/media_gallery/index/audio'); ?>" class="button-large"><?php echo __d('cms', 'Audio');?></a>
				<br />
				<a href="<?php echo $this->Html->url('/cms/media_gallery/index/application'); ?>" class="button-large"><?php echo __d('cms', 'Others');?></a>
				<br />
			</p>
		</div>
		<div class="bakery-action-box-bottom"></div>
	</div>
	
	<div class="bakery-action-box">
		<div class="bakery-action-box-top">
			<h3>
				<?php echo __d('cms', 'Search'); ?>
				<a href="#" class="help" rel="#MediaGallerySearchHelp" title="<?php echo __d('cms', 'Help'); ?>">
					<img src="<?php echo $this->Html->url('/img/cms/icons/help_icon.png'); ?>" alt="<?php echo __d('cms', 'Help'); ?>" />
				</a>
			</h3>
		</div>
		<div class="bakery-action-box-content">
			<div class="bakery-action-form">
				<div class="bakery-action-form-top"></div>
				
				<form id="frmSearchFiles" action="<?php echo $this->Html->url('/cms/media_gallery/search'); ?>" method="post">
					<p class="bakery-action-form-content">
						<span><?php echo __d('cms', 'Keyword'); ?></span>
						<br />
						<input type="text" name="q" class="textBox" value="<?php echo $keyword; ?>" />
						<br />
						<a href="#" class="action-button-small" onclick="jQuery('#frmSearchFiles').submit(); return false;"><?php echo __d('cms', 'Search'); ?></a>
					</p>
				</form>
				
				<div class="bakery-action-form-bottom"></div>
			</div>
		</div>
		<div class="bakery-action-box-bottom"></div>
	</div>
</div>


<div id="bakery-main">
	<table class="bakery-list">
		<thead>
			<tr>
				<th><?php echo __d('cms', 'File'); ?></th>
				<th><?php echo __d('cms', 'Title'); ?></th>
				<th><?php echo __d('cms', 'Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($files as $file)
			{
				?>
				<tr>
					<td style="text-align:center;width:64px;">
						<?php
						if(substr($file['MediaGalleryFile']['filetype'], 0, 5) == 'image')
						{
							?>
							<img src="<?php echo $this->Html->url('/media_gallery/thumb/0/32/' . $file['MediaGalleryFile']['filename']); ?>" alt="Image" title="Image" />
							<?php 
						}
						elseif(substr($file['MediaGalleryFile']['filetype'], 0, 5) == 'video')
						{
							?>
							<img src="<?php echo $this->Html->url('/media_gallery/thumb/0/32/video-icon.png'); ?>" alt="Video file" title="Video file" />
							<?php
						}
						else
						{
							?>
							<img src="<?php echo $this->Html->url('/media_gallery/thumb/0/32/document-icon.png'); ?>" alt="Document" title="Document" />
							<?php
						}
						?>
					</td>
					<td><?php echo $file['MediaGalleryFile']['title']; ?></td>
					<td>
						<a href="<?php echo $this->Html->url('/cms/media_gallery/edit/' . $file['MediaGalleryFile']['id']); ?>" title="<?php echo __d('cms', 'Edit'); ?>">	
							<img src="<?php echo $this->Html->url('/img/cms/icons/application_edit.png'); ?>" alt="<?php echo __d('cms', 'Edit'); ?>" />
						</a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="<?php echo $this->Html->url('/cms/media_gallery/delete/' . $file['MediaGalleryFile']['id']); ?>" title="<?php echo __d('cms', 'Delete'); ?>" onclick="return confirm('<?php echo __d('cms', "Are you sure you want to delete ") . $file['MediaGalleryFile']['title']; ?>');">
							<img src="<?php echo $this->Html->url('/img/cms/icons/delete.png'); ?>" alt="<?php echo __d('cms', 'Delete'); ?>" />
						</a>
					</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	
</div>
