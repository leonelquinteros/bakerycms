<?php
/**
 * Bakery CMS
 *
 * @author: Leonel Quinteros <leonel.quinteros@gmail.com>, http://leonelquinteros.github.io
 * @copyright: Copyright (c) 2013, Leonel Quinteros. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and
 * the following disclaimer in the documentation and/or other materials provided with the distribution.
 * Neither the name "Bakery CMS" nor the names of its contributors may be used to endorse or promote
 * products derived from this software without specific prior written permission.
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
 * STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */
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
                flush();
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
