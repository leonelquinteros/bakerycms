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
class MediaGalleryCmsController extends MediaGalleryAppController
{
    public $uses = array('MediaGallery.MediaGalleryFile');

    public $components = array('BakeryLogin', 'Breadcrumb', 'BakeryMenu');

    public $helpers = array('CmsBreadcrumb', 'Form');

    public $paginate = array(
                            'MediaGalleryFile' => array(
                                            'limit' => 20,
                                            'order' => array(
                                                'MediaGalleryFile.id' => 'DESC'
                                            )
                            )
    );

    public function beforeFilter()
    {
        // Disables browser cache
        $this->disableCache();

        // Sets layout
        $this->layout = "bakery/sbadmin";

        // Checks login
        $this->BakeryLogin->checkAdminLogin();

        $this->Breadcrumb->addCrumb(__d('cms', 'Home'), '/bakery');

        if( $this->action == 'index' )
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Media'));
        }
        else
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Media'), '/bakery/media_gallery');
        }


        $cmsMenu = $this->BakeryMenu->getMenu();
        $this->set('cmsMenu', $cmsMenu);

        $this->set('pageTitle', __d('cms', 'Media'));
    }


    public function beforeRender()
    {
        parent::beforeRender();

        $this->set( 'breadcrumb', $this->Breadcrumb->getBreadcrumb() );
    }


    public function index($type = '')
    {
        if(!empty($type))
        {
            $this->paginate['MediaGalleryFile']['conditions'] = array('MediaGalleryFile.filetype LIKE' => $type . '%');
        }
        $files = $this->paginate('MediaGalleryFile');

        $this->set('type', $type);
        $this->set('files', $files);
        $this->set('pageTitle', __d('cms', 'Media') );
    }


    public function search()
    {
        $this->BakeryLogin->checkAdminRestriction('index');

        App::import('Core', 'Sanitize');

        if(!empty($_POST['q']))
        {
            $this->set('keyword', $_POST['q']);
            $keyword = Sanitize::escape($_POST['q']);

            $files = $this->MediaGalleryFile->find('all',
                        array('conditions' => array(
                                'or' => array(
                                    'MediaGalleryFile.title LIKE' => "%$keyword%",
                                    'MediaGalleryFile.description LIKE' => "%$keyword%",
                                    'MediaGalleryFile.filename LIKE' => "%$keyword%"
                                )
                            )
                        )
            );

            $this->set('files', $files);
            $this->set('pageTitle', __d('cms', 'Search media gallery') );
            $this->Breadcrumb->addCrumb(__d('cms', 'Search'));
        }
        else
        {
            return $this->redirect('/bakery/media_gallery');
        }
    }


    public function edit($id)
    {
        $id = (int) $id;

        // Save
        if( !empty($this->data) )
        {
            $this->MediaGalleryFile->save($this->data['MediaGalleryFile']);
            $this->Session->setFlash(__d('cms', 'The file has been saved'), 'default', array('class' => 'information'));
            return $this->redirect('/bakery/media_gallery');
        }
        else // Retrieve info
        {
            $this->data = $this->MediaGalleryFile->findById($id);
        }

        // Breadcrumb
        $this->Breadcrumb->addCrumb(__d('cms', 'Edit file'));
        $this->set('pageTitle', __d('cms', 'Edit file'));
    }


    public function crop($id)
    {
        $this->BakeryLogin->checkAdminRestriction('edit');

        // Crop image
        if(!empty($id) && isset($_POST['x']) && isset($_POST['y']) && !empty($_POST['w']) && !empty($_POST['h']))
        {
            App::import('Vendor', 'PHPThumb', array('file' => 'phpThumb/ThumbLib.inc.php'));

            $imageData = $this->MediaGalleryFile->findById($id);

            // File
            $filePath = ROOT . DS . APP_DIR . DS . WEBROOT_DIR . '/media/' . $imageData['MediaGalleryFile']['filename'];

            $thumb = PhpThumbFactory::create($filePath);

            // Type
            if(substr($filePath, -3) == 'png')
            {
                $type = 'png';
            }
            elseif(substr($filePath, -3) == 'gif')
            {
                $type = 'gif';
            }
            else
            {
                $type = 'jpg';
            }

            // Crop
            $thumb->crop($_POST['x'], $_POST['y'], $_POST['w'], $_POST['h']);

            // Save
            $thumb->save(ROOT . DS . APP_DIR . DS . WEBROOT_DIR . '/media/' . $imageData['MediaGalleryFile']['filename'], $type);

            return $this->redirect('/bakery/media_gallery/edit/' . $id);
        }
        else // Retrieve info
        {
            $this->data = $this->MediaGalleryFile->findById($id);
        }

        // Breadcrumb
        $this->Breadcrumb->addCrumb(__d('cms', 'Edit image'), '/bakery/media_gallery/edit/' . $id);
        $this->Breadcrumb->addCrumb(__d('cms', 'Crop image'));

        // Page title
        $this->set('pageTitle', __d('cms', 'Crop image'));
    }


    public function delete($id)
    {
        $id = (int) $id;

        $file = $this->MediaGalleryFile->findById($id);

        $this->MediaGalleryFile->id = $id;
        $this->MediaGalleryFile->delete();

        // Delete file
        unlink(ROOT . DS . APP_DIR . DS . WEBROOT_DIR . '/media/' . $file['MediaGalleryFile']['filename']);

        return $this->redirect('/bakery/media_gallery');
    }

    public function media_gallery()
    {
        $this->layout = 'empty';

        header('Content-Type: application/javascript');
    }
}
