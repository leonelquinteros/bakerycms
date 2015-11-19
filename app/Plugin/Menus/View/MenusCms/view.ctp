
<?php //echo $this->element('help/' . $this->Language->getLanguage() . '/view'); ?>

<div class="row">
	<div class="col-md-8">
		<div class="table-responsive">
    		<table class="table table-striped table-bordered table-hover">
    			<thead>
    				<tr>
    					<th>Menu item</th>
    					<th>Actions</th>
    				</tr>
    			</thead>

    			<tbody>
    				<?php
                    foreach($this->data as $item)
                    {
                        ?>
                        <tr>
        					<td>
        						<?php echo $item['MenusMenu']['title']; ?>

        						<?php
                                foreach($item['SubMenu'] as $subMenu)
                                {
                                    ?>
                                    <br />
                                    <small style="margin-left:30px;margin-top:5px;">&raquo; <?php echo $subMenu['title']; ?></small>
                                    <?php
                                }
                                ?>
        					</td>
        					<td>
                                <a class="btn btn-primary btn-circle" href="<?php echo $this->Html->url('/bakery/menus/edit/' . $lang . '/' . $menuName . '/' . $item['MenusMenu']['id']); ?>" title="<?php echo __d('cms', 'Edit'); ?>">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-danger btn-circle" href="<?php echo $this->Html->url('/bakery/menus/delete/' . $lang . '/' . $menuName . '/' . $item['MenusMenu']['id']); ?>" onclick="return confirm('Do you want to delete this menu item?');" title="<?php echo __d('cms', 'Delete'); ?>">
                                    <i class="fa fa-times"></i>
                                </a>
                                <a class="btn btn-info btn-circle" href="#" title="<?php echo __d('cms', 'Move up'); ?>">
                                    <i class="fa fa-arrow-up"></i>
                                </a>
                                <a class="btn btn-info btn-circle" href="#" title="<?php echo __d('cms', 'Move down'); ?>">
                                    <i class="fa fa-arrow-down"></i>
                                </a>
        					</td>
        				</tr>
                        <?php
                    }
                    ?>
    			</tbody>
			</table>
        </div>
    </div>

    <div class="col-md-4">
	    <div class="panel panel-default">
	        <div class="panel-heading">
				<?php echo __d('cms', 'Actions'); ?>

				<a href="#" class="pull-right" data-toggle="modal" data-target="#MenusActionsHelp">
    	            <i class="fa fa-question-circle"></i>
    	        </a>
	        </div>

	        <div class="panel-body">
	            <p>
					<a href="<?php echo $this->Html->url('/bakery/menus/edit/' . $lang . '/' . $menuName); ?>" class="btn btn-primary btn-block">
						<?php echo __d('cms', 'Add item by URL');?>
					</a>
                    <br />
                    <a href="#" onclick="openPagesDialog(); return false;" class="btn btn-primary btn-block">
                    	<?php echo __d('cms', 'Select page to link');?>
                    </a>
                    <br />
                    <a href="<?php echo $this->Html->url('/bakery/menus'); ?>" class="btn btn-warning btn-block">
                    	<?php echo __d('cms', 'Back to menu overview');?>
                    </a>
	            </p>
	        </div>
	    </div>
	</div>
</div>

<div id="cmsAddMenuPageDialog" style="display:none;text-align:left;">
    <h3><?php echo __d('cms', 'Pages in') . ' ' . $langName; ?></h3>
    <br />
    <?php
    foreach($pages as $page)
    {
        ?>
        <a href="#" style="font-size:1.2em;color:#285D8B;" onclick="addMenuItem('<?php echo $page['PagesPage']['title']; ?>', '/<?php echo $page['PagesPage']['url']; ?>','0'); return false;" title="<?php echo __d('cms', 'Add this page'); ?>"><?php echo $page['PagesPage']['title']; ?></a>
        <br />
        <?php
    }
    ?>
</div>

<?php
$this->start('script');
?>
<script type="text/javascript">
    <?php include_once(CakePlugin::path('Menus') . '/webroot/js/menueditor.js'); ?>
</script>

<?php
$this->end('script');
?>
