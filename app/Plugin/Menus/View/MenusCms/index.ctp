<div class="row">
	<div class="col-md-8">
		<div class="table-responsive">
		    <table class="table table-striped table-bordered table-hover">
				<thead>
                    <tr>
                        <th><?php echo __d('cms', 'Language'); ?></th>
                        <th><?php echo __d('cms', 'Menu'); ?></th>
                        <th><?php echo __d('cms', 'Actions'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($langs as $lang)
                    {
                        foreach($menus as $menu)
                        {
                            ?>
                            <tr>
                                <td><?php echo $this->Language->name($lang); ?></td>
                                <td><?php echo $menu; ?></td>
                                <td>
                                    <a class="btn btn-primary btn-circle" href="<?php echo $this->Html->url('/bakery/menus/view/' . $lang . '/' . $menu); ?>" title="<?php echo __d('cms', 'Edit'); ?>">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
		</div>
	</div>

	<div class="col-md-4">
	    <div class="panel panel-default">
	        <div class="panel-heading">
                <?php echo __d('cms', 'Menu structure'); ?>
	        </div>

	        <div class="panel-body">
	            <p>
	                <?php echo __d('cms', 'All the current menus are listed here.'); ?>
                    <br /><br />
                    <?php echo __d('cms', 'To edit a menu, click on the corresponding Edit icon'); ?> <i class="fa fa-pencil"></i>
                    <br /><br />
	            </p>
	        </div>
	    </div>
	</div>
</div>
