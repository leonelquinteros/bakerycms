<?php
class PagesSchema extends CakeSchema
{
	public $name = 'Pages';
	
	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}
 
	public $pages_page_contents = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'pages_pages_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'content_key' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'content' => array('type' => 'longtext', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'PageId' => array('column' => 'pages_pages_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	
	public $pages_pages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'url' => array('type' => 'string', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'lang' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 3),
		'layout' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'seo_title' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'seo_keywords' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'seo_description' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'publish' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'publish_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'URL' => array('column' => 'url', 'unique' => 0), 'PUBLISHED_URL' => array('column' => array('url', 'publish', 'publish_date'), 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
}
