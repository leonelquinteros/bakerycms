/**
 * Bakery CMS Media Gallery plugin
 *
 * Usage:
 * jQuery('selector').bakeryMediaGallery({options});
 *
 * Optinos reference:
 *
 * - handler: (string) jQuery string selector to use as click event handler to open the Media Gallery dialog.
 *
 * - type: (string) Gallery mode. Can be 'media', 'image' or 'tiny'.
 *                  For 'tiny' mode, there is a default onClik handler and you should use only one instance of the gallery in tiny mode.
 *
 * - onClick: (function(element)) Callback function for clicks on the desired image. Recieves the element reference of the clicked object.
 *                                  It has 3 attributes to use: data-src, data-type and data-title.
 */

( function( $ ) {
    $.fn.bakeryMediaGallery = function( options ) {
        // Plugin code
        return this.each(function() {
            var $gallery = $(this),
            $uiDialogClass = $gallery.attr("id") + "tiny",
            $uiDialogGallery = $gallery.attr("id"),
            $uiUploaderId = $gallery.attr("id") + "Uploader",
            $uiUploaderName = 'galleryUpload';

            // If options exist, lets merge them
            // with our default settings
            var settings = { // default settings
                galleryURL: '<?php echo $this->Html->url('/bakery'); ?>/media_gallery_ajax/media_gallery',
                handler: '',
                handlerObject: false,
                type: 'media',
                ajaxUpload: false,
                onClick: function(el) { alert('Click on' + $(el).data('title')); }
            };

            if ( options ) {
                $.extend( settings, options );
            }

            // Show tiny insert form.
            var tinyShowForm = function(el) {
                var $dialog = $("." + $uiDialogClass);

                if( $(el).attr('data-type') != 'image' ) {
                    $dialog.find('.tiny-image-properties').hide();
                } else {
                    $dialog.find('.tiny-image-properties').show();
                }

                $dialog.find('.tiny-filename').val( $(el).data('src') );
                $dialog.find('.tiny-filetype').val( $(el).data('type') );
                $dialog.find('.tiny-title').val( $(el).data('title') );
                $dialog.find('.tiny-width').val('320');
                $dialog.find('.tiny-height').val('0');

                $dialog.find('.tinymce-media-insert').dialog('open');
            };


            // Tiny insert media function
            var tinyInsertMedia = function(button) {
                var $insertData = $( $(button).parents('.tinymce-media-insert') );

                var filetype    = $insertData.find('.tiny-filetype').val();
                var filename    = $insertData.find('.tiny-filename').val();
                var title       = $insertData.find('.tiny-title').val();
                var width       = parseInt( $insertData.find('.tiny-width').val() );
                var height      = parseInt( $insertData.find('.tiny-height').val() );

                if( filetype == 'image' ) {
                    if(width > 0 && height > 0) {
                        var thumb = 'resizecrop';
                    } else {
                        var thumb = 'thumb';
                    }
                    content = '<img src="<?php echo $this->Html->url('/media_gallery'); ?>/' + thumb + '/' +
                                                width + '/' + height + '/' + filename +
                                                '" alt="' + title + '" />';
                } else {
                    content = '<a href="<?php echo $this->Html->url('/media'); ?>/' + filename + '">' + title + '</a>';
                }

                tinyMCE.activeEditor.execCommand('mceInsertContent', false, content);

                $("." + $uiDialogClass).find('.tinymce-media-insert').dialog('close');
                $gallery.dialog('close');
            };


            // Load files
            this.loadFiles = function() {
                    if(settings.type == 'image') {
                        var url = '<?php echo $this->Html->url('/bakery'); ?>/media_gallery_ajax/images';
                    } else {
                        var url = '<?php echo $this->Html->url('/bakery'); ?>/media_gallery_ajax/files';
                    }
                    $("." + $uiDialogGallery).find('.bakery-media-files').load(url, function() {
                        // Click event handler for media files.
                        $("." + $uiDialogGallery).find('.bakery-media-files').find('.cmsMediaGalleryFile').click( function() {
                                return settings.onClick(this, settings);
                        });
                    });
            };

            var filter = function(type) {
                if(type == '') {
                    $("." + $uiDialogGallery).find('.cmsMediaGalleryFile').parent('div').show();
                } else {
                    $("." + $uiDialogGallery).find('.cmsMediaGalleryFile').parent('div').hide();
                    $("." + $uiDialogGallery).find('.cmsMediaGalleryFile[data-type="' + type + '"]').parent('div').show();
                }
            }

            /**
             * Set default handler for 'tiny' mode
             */
            if(settings.type == 'tiny') {
                settings.onClick = tinyShowForm;
            }

            /**
             * Load UI
             */
            $gallery.load(settings.galleryURL, function() {
                // Load files
                this.loadFiles();

                // Tiny insert media handler.
                $gallery.find('.tinyInsertMedia').click( function() {
                    tinyInsertMedia(this);
                });

                // Media Gallery Dialog
                $gallery.find('.tinymce-media-insert').dialog({
                            autoOpen: false,
                            width: 450,
                            modal: true,
                            dialogClass: $uiDialogClass,
                            resizable: false,
                            title: 'Insert media'
                });

                // Ajax upload
                var obj = this;
                $gallery.find(".mediaGalleryUploader").attr("id", $uiUploaderId);
                var myUpload = new qq.FileUploader({
                    element: $('#' + $uiUploaderId)[0],
                    action: '<?php echo $this->Html->url('/bakery'); ?>/media_gallery_ajax/upload',
                    onSubmit: function(fileName) {
                        $("." + $uiDialogGallery).find('.upload-context').hide();
                        $("." + $uiDialogGallery).find('.loading').show();
                    },
                    onComplete: function(success, fileName) {
                        $("." + $uiDialogGallery).find('.upload-context').hide();
                        $("." + $uiDialogGallery).find('.tip p').html('File sent: ' + fileName);
                        $("." + $uiDialogGallery).find('.tip').show();

                        $gallery.find(".cmsMediaGalleryUpdater").val("1");
                        obj.loadFiles();
                    }
                });


                // Filters
                if(settings.type == 'image') {
                    $("." + $uiDialogGallery).find('.bakery-media-filter .button-medium').hide();
                }

                $gallery.find('.filter-keyword').keyup(function() {
                    var q = $(this).val();

                    $("." + $uiDialogGallery).find('.cmsMediaGalleryFile:not([data-src*=' + q + '])').parent('div').hide();
                    $gallery.find('.cmsMediaGalleryFile:not([data-title*=' + q + '])').parent('div').hide();

                    $("." + $uiDialogGallery).find('.cmsMediaGalleryFile[data-src*=' + q + ']').parent('div').show();
                    $("." + $uiDialogGallery).find('.cmsMediaGalleryFile[data-title*=' + q + ']').parent('div').show();
                });

                $(this).find('.allFilter').click(function() {
                    $('.button-filter').removeClass('active');
                    filter('');
                    $(this).addClass('active');

                    return false;
                });

                $(this).find('.imagesFilter').click(function() {
                    $('.button-filter').removeClass('active');
                    filter('image');
                    $(this).addClass('active');

                    return false;
                });

                $(this).find('.videosFilter').click(function() {
                    $('.button-filter').removeClass('active');
                    filter('video');
                    $(this).addClass('active');

                    return false;
                });

                $(this).find('.audioFilter').click(function() {
                    $('.button-filter').removeClass('active');
                    filter('audio');
                    $(this).addClass('active');

                    return false;
                });

                $(this).find('.othersFilter').click(function() {
                    $('.button-filter').removeClass('active');
                    filter('application');
                    $(this).addClass('active');

                    return false;
                });
            } );

            if(settings.type == 'image') {
                var dialogTitle = 'Image gallery';
            } else {
                var dialogTitle = 'Media gallery';
            }

            // Gallery dialog
            var obj2 = this;
            $gallery.dialog(
                {
                    autoOpen: false,
                    modal: true,
                    resizable: false,
                    dialogClass: $uiDialogGallery,
                    width: 792,
                    height: 'auto',
                    title: dialogTitle,
                    open: function(event, ui){
                        var locker = 0, load = 0;
                        $(".cmsMediaGalleryUpdater").each(function(index, element){
                                if($(this).val() == "1" && locker == 0){
                                    load = 1;
                                    locker = 1;
                                }
                                $(this).val("0");
                            });

                        if( load == 1 ){
                            obj2.loadFiles();
                        }
                    }

                }
            );

            var handlerObject = false;

            $(settings.handler).live('click', function() {
                    settings.handlerObject = jQuery(this);
                    $gallery.dialog('open');
                    return false;
            });
        });
    };
})( jQuery );
