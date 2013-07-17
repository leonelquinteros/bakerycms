<?php
class MediaGallerySchema extends CakeSchema
{
	public $name = 'MediaGallery';
	
	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}
	
	public $media_gallery_files = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'filename' => array('type' => 'string', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'filetype' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'title' => array('column' => 'title', 'unique' => 0), 'filename' => array('column' => 'filename', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
}
