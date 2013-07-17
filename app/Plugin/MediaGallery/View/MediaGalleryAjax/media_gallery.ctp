<style>
    a {
        outline: none;
    }

    .cmsMediaGalleryUploadForm {
        position: relative;
        border-bottom: 1px solid #ffffff;
        text-align: left;
    }

    a.button-large {
        display: inline-block;
        width: 200px;
        height: 20px;
        padding-top: 4px;
        background: #C0DAD9;
        text-align: center;
        font-size: 14px;
        color: #222;
        text-shadow: #ffffff 0px 1px 1px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        border: 1px solid #aaa;
        margin: 10px;
        box-shadow: 0px 0px 2px #666;
        text-decoration: none;
    }

    a.button-large:hover, a.button-medium:hover, a.button-small:hover {
        background: #DCEBF7;
    }

    a.button-medium {
        display: inline-block;
        width: 110px;
        height: 20px;
        padding-top: 4px;
        background: #C0DAD9;
        text-align: center;
        font-size: 14px;
        color: #222;
        text-shadow: #ffffff 0px 1px 1px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        border: 1px solid #aaa;
        margin: 10px;
        box-shadow: 0px 0px 2px #666;
        text-decoration: none;
    }

    .qq-upload-list {
        display: none;
    }

    .cmsMediaGalleryFiles {
        position: relative;
        text-align: center;
        width: 765px;
        height: 420px;
        overflow: auto;
    }

    .tinyMediaGalleryInsert {
        display: none;
    }

        .tinyMediaGalleryInsert label {
            display: inline-block;
            width: 50px;
        }

        .tinyMediaGalleryInsert input {
            position: relative;
            display: inline-block;
            width: 150px;
            margin-left: 10px;
        }

    .cmsMediaGalleryFilter {
        border-bottom: 1px solid #ffffff;
    }

    .cmsMediaGalleryFilter .filterKeyword {
        border: 1px solid #cccccc;
        padding: 3px 20px 3px 3px;
        width: 180px;
        background: #ffffff url('<?php echo $this->Html->url('/img'); ?>/cms/icons/magnifier.png') right 5px no-repeat;
        margin: 5px 0px;
    }
</style>

<input type="hidden" class="cmsMediaGalleryUpdater" value="0" />
<div class="cmsMediaGalleryContainer">
    <div class="cmsMediaGalleryUploadForm">
        <a href="#" class="button-large mediaGalleryUploader" id="uploadFile"><?php echo __d('cms', 'Upload file');?></a>
    </div>

    <div class="cmsMediaGalleryFilter">
        <input type="text" class="filterKeyword" value="" placeholder="<?php echo __d('cms', 'Type your search condition...') ?>" />

        <a href="#" class="button-medium allFilter"><?php echo __d('cms', 'All media');?></a>
        <a href="#" class="button-medium imagesFilter"><?php echo __d('cms', 'Images');?></a>
        <a href="#" class="button-medium videosFilter"><?php echo __d('cms', 'Videos');?></a>
        <a href="#" class="button-medium audioFilter"><?php echo __d('cms', 'Audio');?></a>
    </div>

    <div class="cmsMediaGalleryFiles"></div>
</div>

<div class="tinyMediaGalleryInsert" style="display:none;">
    <input type="hidden" name="filename" class="tiny-filename" value="" />
    <input type="hidden" name="filetype" class="tiny-filetype" value="" />

    <label for="title"><?php echo __d('cms', 'Title');?></label>
    <input type="text" name="title" class="tiny-title" />
    <br />

    <div class="tiny-imageProperties">
        <label for="width"><?php echo __d('cms', 'Width');?></label>
        <input type="text" name="width" class="tiny-width" />
        <br />

        <label for="height"><?php echo __d('cms', 'Height');?></label>
        <input type="text" name="height" class="tiny-height" />
        <br />
    </div>
    <a href="#" class="button-large tinyInsertMedia"><?php echo __d('cms', 'Insert media');?></a>
</div>
