<?php
class MediaGalleryFile extends MediaGalleryAppModel
{
	public $name = 'MediaGalleryFile';
	public $recursive = -1;
	
	public function getExtensionMimeType($fileName)
	{
		$ext = strtolower(array_pop(explode('.', $fileName)));
		
		switch($ext)
		{
			case 'jpg'	:
			case 'jpeg'	:
			case 'jpe'	:
				$mime = 'image/jpeg';
				break;
			
			case 'png'	:
				$mime = 'image/png';
				break;
				
			case 'gif'	:
				$mime = 'image/gif';
				break;
			
			case 'bmp'	:
				$mime = 'image/bmp';
				break;

			case 'svg'	:
				$mime = 'image/svg+xml';
				break;
			
			case 'flv'	:
				$mime = 'video/x-flv';
				break;
			
			case 'mpg'	:
			case 'mpeg'	:
			case 'mp2'	:
			case 'mpa'	:
			case 'mpe'	:
			case 'mpv2'	:
				$mime = 'video/mpeg';
				break;
				
			case 'avi'	:
				$mime = 'video/msvideo';
				break;
				
			case 'mov'	:
			case 'qt'	:
				$mime = 'video/quicktime';
				break;
				
			case 'mp3'	:
				$mime = 'audio/mpeg';
				break;
				
			case 'mp3'	:
				$mime = 'audio/mpeg';
				break;
				
			case 'wav'	:
				$mime = 'audio/x-wav';
				break;
				
			case 'zip'	:
				$mime = 'application/zip';
				break;
				
			case 'pdf'	:
				$mime = 'application/pdf';
				break;
				
			case 'doc'	:
			case 'dot'	:
				$mime = 'application/msword';
				break;
				
			default:
				$mime = 'application/octet-stream';
		}
		
		return $mime;
	}
}
