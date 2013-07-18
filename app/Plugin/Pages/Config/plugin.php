<?php
App::import('Lib', 'PluginObject');

class PagesPlugin extends PluginObject
{
	/**
	 * @var (boolean) This plugin has a CMS module. This means that implements the [pluginName]_cms_controller.php convention.
	 */
	protected $_hasCmsModule = true;
	
	/**
	 * @var (string) Show in CMS menu.
	 */
	protected $_showInCmsMenu = true;
	
	
	public function getCmsModuleName()
	{
		return __d('cms', 'Pages');
	}
}
