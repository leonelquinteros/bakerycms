/**
 * CMS Media Gallery plugin
 *
 * Usage:
 * jQuery('selector').cmsMediaGallery({options});
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
    $.fn.cmsMediaGallery = function( options ) {
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
                galleryURL: '<?php echo $this->Html->url('/cms'); ?>/media_gallery_ajax/media_gallery',
                handler: '',
                handlerObject: false,
                type: 'media',
                ajaxUpload: false,
                onClick: function(el) { alert('Click on' + $(el).attr('data-title')); }
            };

            if ( options ) {
                $.extend( settings, options );
            }

            // Show tiny insert form.
            var tinyShowForm = function(el) {

                if( $(el).attr('data-type') != 'image' ) {
                    $($uiDialogClass).find('.tiny-imageProperties').hide();
                } else {
                    $($uiDialogClass).find('.tiny-imageProperties').show();
                }

                $("." + $uiDialogClass).find('.tiny-filename').val( $(el).attr('data-src') );
                $("." + $uiDialogClass).find('.tiny-filetype').val( $(el).attr('data-type') );
                $("." + $uiDialogClass).find('.tiny-title').val( $(el).attr('data-title') );
                $("." + $uiDialogClass).find('.tiny-width').val('320');
                $("." + $uiDialogClass).find('.tiny-height').val('0');

                $("." + $uiDialogClass).find('.tinyMediaGalleryInsert').dialog('open');
            };


            // Tiny insert media function
            var tinyInsertMedia = function(button) {
                if( $($(button).parents('.tinyMediaGalleryInsert').find('.tiny-filetype')[0]).attr('value') == 'image') {
                    content = '<img src="<?php echo $this->Html->url('/media_gallery'); ?>/thumb/' +
                                                $($(button).parents('.tinyMediaGalleryInsert').find('.tiny-width')[0]).attr('value') + '/' +
                                                $($(button).parents('.tinyMediaGalleryInsert').find('.tiny-height')[0]).attr('value') + '/' +
                                                $($(button).parents('.tinyMediaGalleryInsert').find('.tiny-filename')[0]).attr('value') +
                                                '" alt="' + $($(button).parents('.tinyMediaGalleryInsert').find('.tiny-title')[0]).attr('value') + '" />';
                } else {
                    content = '<a href="<?php echo $this->Html->url('/media'); ?>/' + $($(button).parents('.tinyMediaGalleryInsert').find('.tiny-filename')[0]).attr('value') + '">' + $($(button).parents('.tinyMediaGalleryInsert').find('.tiny-title')[0]).attr('value') + '</a>';
                }

                tinyMCE.activeEditor.execCommand('mceInsertContent', false, content);

                $("." + $uiDialogClass).find('.tinyMediaGalleryInsert').dialog('close');
                $gallery.dialog('close');
            };


            // Load files
            this.loadFiles = function() {
                    if(settings.type == 'image') {
                        var url = '<?php echo $this->Html->url('/cms'); ?>/media_gallery_ajax/images';
                    } else {
                        var url = '<?php echo $this->Html->url('/cms'); ?>/media_gallery_ajax/files';
                    }
                    $("." + $uiDialogGallery).find('.cmsMediaGalleryFiles').load(url, function() {
                        // Click event handler for media files.
                        $("." + $uiDialogGallery).find('.cmsMediaGalleryFiles').find('.cmsMediaGalleryFile').click( function() {
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
             * Set default options if type is 'tiny'
             */
            if(settings.type == 'tiny') {
                settings.onClick = tinyShowForm;
            }

            /**
             * Load interface
             */
            $gallery.load(settings.galleryURL, function() {
                // Load files
                this.loadFiles();

                // Tiny insert media click handler.
                $gallery.find('.tinyInsertMedia').click( function() {
                    tinyInsertMedia(this);
                });

                // Dialog
                $gallery.find('.tinyMediaGalleryInsert').dialog({
                            autoOpen: false,
                            width: 250,
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
                    action: '<?php echo $this->Html->url('/cms'); ?>/media_gallery_ajax/upload',
                    onSubmit: function(fileName) {
                        $("." + $uiDialogGallery).find('.imgLoading').show();
                        $("." + $uiDialogGallery).find('.uploadResult').html('Sending file...');
                    },
                    onComplete: function(fileName, data) {
                        $("." + $uiDialogGallery).find('.imgLoading').hide();
                        $("." + $uiDialogGallery).find('.uploadResult').html('File sent: ' + fileName);
                        $gallery.find(".cmsMediaGalleryUpdater").val("1");
                        obj.loadFiles();
                    }
                });


                // Filters
                if(settings.type == 'image') {
                    $("." + $uiDialogGallery).find('.cmsMediaGalleryFilter .button-medium').hide();
                }

                $gallery.find('.filterKeyword').keyup(function() {
                    var q = $(this).val();

                    $("." + $uiDialogGallery).find('.cmsMediaGalleryFile:not([data-src*=' + q + '])').parent('div').hide();
                    $gallery.find('.cmsMediaGalleryFile:not([data-title*=' + q + '])').parent('div').hide();

                    $("." + $uiDialogGallery).find('.cmsMediaGalleryFile[data-src*=' + q + ']').parent('div').show();
                    $("." + $uiDialogGallery).find('.cmsMediaGalleryFile[data-title*=' + q + ']').parent('div').show();
                });

                $(this).find('.allFilter').click(function() {
                    filter('');
                    return false;
                });

                $(this).find('.imagesFilter').click(function() {
                    filter('image');
                    return false;
                });

                $(this).find('.videosFilter').click(function() {
                    filter('video');
                    return false;
                });

                $(this).find('.audioFilter').click(function() {
                    filter('audio');
                    return false;
                });

                $(this).find('.othersFilter').click(function() {
                    filter('application');
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
