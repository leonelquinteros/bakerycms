<?php
class MediaGalleryAjaxController extends MediaGalleryAppController
{
	public $name = 'MediaGalleryAjax';
	public $uses = array('MediaGallery.MediaGalleryFile');
	public $components = array('CmsLogin');
	
	
	public function beforeFilter()
	{
		// Checks login
		$this->CmsLogin->checkAdminLogin();
		
		$this->layout = false;
		$this->autoRender = false;
	}
	
	public function upload()
	{
		set_time_limit(3600);  // 1h
		
		$uploadDir = WWW_ROOT . 'media/';
		
		$fileName = basename($_GET['qqfile']);
		// Slug saving dots (.)
		$nameArray = explode('.', $fileName);
		for($i = 0; $i < count($nameArray); $i++)
		{
			$nameArray[$i] = Inflector::slug($nameArray[$i]);
		}
		$fileName = implode('.', $nameArray);
		
		$prefix = '';
		$auxName = $fileName;
		while(is_file($uploadDir . $auxName))
		{
			$auxName = (intval($prefix) + 1) . '_' . $fileName;
			$prefix++;
		}
		$fileName = $auxName;
		
		$uploadFile = $uploadDir . $fileName;
		
		$input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
        
        $target = fopen($uploadFile, "w");
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);

		$data = $this->MediaGalleryFile->create();
		$data['MediaGalleryFile']['title'] = Inflector::humanize($fileName);
		$data['MediaGalleryFile']['description'] = '';
		$data['MediaGalleryFile']['filename'] = $fileName;
		$data['MediaGalleryFile']['filetype'] = $this->MediaGalleryFile->getExtensionMimeType($uploadFile);
		$this->MediaGalleryFile->save($data);
		
		echo json_encode(array('success' => true));
	}
	
	public function media_gallery()
	{
		$this->render('media_gallery');
	}
	
	public function files()
	{
		$files = $this->MediaGalleryFile->find('all', array('order' => 'filename'));
		$this->set('files', $files);
		
		$this->render('files');
	}
	
	public function images()
	{
		$files = $this->MediaGalleryFile->find('all', array('conditions' => array('MediaGalleryFile.filetype LIKE ' => 'image%'), 'order' => 'filename'));
		
		$this->set('files', $files);
		
		$this->render('files');
	}
}
