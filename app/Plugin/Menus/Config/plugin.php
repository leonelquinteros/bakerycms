<?php
App::import('Lib', 'PluginObject');

class MenusPlugin extends PluginObject
{
    /**
     * @var (boolean) This plugin has a CMS module. This means that implements the [pluginName]_cms_controller.php convention.
     */
    protected $_hasCmsModule = true;

    /**
     * @var (string) Show in CMS menu.
     */
    protected $_showInCmsMenu = true;

    /**
     * @var (boolean) Is a submenu.
     */
    protected $_isCmsSubMenu = false;

    /**
     * @var (string) Plugin name of the father menu.
     */
    protected $_cmsMenuFather = 'pages';


    public function getCmsModuleName()
    {
        return __d('cms', 'Menu structure');
    }
}
