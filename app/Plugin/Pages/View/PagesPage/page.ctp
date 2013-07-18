<?php
if(!empty($page['PagesPage']['contact_form']))
{
    if(empty($pageClass))
    {
        $pageClass = ' with-contact-form';
    }
    else
    {
        $pageClass .= ' with-contact-form';
    }
}
?>
<article id="page" class="big-box<?php if(!empty($pageClass)) echo ' ' . $pageClass; ?>">
    <h1 class="page-title"><?php echo $pageTitle; ?> &laquo;</h1>

    <nav id="left-content">
        <div id="left-menu">
            <?php
            echo $this->element('Menus.submenu');
            ?>
        </div>

        <?php echo $this->element('Pages.side_actions'); ?>
    </nav>



    <div id="page-content" class="page-content<?php if(!empty($pageClass)) echo ' ' . $pageClass; ?>">
        <div id="mainContent" class="bakery-cms-edit">
            <?php
            if( !empty($pageContent['mainContent']) )
            {
                echo $pageContent['mainContent'];
            }
            ?>
        </div>

        <?php
        if(!empty($page['SlidesGallery']['SlidesSlide']))
        {
            if($page['PagesPage']['slide_gallery_type'] == 'tabs' || empty($page['PagesPage']['slide_gallery_type']))
            {
                ?>
                <section id="page-tabs" class="page-tabs">
                    <strong class="program-header"><?php echo $page['SlidesGallery']['SlidesGallery']['title']; ?></strong>
                    <ul class="tabs">
                        <?php
                        foreach($page['SlidesGallery']['SlidesSlide'] as $slide)
                        {
                            ?>
                            <li>
                                <a href="#">
                                    <img src="/media/<?php echo $slide['image']; ?>" alt="<?php echo $slide['title']; ?>" />
                                    <br />
                                    <small><?php echo $slide['title']; ?></small>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>

                    <div class="panes">
                        <?php
                        foreach($page['SlidesGallery']['SlidesSlide'] as $slide)
                        {
                            ?>
                            <div>
                                <?php echo $slide['content']; ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </section>
                <?php
            }
            elseif($page['PagesPage']['slide_gallery_type'] == 'vertical-tabs')
            {
                ?>
                <section id="page-vtabs" class="page-vtabs">
                    <strong class="program-header"><?php echo $page['SlidesGallery']['SlidesGallery']['title']; ?></strong>
                    <ul class="vtabs">
                        <?php
                        foreach($page['SlidesGallery']['SlidesSlide'] as $slide)
                        {
                            ?>
                            <li>
                                <a href="#">
                                    <?php echo $slide['title']; ?>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>

                    <div class="vpanes">
                        <?php
                        foreach($page['SlidesGallery']['SlidesSlide'] as $slide)
                        {
                            ?>
                            <div>
                                <?php echo $slide['content']; ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <div style="clear:both;"></div>
                </section>
                <?php
            }
            elseif($page['PagesPage']['slide_gallery_type'] == 'collapsible')
            {
                ?>
                <section id="page-collapsible" class="page-collapsible">
                    <?php
                    foreach($page['SlidesGallery']['SlidesSlide'] as $slide)
                    {
                        ?>
                        <span class="header-yellow toggle" data-id="<?php echo $slide['id']; ?>">
                            <?php echo $slide['title']; ?>
                        </span>
                        <div class="collapse" id="collapse<?php echo $slide['id']; ?>">
                            <?php echo $slide['content']; ?>
                        </div>
                        <?php
                    }
                    ?>
                </section>
                <?php
            }
            elseif($page['PagesPage']['slide_gallery_type'] == 'slider')
            {
                ?>
                <section id="page-slider" class="page-slider">
                    <h2><?php echo strtoupper($page['SlidesGallery']['SlidesGallery']['title']); ?></h2>

                    <div id="page-scrollable" class="page-scrollable">
                        <div class="items">
                            <?php
                            foreach($page['SlidesGallery']['SlidesSlide'] as $slide)
                            {
                                ?>
                                <div>
                                    <?php echo $slide['content']; ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="arrows">
                        <a class="prev browse left"><img src="/img/scroll-left-arrow.png" alt="" /></a>
                        <a class="next browse right"><img src="/img/scroll-right-arrow.png" alt="" /></a>
                    </div>
                </section>
                <?php
            }
        }
        ?>

        <div id="secondContent" class="bakery-cms-edit">
            <?php
            if( !empty($pageContent['secondContent']) )
            {
                echo $pageContent['secondContent'];
            }
            ?>
        </div>

        <?php
        if(!empty($page['SlidesGallery2']['SlidesSlide']))
        {
            if($page['PagesPage']['slide_gallery2_type'] == 'tabs' || empty($page['PagesPage']['slide_gallery2_type']))
            {
                ?>
                <section id="page-tabs2" class="page-tabs">
                    <strong class="program-header"><?php echo $page['SlidesGallery2']['SlidesGallery']['title']; ?></strong>
                    <ul class="tabs">
                        <?php
                        foreach($page['SlidesGallery2']['SlidesSlide'] as $slide)
                        {
                            ?>
                            <li>
                                <a href="#">
                                    <img src="/media/<?php echo $slide['image']; ?>" alt="<?php echo $slide['title']; ?>" />
                                    <br />
                                    <small><?php echo $slide['title']; ?></small>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>

                    <div class="panes">
                        <?php
                        foreach($page['SlidesGallery2']['SlidesSlide'] as $slide)
                        {
                            ?>
                            <div>
                                <?php echo $slide['content']; ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </section>
                <?php
            }
            elseif($page['PagesPage']['slide_gallery2_type'] == 'vertical-tabs')
            {
                ?>
                <section id="page-vtabs2" class="page-vtabs">
                    <strong class="program-header"><?php echo $page['SlidesGallery2']['SlidesGallery']['title']; ?></strong>
                    <ul class="vtabs">
                        <?php
                        foreach($page['SlidesGallery2']['SlidesSlide'] as $slide)
                        {
                            ?>
                            <li>
                                <a href="#">
                                    <?php echo $slide['title']; ?>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>

                    <div class="vpanes">
                        <?php
                        foreach($page['SlidesGallery2']['SlidesSlide'] as $slide)
                        {
                            ?>
                            <div>
                                <?php echo $slide['content']; ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <div style="clear:both;"></div>
                </section>
                <?php
            }
            elseif($page['PagesPage']['slide_gallery2_type'] == 'collapsible')
            {
                ?>
                <section id="page-collapsible2" class="page-collapsible">
                    <?php
                    foreach($page['SlidesGallery2']['SlidesSlide'] as $slide)
                    {
                        ?>
                        <span class="header-yellow toggle" data-id="<?php echo $slide['id']; ?>">
                            <?php echo $slide['title']; ?>
                        </span>
                        <div class="collapse" id="collapse<?php echo $slide['id']; ?>">
                            <?php echo $slide['content']; ?>
                        </div>
                        <?php
                    }
                    ?>
                </section>
                <?php
            }
            elseif($page['PagesPage']['slide_gallery2_type'] == 'slider')
            {
                ?>
                <section id="page-slider2" class="page-slider">
                    <h2><?php echo strtoupper($page['SlidesGallery2']['SlidesGallery']['title']); ?></h2>

                    <div id="page-scrollable2" class="page-scrollable">
                        <div class="items">
                            <?php
                            foreach($page['SlidesGallery2']['SlidesSlide'] as $slide)
                            {
                                ?>
                                <div>
                                    <?php echo $slide['content']; ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="arrows">
                        <a class="prev browse left"><img src="/img/scroll-left-arrow.png" alt="" /></a>
                        <a class="next browse right"><img src="/img/scroll-right-arrow.png" alt="" /></a>
                    </div>
                </section>
                <?php
            }
        }
        ?>

        <div id="thirdContent" class="bakery-cms-edit">
            <?php
            if( !empty($pageContent['thirdContent']) )
            {
                echo $pageContent['thirdContent'];
            }
            ?>
        </div>

        <?php
        if(!empty($page['PagesPage']['gb_blog_feed']))
        {
            $channel = Cache::read('feed-' . Inflector::slug($page['PagesPage']['gb_blog_feed']), 'ten');
            if($channel === false)
            {
                $channel = new Zend_Feed_Rss($page['PagesPage']['gb_blog_feed']);
                Cache::write('feed-' . Inflector::slug($page['PagesPage']['gb_blog_feed']), $channel, 'ten');
            }
            ?>
            <div id="blog-feed">
                <?php
                $i = 1;
                foreach($channel as $item)
                {
                    ?>
                    <div class="blog-item">
                        <a href="<?php echo $item->link; ?>" target="_blank">
                            <h5><?php echo $item->title; ?></h5>
                        </a>
                        <span class="blog-date"><?php echo date('F j, Y', strtotime($item->pubDate)); ?></span>
                        <br /><br />
                        <p>
                            <?php echo substr($item->description, 0, 290) . ' [...]'; ?>
                        </p>
                    </div>
                    <?php
                    $i++;
                    if($i > 3)
                    {
                        break;
                    }
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>

    <?php
    if(!empty($page['PagesPage']['contact_form']))
    {
        ?>
        <div class="contact-form">
            <form id="frmContact" method="post" action="/send-contact-form">
                <input type="hidden" name="page_id" value="<?php echo $page['PagesPage']['id']; ?>" />
                <span class="contact-header"><?php echo $page['PagesPage']['contact_form_heading1']; ?></span>
                <br />
                <span class="contact-header black"><?php echo $page['PagesPage']['contact_form_heading2']; ?></span>
                <br />
                <textarea name="comment" placeholder="Comment"></textarea>
                <br />
                <input type="text" name="first_name" placeholder="First Name" />
                <br />
                <input type="text" name="last_name" placeholder="Last Name" />
                <br />
                <input type="text" name="email" placeholder="Your email address" />
                <br />
                <input type="text" name="university" class="short" placeholder="University" />
                <input type="image" src="/img/arrow-blue.png" class="send" />
            </form>
        </div>
        <?php
    }
    ?>

    <div style="clear"></div>
</article>

<script type="text/javascript">

$(function() {

    $("ul.tabs").tabs("div.panes > div");

    $("ul.vtabs").tabs("div.vpanes > div");


    $('#page-collapsible .toggle').click( function() {
        if($(this).hasClass('open')) {
            $(this).removeClass('open');
        } else {
            $(this).addClass('open');
        }

        $('#collapse' + $(this).attr('data-id')).toggle('slow');
    });

    $('#page-collapsible2 .toggle').click( function() {
        if($(this).hasClass('open')) {
            $(this).removeClass('open');
        } else {
            $(this).addClass('open');
        }

        $('#collapse' + $(this).attr('data-id')).toggle('slow');
    });

    $(".page-scrollable").scrollable({circular: true});
});

</script>
