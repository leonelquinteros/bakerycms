<?php
class MediaGalleryCmsController extends MediaGalleryAppController
{
    public $uses = array('MediaGallery.MediaGalleryFile');

    public $components = array('CmsLogin', 'Breadcrumb', 'CmsMenu');

    public $helpers = array('CmsBreadcrumb', 'CmsWelcome', 'Form');

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
        $this->layout = "cms/cms";

        // Checks login
        $this->CmsLogin->checkAdminLogin();

        $this->Breadcrumb->addCrumb(__d('cms', 'Home'), '/cms');

        if( $this->action == 'index' )
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Media'));
        }
        else
        {
            $this->Breadcrumb->addCrumb(__d('cms', 'Media'), '/cms/media_gallery');
        }


        $cmsMenu = $this->CmsMenu->getMenu();
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
        $this->CmsLogin->checkAdminRestriction('index');

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

            $this->includeJs('fileuploader.js');

            $this->set('files', $files);
            $this->set('pageTitle', __d('cms', 'Search media gallery') );
            $this->Breadcrumb->addCrumb(__d('cms', 'Search'));
        }
        else
        {
            return $this->redirect('/cms/pages');
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
            return $this->redirect('/cms/media_gallery');
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
        $this->CmsLogin->checkAdminRestriction('edit');

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

            return $this->redirect('/cms/media_gallery/edit/' . $id);
        }
        else // Retrieve info
        {
            $this->data = $this->MediaGalleryFile->findById($id);
        }

        // Breadcrumb
        $this->Breadcrumb->addCrumb(__d('cms', 'Edit image'), '/cms/media_gallery/edit/' . $id);
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

        return $this->redirect('/cms/media_gallery');
    }

    public function media_gallery()
    {
        $this->layout = 'empty';

        header('Content-Type: application/javascript');
    }

    public function css()
    {
        $this->layout = 'empty';

        header('Content-Type: text/css');
    }
}
