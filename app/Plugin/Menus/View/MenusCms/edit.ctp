
<?php // echo $this->element('help/' . $this->Language->getLanguage() . '/edit'); ?>

<div class="row">
	<div class="col-md-8">
		<form id="frmMenus" action="<?php echo $this->Html->url('/bakery/menus/edit/' . $lang .'/' . $menuName); ?>" method="post" enctype="multipart/form-data">
            <?php
            $this->Form->inputDefaults(
            		array(
            				'div'	=> array(
            						'class' => 'form-group',
            				),
            				'class' => 'form-control',
            		)
            );

            if( !empty($this->data['MenusMenu']['id']) )
            {
                echo $this->Form->input('MenusMenu.id', array('type' => 'hidden'));
            }

            echo $this->Form->input('MenusMenu.parent_id', array('type' => 'hidden', 'default' => $parentId));

            echo $this->Form->input('MenusMenu.position', array('type' => 'hidden'));

            echo $this->Form->input('MenusMenu.title',
                                array(
                                    'label' => __d('cms', 'Menu title')
                                )
            );

            echo $this->Form->input('MenusMenu.link',
                                array(
                                    'label' => __d('cms', 'Menu link'),
                                    'default' => 'http://'
                                )
            );
            ?>
        </form>

        <?php
        if(!empty($subMenus))
        {
            ?>
            <h2>Sub Menu</h2>

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
                        foreach($subMenus as $item)
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
        	<?php
        }
        ?>
	</div>

	<div class="col-md-4">
	    <div class="panel panel-default">
	        <div class="panel-heading">
				<?php echo __d('cms', 'Actions');?>
	        </div>

	        <div class="panel-body">
				<p>
					<a href="#" class="btn btn-primary btn-block" onclick="this.onclick = function(){ return false; }; jQuery('#frmMenus').submit(); return false;"><?php echo __d('cms', 'Save');?></a>
                    <br />
                    <?php
                    if(empty($this->data['MenusMenu']['parent_id']))
                    {
                        ?>
                        <a href="<?php echo $this->Html->url('/bakery/menus/view/' . $lang . '/' . $menuName); ?>" class="btn btn-warning btn-block">
                            <?php echo __d('cms', 'Back to menu overview');?>
                        </a>
                        <?php
                    }
                    else
                    {
                        ?>
                        <a href="<?php echo $this->Html->url('/bakery/menus/edit/' . $lang . '/' . $menuName); ?>/<?php echo $this->data['MenusMenu']['parent_id']; ?>" class="btn btn-info btn-block">
                            <?php echo __d('cms', 'Back to parent menu');?>
                        </a>
                        <?php
                    }
                    ?>
				</p>
	        </div>
	    </div>

	    <?php
        if(!empty($this->data['MenusMenu']['id']))
        {
            ?>
            <div class="panel panel-default">
	        	<div class="panel-heading">
                    <?php echo __d('cms', 'Sub-menu');?>

                    <a href="#" class="pull-right" data-toggle="modal" data-target="#MenusEditSubMenuHelp" title="<?php echo __d('cms', 'Help'); ?>">
                        <i class="fa fa-question-circle"></i>
                    </a>
                </div>

                <div class="panel-body">
                    <p>
                        <a href="<?php echo $this->Html->url('/bakery/menus/edit/' . $lang . '/' . $menuName . '/0/' . $this->data['MenusMenu']['id']); ?>" class="btn btn-info btn-block">
                        	<?php echo __d('cms', 'Add item by URL');?>
                        </a>
                        <a href="#" onclick="openPagesDialog(); return false;" class="btn btn-info btn-block">
                        	<?php echo __d('cms', 'Select page to link');?>
                        </a>
                    </p>
                </div>
            </div>
            <?php
        }
        ?>
	</div>
</div>

<div id="cmsAddMenuPageDialog" style="display:none;text-align:left;">
    <h4><?php echo __d('cms', 'Pages in') . ' ' . $langName; ?></h4>
    <br />
    <?php
    foreach($pages as $page)
    {
        ?>
        <a href="#" style="font-size:1.2em;color:#285D8B;" onclick="addMenuItem('<?php echo $page['PagesPage']['title']; ?>', '/<?php echo $page['PagesPage']['url']; ?>', '<?php echo intval($this->data['MenusMenu']['id']); ?>'); return false;" title="<?php echo __d('cms', 'Add this page'); ?>">
            <?php echo $page['PagesPage']['title']; ?>
        </a>
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