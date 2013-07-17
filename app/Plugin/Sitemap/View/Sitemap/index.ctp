<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php 
foreach($map as $url)
{
	?>
	<url>
		<loc><?php echo $url['loc']; ?></loc>
		<changefreq><?php echo $url['changefreq']; ?></changefreq>
		<priority><?php echo $url['priority']; ?></priority>
	</url>
	<?php
}
?>
</urlset>