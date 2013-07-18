<select id="linkpage">
	<option value=""></option>
	<?php
	foreach($pages as $page)
	{
		?>
		<option value="/<?php echo $page['PagesPage']['url']; ?>"><?php echo $page['PagesPage']['title']; ?></option>
		<?php
	}
	?>
</select>