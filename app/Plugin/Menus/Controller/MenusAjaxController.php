<?php
class MenusAjaxController extends MenusAppController
{
	public $name = 'MenusAjax';
	public $uses = array('Menus.MenusMenu');
	public $components = array('CmsLogin');
	
	
	public function beforeFilter()
	{
		// Checks login
		$this->CmsLogin->checkAdminLogin();
		
		$this->layout = false;
		$this->autoRender = false;
	}
	
	public function addMenuItem()
	{
		$data = $this->MenusMenu->create();
		
		$data['MenusMenu']['position'] = 9999;
		$data['MenusMenu']['name'] = $_POST['name'];
		$data['MenusMenu']['lang'] = $_POST['lang'];
		$data['MenusMenu']['title'] = $_POST['title'];
		$data['MenusMenu']['link'] = $_POST['link'];
		$data['MenusMenu']['parent_id'] = $_POST['parent_id'];
		
		$this->MenusMenu->save($data);
	}
	
	public function order() {
		foreach($_POST['items'] as $order => $id)
		{
			$menuData = $this->MenusMenu->findById($id);
			$menuData['MenusMenu']['position'] = $order;
			
			// Using find and save instead of a UPDATE query to run the callback method MenusMenu::afterSave()
			$this->MenusMenu->save($menuData);
		}
	}
}
