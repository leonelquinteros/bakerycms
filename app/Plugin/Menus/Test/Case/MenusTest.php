<?php
require_once dirname(__FILE__) . '/../TestHelper.php'; 

class MenusTest extends PHPUnit_Framework_TestCase
{
	public $i = 0;
	
	public function setUp()
	{
		App::import('Model', 'Menus.MenusMenu');
		$menu = new MenusMenu();
		$menu->deleteAll('1 = 1');
		
		App::import('Lib', 'maintenance');
		Maintenance::clearCache();
	}
	
	public function tearDown()
	{
		App::import('Lib', 'maintenance');
		Maintenance::clearCache();
	}
	
	public function testMenu()
	{
		$menuNames = explode(',', SITE_MENUS);
		
		App::import('Model', 'Menus.MenusMenu');
		$menu = new MenusMenu();
		
		$menuData = $menu->getPageMenu('dut');
		$this->assertTrue(is_array($menuData));
		
		// Empty menus by now...
		foreach($menuNames as $menuName)
		{
			$this->assertTrue(is_array($menuData[$menuName]));
			$this->assertTrue(empty($menuData[$menuName]));
		}
		
		foreach($menuNames as $menuName)
		{
			$this->i++;
			$menuData = $menu->create();
			$menuData['MenusMenu']['id'] = $this->i;
			$menuData['MenusMenu']['name'] = $menuName;
			$menuData['MenusMenu']['lang'] = 'dut';
			$menuData['MenusMenu']['position'] = 0;
			$menuData['MenusMenu']['title'] = 'Test title ' . $menuName;
			$menuData['MenusMenu']['link'] = '/test-link-' . $menuName;
			$menuData['MenusMenu']['parent_id'] = 0;
			$menu->save($menuData);
		}
		
		$menuData = $menu->getPageMenu('dut');
		$this->assertTrue(is_array($menuData));
		
		foreach($menuNames as $menuName)
		{
			$this->i++;
			$menuData = $menu->create();
			$menuData['MenusMenu']['id'] = $this->i;
			$menuData['MenusMenu']['name'] = $menuName;
			$menuData['MenusMenu']['lang'] = 'dut';
			$menuData['MenusMenu']['position'] = 0;
			$menuData['MenusMenu']['title'] = 'Test title 1 ' . $menuName;
			$menuData['MenusMenu']['link'] = '/test-link-1-' . $menuName;
			$menuData['MenusMenu']['parent_id'] = 0;
			$menu->save($menuData);
		}
		
		$menuData = $menu->getPageMenu('dut');
		$this->assertTrue(is_array($menuData));
	}
	
}
