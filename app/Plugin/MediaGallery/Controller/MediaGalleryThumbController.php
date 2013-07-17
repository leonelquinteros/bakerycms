<?php
class MediaGalleryThumbController extends MediaGalleryAppController
{
    public $name = 'MediaGalleryThumb';
    public $uses = array();

    public function beforeFilter()
    {
        $this->layout = false;
        $this->autoRender = false;

        ini_set('memory_limit', '512M');
    }


    private function cached($action, $params)
    {
        $eTag = $this->cacheKey($action, $params);
        $cachePath = ROOT . '/app/tmp/cache/media_gallery/' . $eTag;

        // Checks for file exists
        if(is_file($cachePath))
        {
            // Check browser cache.
            $lastModified = filemtime($cachePath);
            $ifModifiedSince = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ?
                strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) :
                false;

            $ifNoneMatch = isset($_SERVER['HTTP_IF_NONE_MATCH']) ?
                $_SERVER['HTTP_IF_NONE_MATCH'] :
                false;

            if( ($ifModifiedSince && $ifModifiedSince == $lastModified) || ($ifNoneMatch && $ifNoneMatch == $eTag) )
            {
                header('Status: 304 Not Modified');
                header('HTTP/1.0 304 Not Modified');
                header('HTTP/1.1 304 Not Modified');

                flush();
                exit;
            }
            else // Not cached by the browser
            {
                // Content-Type header
                if(substr($params['fileName'], -3) == 'png')
                {
                    header('Content-Type: image/png');
                }
                elseif(substr($params['fileName'], -3) == 'gif')
                {
                    header('Content-Type: image/gif');
                }
                else
                {
                    header('Content-Type: image/jpeg');
                }

                // HTTP cache headers
                header('Cache-Control: max-age=15768000, public'); // 1 year
                header('Pragma: cache');
                header('Expires: ' . date('r', strtotime('+6 months')));
                header('Last-Modified: ' . date('r', $lastModified));
                header('ETag: ' . $eTag);

                readfile($cachePath);
            }

            return true;
        }

        return false;
    }

    public function perform()
    {
        $action = $this->params['perform'];

        switch($action)
        {
            case 'thumbnail':
            case 'thumb':
            case 'resizecrop':
                if(count($this->params['pass']) == 3)
                {
                  $params = array(
                    'width' => $this->params['pass'][0],
                    'height' => $this->params['pass'][1],
                    'fileName' => $this->params['pass'][2],
                  );
                }
                break;
            case 'crop':
                switch(count($this->params['pass']))
                {
                    case 3:
                        $params = array(
                          'width' => $this->params['pass'][0],
                          'height' => $this->params['pass'][1],
                          'fileName' => $this->params['pass'][2]
                        );
                        break;
                    case 5:
                        $params = array(
                          'width' => $this->params['pass'][0],
                          'height' => $this->params['pass'][1],
                          'x' => @$this->params['pass'][2],
                          'y' => @$this->params['pass'][3],
                          'fileName' => @$this->params['pass'][4]
                        );
                        break;
                }
                break;
        }

        if(empty($params))
        {
            $this->sendBadRequestError();
        }

        // File
        $filePath = ROOT . '/app/webroot/media/' . $params['fileName'];

        if(!is_file($filePath))
        {
            header('HTTP/1.1 404 Not Found');
            echo "Not Found";
            exit;
        }

        $params['fileTime'] = filemtime($filePath);

        // Size params fix
        if(!empty($params['width']) && empty($params['height']))
        {
            $params['height'] = $params['width'];
        }
        if(!empty($params['height']) && empty($params['width']))
        {
            $params['width'] = $params['height'];
        }

        // First try to recover from cache
        if(!$this->cached($action, $params))
        {
            App::import('Vendor', 'PHPThumb', array('file' => 'phpThumb/ThumbLib.inc.php'));

            $options = array('jpegQuality' => 98);
            $thumb = PhpThumbFactory::create($filePath, $options);

            // Type
            switch(substr($params['fileName'], -3))
            {
                case 'png': $type = 'png'; break;
                case 'gif': $type = 'gif'; break;
                default: $type = 'jpg';
            }

            // Generate
            switch($action)
            {
                case 'crop':
                    if(is_null($params['x']) || is_null($params['y']))
                    {
                        $thumb->cropFromCenter($params['width'], $params['height']);
                    }
                    else
                    {
                        $thumb->crop($params['x'], $params['y'], $params['width'], $params['height']);
                    }
                    break;

                case 'resizecrop':
                    $thumb->adaptiveResize($params['width'], $params['height']);
                    break;

                case 'thumb':
                case 'thumbnail':
                    $thumb->resize($params['width'], $params['height']);
                    break;

                default:
                    $this->sendBadRequestError();
                    break;
            }

            // Cache
            $thumb->save(ROOT . '/app/tmp/cache/media_gallery/' . $this->cacheKey($action, $params), $type);

            // Read from cached file
            if(!$this->cached($action, $params))
            {
                header('HTTP/1.1 500 Internal Server Error');
                echo "Image file missing";
                exit;
            }
        }
    }

    private function cacheKey($action, $params)
    {
        $key = $action;
        ksort($params);
        foreach($params as $k => $v)
        {
            if(!is_null($v))
            {
                $key .= ';' . $k . ':' . $v;
            }
        }

        return md5($key);
    }

    private function sendBadRequestError()
    {
        header('400 Bad Request');
        header('Content-Type: text/plain');
        echo 'Request parameters are invalid';
        exit;
    }
}
