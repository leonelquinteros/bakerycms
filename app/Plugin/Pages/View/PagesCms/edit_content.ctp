<?php
$this->Html->css('flick/jquery-ui-1.10.3.custom.min', null, array('inline' => false));
$this->Html->css('MediaGallery.jquery.Jcrop.min', null, array('inline' => false));

$this->Html->script('jquery-1.9.1', array('inline' => false));
$this->Html->script('jquery.tools.min', array('inline' => false));
$this->Html->script('jquery-ui-1.10.3.custom.min', array('inline' => false));
$this->Html->script('fileuploader', array('inline' => false));
$this->Html->script('tinymce/tinymce.min', array('inline' => false));
$this->Html->script('tinymce/jquery.tinymce.min', array('inline' => false));
$this->Html->script('MediaGallery.bakery.media.gallery', array('inline' => false));
$this->Html->script('MediaGallery.jquery.Jcrop.min', array('inline' => false));

?>

<style type="text/css">
    #bakery-cms-edit-toolbar {
        position: fixed;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 80px;
        background: #212121;
        background: -moz-linear-gradient(top, #444444, #212121);
        background: -webkit-linear-gradient(top, #444444, #212121);
        background: -ms-linear-gradient(top, #444444, #212121);
        background: -o-linear-gradient(top, #444444, #212121);
        background: linear-gradient(top, #444444, #212121);
        box-shadow: 0px 1px 15px #212121;
        z-index: 100;
    }

    #bakery-cms-edit-toolbar #bakery-editor-toolbar {
        float: left;
        width: 630px;
        z-index: 110;
    }

    #bakery-cms-edit-toolbar #toolbar-placeholder {
        position: absolute;
        top: 15px;
        left: 15px;
        color: #ffffff;
        font-weight: bold;
    }

    #bakery-cms-edit-toolbar a.button-large {
        display: inline-block;
        float: right;
        width: 212px;
        height: 25px;
        padding-top: 6px;
        background: #0090FF;
        text-align: center;
        font-size: 14px;
        color: #fff;
        font-weight: bold;
        text-shadow: #000000 0px 1px 1px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        border: 0px;
        margin: 10px;
        box-shadow: 0px 2px 4px #444;
    }

    #bakery-cms-edit-toolbar a.button-large:hover, a.button-medium:hover, a.button-small:hover {
        background: #0090FF;
        background: -moz-linear-gradient(top, #90CCFF, #0090FF);
        background: -webkit-linear-gradient(top, #90CCFF, #0090FF);
        background: -ms-linear-gradient(top, #90CCFF, #0090FF);
        background: -o-linear-gradient(top, #90CCFF, #0090FF);
        background: linear-gradient(top, #90CCFF, #0090FF);
    }
</style>

<div id="bakery-cms-edit-toolbar">
    <span id="toolbar-placeholder"><?php echo __d('cms', 'Click on any editable content space to start editing.'); ?></span>

    <div id="bakery-editor-toolbar"></div>

    <a href="#" class="button-large" onclick="saveContent(); return false;">
        <?php echo __d('cms', 'Save and close'); ?>
    </a>

    <a href="#" onclick="window.close(); return false;" class="button-large" onclick="return confirm('<?php echo __d('cms', 'Your changes will not be saved. Are you sure you want to proceed?')?>')">
        <?php echo __d('cms', 'Cancel'); ?>
    </a>

    <a href="#" class="mediaGalleryOpener button-large">
        <?php echo __d('cms', 'Insert media'); ?>
    </a>
</div>

<div id="mediagallery-container" class="mediagallery-dialog" style="display:none;z-index:9999"></div>

<?php
echo $this->requestAction('/' . $page['PagesPage']['url'], array('return'));
?>

<script type="text/javascript">
    // Save content function.
    function saveContent() {
        var content = {};
        $('div.bakery-cms-edit').each( function(i, el) {
            content[$(el).attr('id')] = $(el).tinymce().getContent();
        });

        $.ajax({
                url: '<?php echo $this->Html->url('/bakery'); ?>/pagesajax/save_page_content/<?php echo $page['PagesPage']['id']; ?>',
                type: 'POST',
                data: content,
                success: function(data) {
                            window.close();
                }
        });
    }

    // OnDomReady
    $(document).ready( function() {
        // Put spacer on top.
        $('body').prepend('<div style="height:100px;clear:both;"></div>');

        var $toolbar = $('#bakery-cms-edit-toolbar').clone();
        $('#bakery-cms-edit-toolbar').remove()
        $('body').prepend($toolbar);

        // Media Gallery
        $('#mediagallery-container').bakeryMediaGallery({
            handler: '.mediaGalleryOpener',
            type: 'tiny'
        });

        // Convert all div.bakery-cms-edit to TinyMCE.
        $('div.bakery-cms-edit').each( function(i, el) {
            $el = $(el);

            $el.css('outline', '1px dotted rgb(153, 153, 153)');

            // Converts DIVs to TinyMCE
            var tinyEl = $el.tinymce({
                // Location of TinyMCE script
                script_url : '<?php echo $this->Html->url('/js'); ?>/tinymce/tinymce.js',

                // Files path
                relative_urls : false,

                // General options
                theme : "modern",
                schema : "html5",
                plugins : "anchor,link,image,textcolor,media,searchreplace,print,paste,directionality,table",
                statusbar: false,
                inline: true,
                fixed_toolbar_container: "#bakery-editor-toolbar",

                // Styles
                preview_styles: false,
                content_css : "/css/bootstrap/css/bootstrap.min.css,/css/bootstrap/css/bootstrap-responsive.min.css",
                body_class: $el.parent().attr('class'),

                width: $el.parent().css('width'),
                height: $el.parent().css('height')
            });
        });
    });

</script>
