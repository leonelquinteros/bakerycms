<?php
class MenusSchema extends CakeSchema
{
    public $name = 'Menus';

    public function before($event = array()) {
        return true;
    }

    public function after($event = array()) {
    }

    public $menus_menus = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'key' => 'index'),
        'lang' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 3),
        'position' => array('type' => 'integer', 'null' => true, 'default' => NULL),
        'title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
        'link' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 250),
        'parent_id' => array('type' => 'integer', 'null' => true, 'default' => '9999'),
        'class' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'Menu' => array('column' => array('name', 'lang', 'position'), 'unique' => 0), 'MenuLink' => array('column' => array('name', 'lang', 'link'), 'unique' => 0)),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
    );
}
