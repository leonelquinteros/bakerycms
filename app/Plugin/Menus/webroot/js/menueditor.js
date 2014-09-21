function addMenuItem(menuTitle, menuLink, parentId) {
	jQuery.ajax(
			{
				url: '/bakery/menusajax/addMenuItem',
				data: {
						name: '<?php echo $menuName; ?>',
						lang: '<?php echo $lang; ?>',
						title: menuTitle,
						link: menuLink,
						parent_id: parentId
				},
				type: 'POST',
				complete: function(XMLHttpRequest, textStatus) {
						location.reload();
				}
			}
	);
}

function openPagesDialog() {
	jQuery('#cmsAddMenuPageDialog').dialog(
			{
				width: 500,
				height: 300,
                modal: true,
				title: '<?php __d('cms', 'Add page link'); ?>',
				close: function() {
					jQuery('#cmsAddMenuPageDialog').dialog("destroy");
				}
			}
	);
}

jQuery( function() {
	jQuery('#sortable-menu').sortable(
			{
				accept: 'sortable-menu-item',
				opacity: 0.8,
				axis: 'y',
				delay: 200,
				update : function(event, ui) {
								var order = new Array();
			    				jQuery('#sortable-menu li').each( function (i, el) {
										order[i] = jQuery(el).attr('id').replace('menu-', '');
			    				});

								jQuery.ajax(
										{
											url: '/bakery/menusajax/order',
											data: {items: order},
											type: 'POST'
										}
								);
				}
			}
	);
} );
