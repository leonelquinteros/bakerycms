<div class="bakery-media-files-scroller">
    <?php
    foreach($files as $file)
    {
        ?>
        <div>
            <?php
            if(substr($file['MediaGalleryFile']['filetype'], 0, 5) == 'image')
            {
            ?>
                <a href="#" class="cmsMediaGalleryFile" data-type="image" data-id="<?php echo $file['MediaGalleryFile']['id']; ?>" data-src="<?php echo $file['MediaGalleryFile']['filename']; ?>" data-title="<?php echo $file['MediaGalleryFile']['title']; ?>">
                    <img src="<?php echo $this->Html->url('/media_gallery/resizecrop/64/64/' . $file['MediaGalleryFile']['filename']); ?>" alt="" />
                </a>
                <br />
                <span><?php echo $file['MediaGalleryFile']['title']; ?></span>
            <?php
            }
            else
            {
                switch(substr($file['MediaGalleryFile']['filetype'], 0, 5))
                {
                    case 'video':
                    case 'audio':
                        $mediaType = substr($file['MediaGalleryFile']['filetype'], 0, 5);
                        break;

                    default:
                        $mediaType = 'application';

                }
                ?>
                <a href="#" class="cmsMediaGalleryFile" data-type="<?php echo $mediaType; ?>" data-id="<?php echo $file['MediaGalleryFile']['id']; ?>" data-src="<?php echo $file['MediaGalleryFile']['filename']; ?>" data-title="<?php echo $file['MediaGalleryFile']['title']; ?>">
                    <img src="<?php echo $this->Html->url('/media_gallery/resizecrop/64/64/document-icon.png'); ?>" alt="" />
                </a>
                <br />
                <span><?php echo $file['MediaGalleryFile']['title']; ?></span>
                <?php
            }
            ?>
        </div>
        <?php
    }
    ?>
</div>
