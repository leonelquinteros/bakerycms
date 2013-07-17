<?php
Router::connect('/cms/media_gallery', array('plugin' => 'MediaGallery', 'controller' => 'MediaGalleryCms', 'action' => 'index'));
Router::connect('/cms/media_gallery/:action/*', array('plugin' => 'MediaGallery', 'controller' => 'MediaGalleryCms'));
Router::connect('/cms/media_gallery_ajax/:action/*', array('plugin' => 'MediaGallery', 'controller' => 'MediaGalleryAjax'));

Router::connect('/media_gallery/js/cms.media.gallery.js', array('plugin' => 'MediaGallery', 'controller' => 'MediaGalleryCms', 'action' => 'media_gallery'));
Router::connect('/media_gallery/css/cms.media.gallery.css', array('plugin' => 'MediaGallery', 'controller' => 'MediaGalleryCms', 'action' => 'css'));

Router::connect('/media_gallery/:perform/*', array('plugin' => 'MediaGallery', 'controller' => 'MediaGalleryThumb', 'action' => 'perform'));
