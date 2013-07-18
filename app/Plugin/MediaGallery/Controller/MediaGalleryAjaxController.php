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
class MediaGalleryAjaxController extends MediaGalleryAppController
{
    public $name = 'MediaGalleryAjax';
    public $uses = array('MediaGallery.MediaGalleryFile');
    public $components = array('BakeryLogin');


    public function beforeFilter()
    {
        // Checks login
        $this->BakeryLogin->checkAdminLogin();

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
