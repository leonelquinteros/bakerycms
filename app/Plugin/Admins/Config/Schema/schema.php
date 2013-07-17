<?php
class AdminsSchema extends CakeSchema
{
	public $name = 'Admins';
	
	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}
	
	public $admins_admins = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'login' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'key' => 'unique'),
		'pass' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'email' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'comments' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'super_admin' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'Login' => array('column' => 'login', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	
	public $admins_admins_restrictions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'admins_admins_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'plugin' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'action' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'Restriction' => array('column' => array('admins_admins_id', 'plugin', 'action'), 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
}
