<?php
App::import('Lib', 'PluginObject');

class SitemapPlugin extends PluginObject
{
	/**
	 * @var (boolean) This plugin has a CMS module. This means that implements the [pluginName]_cms_controller.php convention.
	 */
	protected $_hasCmsModule = false;
	
	/**
	 * @var (string) Show in CMS menu.
	 */
	protected $_showInCmsMenu = false;
	
	
	public function getCmsModuleName()
	{
		return __d('cms', 'Sitemap');
	}
}
