<style>
    a {
        outline: none;
    }

    .bakery-media-upload-form {
        position: relative;
        border-bottom: 1px solid #ffffff;
        text-align: left;
    }

    a.button-large {
        display: inline-block;
        width: 212px;
        height: 25px;
        padding-top: 8px;
        background: #0090FF;
        text-align: center;
        font-size: 14px;
        color: #fff;
        font-weight: bold;
        text-decoration: none !important;
        text-shadow: #000000 0px 1px 1px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        margin: 10px;
        box-shadow: 0px 2px 4px #444;
    }

    a.button-large:hover, a.button-filter:hover, a.button-small:hover {
        background: #0090FF;
        background: -moz-linear-gradient(top, #90CCFF, #0090FF);
        background: -webkit-linear-gradient(top, #90CCFF, #0090FF);
        background: -ms-linear-gradient(top, #90CCFF, #0090FF);
        background: -o-linear-gradient(top, #90CCFF, #0090FF);
        background: linear-gradient(top, #90CCFF, #0090FF);
    }

    a.button-filter {
        display: inline-block;
        width: 120px;
        height: 25px;
        padding-top: 8px;
        background: #0090FF;
        text-align: center;
        font-size: 14px;
        color: #fff;
        font-weight: bold;
        text-decoration: none !important;
        text-shadow: #000000 0px 1px 1px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        margin: 5px;
        box-shadow: 0px 2px 4px #444;
    }

    a.button-filter.active {
        background: #0090FF !important;
        background: -moz-linear-gradient(top, #FFCC90, #FF8600) !important;
        background: -webkit-linear-gradient(top, #FFCC90, #FF8600) !important;
        background: -ms-linear-gradient(top, #FFCC90, #FF8600) !important;
        background: -o-linear-gradient(top, #FFCC90, #FF8600) !important;
        background: linear-gradient(top, #FFCC90, #FF8600) !important;
    }

    .qq-upload-list {
        display: none;
    }

    .bakery-media-upload-form .upload-context {
        position: relative;
        width: 500px;
        float: right;
        margin-top: 10px;
    }

    .bakery-media-upload-form .upload-context.tip {
        padding-top: 8px;
    }

    .bakery-media-upload-form .upload-context.loading {
        display: none;
    }

    .bakery-media-upload-form .upload-context.loading img {
        margin-right: 10px;
    }

    .bakery-media-files {
        position: relative;
        text-align: center;
        width: 765px;
        height: 420px;
        overflow: auto;
    }

    .bakery-media-filter {
        border-bottom: 1px solid #ffffff;
    }

    .bakery-media-filter .filter-keyword {
        border: 1px solid #cccccc;
        padding: 3px 20px 3px 3px;
        width: 180px;
        background: #ffffff url('<?php echo $this->Html->url('/img'); ?>/bakery/icons/magnifier.png') right 5px no-repeat;
        margin: 5px 12px 5px 8px;
    }

    .bakery-media-files-scroller div {
        float: left;
        margin: 10px;
        padding: 10px;
        width: 64px;
        height: 100px;
        border: 1px solid #999999;
        position: relative;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0px 2px 4px #444;
    }

    .bakery-media-files-scroller div span {
        display: block;
        position: absolute;
        bottom: 0px;
        left: 0px;
        width: 84px;
        text-alignment: center;
        font-size: 10px;
        line-height: 13px;
    }

    .tinymce-media-insert {
        display: none;
    }

        .tinymce-media-insert label {
            display: inline-block;
        }

        .tinymce-media-insert input {
            position: relative;
            display: inline-block;
            width: 350px;
            margin-top: 8px;
        }

        .tinymce-media-insert .tiny-image-properties input {
            position: relative;
            display: inline-block;
            width: 80px;
        }

        .tinymce-media-insert .tiny-submit {
            text-align: center;
        }

        .tinymce-media-insert .tiny-submit a.button-large {
            margin: 10px auto;
        }
</style>

<input type="hidden" class="cmsMediaGalleryUpdater" value="0" />
<div class="cmsMediaGalleryContainer">
    <div class="bakery-media-upload-form">
        <a href="#" class="button-large mediaGalleryUploader" id="uploadFile"><?php echo __d('cms', 'Upload file');?></a>

        <div class="upload-context tip">
            <p><?php echo __d('cms', 'Tip: You can upload files to the Media Gallery directly from here.'); ?></p>
        </div>

        <div class="upload-context loading">
            <p>
                <img src="/img/bakery/loader.gif" alt="..." />
                Uploading file...
            </p>
        </div>
    </div>

    <div class="bakery-media-filter">
        <input type="text" class="filter-keyword" value="" placeholder="<?php echo __d('cms', 'Type your search condition...') ?>" />

        <a href="#" class="button-filter allFilter active"><?php echo __d('cms', 'All media');?></a>
        <a href="#" class="button-filter imagesFilter"><?php echo __d('cms', 'Images');?></a>
        <a href="#" class="button-filter videosFilter"><?php echo __d('cms', 'Videos');?></a>
        <a href="#" class="button-filter audioFilter"><?php echo __d('cms', 'Audio');?></a>
    </div>

    <div class="bakery-media-files"></div>
</div>

<div class="tinymce-media-insert" style="display:none;">
    <input type="hidden" name="filename" class="tiny-filename" value="" />
    <input type="hidden" name="filetype" class="tiny-filetype" value="" />

    <label for="title"><?php echo __d('cms', 'Title'); ?>:</label>
    <input type="text" name="title" class="tiny-title" />
    <br />
    <br />
    <div class="tiny-image-properties">
        <strong>Dimensions</strong>
        <br />
        <small><?php echo __d('cms', 'Leave one of the dimensions as 0 (zero) to preserve the image ratio. Otherwise the image will be resized and cropped to match both dimensions.'); ?></small>
        <br /><br />
        <label for="width"><?php echo __d('cms', 'Width');?>:</label>
        <input type="text" name="width" class="tiny-width" /> px
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="height"><?php echo __d('cms', 'Height');?>:</label>
        <input type="text" name="height" class="tiny-height" /> px
        <br />
    </div>

    <div class="tiny-submit">
        <a href="#" class="button-large tinyInsertMedia"><?php echo __d('cms', 'Insert');?></a>
    </div>
</div>
