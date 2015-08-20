
<?php echo $this->element('help/' . $this->Language->getLanguage() . '/edit'); ?>

<div id="bakery-actions">
    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3>
                <?php echo __d('cms', 'Actions'); ?>
                <a href="#" class="help" rel="#PageActionsHelp" title="<?php echo __d('cms', 'Help'); ?>">
                    <img src="<?php echo $this->Html->url('/img'); ?>/bakery/icons/help_icon.png" alt="<?php echo __d('cms', 'Help'); ?>" />
                </a>
            </h3>
        </div>
        <div class="bakery-action-box-content">
            <p class="bakery-action-boxButtons">
                <a href="#" class="action-button-large" onclick="this.onclick = function(){ return false; }; jQuery('#frmPages').submit(); return false;"><?php echo __d('cms', 'Save page'); ?></a>
                <br />
                <a href="<?php echo $this->Html->url('/bakery'); ?>/pages" class="button-large"><?php echo __d('cms', 'Back to pages'); ?></a>
            </p>
        </div>
        <div class="bakery-action-box-bottom"></div>
    </div>

    <div class="bakery-action-box">
        <div class="bakery-action-box-top">
            <h3>
                <?php echo __d('cms', 'Content'); ?>
                <a href=""  class="help" rel="#PageEditContentHelp" title="<?php echo __d('cms', 'Help'); ?>">
                    <img src="<?php echo $this->Html->url('/img'); ?>/bakery/icons/help_icon.png" alt="<?php echo __d('cms', 'Help'); ?>" />
                </a>
            </h3>
        </div>
        <div class="bakery-action-box-content">
            <p class="bakery-action-boxButtons">
                <a href="<?php echo $this->Html->url('/bakery'); ?>/pages/edit_content/<?php echo empty($this->data['PagesPage']['id']) ? '' : $this->data['PagesPage']['id']; ?>" target="_blank" id="editContent" class="action-button-large"><?php echo __d('cms', 'Edit content'); ?></a>
            </p>
        </div>
        <div class="bakery-action-box-bottom"></div>
    </div>

    <?php
    if( !empty($this->data['PagesPage']['id']) )
    {
        ?>
        <div class="bakery-action-box">
            <div class="bakery-action-box-top">
                <h3>
                    <?php echo __d('cms', 'Menu links'); ?>
                    <a href="#" class="help" rel="#PageMenuHelp" title="<?php echo __d('cms', 'Help'); ?>">
                        <img src="<?php echo $this->Html->url('/img'); ?>/bakery/icons/help_icon.png" alt="<?php echo __d('cms', 'Help'); ?>" />
                    </a>
                </h3>
            </div>
            <div class="bakery-action-box-content">
                <p class="bakery-action-text" style="color:#333333;padding:20px 10px 10px 10px">
                    Add or remove links to this page in Menu Structure
                </p>
                <div style="border-top:1px solid #AAAAAA;border-bottom:1px solid #FFFFFF;height:0px;margin:10px;"></div>
                <?php
                $end = count($menus);
                $i = 0;
                foreach($menus as $langName => $menu)
                {
                    $i++;
                    ?>
                    <div class="bakery-action-text" style="padding-bottom:0px;padding-left:20px;">
                        <strong style="color:#333333;font-size:1.2em;"><?php echo Language::name($langName); ?></strong>
                        <br /><br />

                        <?php
                        foreach($menu as $menuName => $menuItem)
                        {
                            if(!empty($menuItem))
                            {
                                ?>
                                <a href="#" class="removeMenuLink" rel="<?php echo $menuItem['MenusMenu']['id']; ?>" data-name="<?php echo $menuName; ?>" data-lang="<?php echo $langName; ?>" style="display:inline-block;margin-bottom:15px;">
                                    <img src="<?php echo $this->Html->url('/img'); ?>/bakery/icons/delete.png" style="margin-bottom:-3px;margin-right:10px;">
                                    <span style="font-weight:bold;font-size:1.2em;color:#0D5EC7;padding-bottom:5px;">Menu <?php echo $menuName; ?></span>
                                </a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a href='#' class="addMenuLink" rel="0" data-name="<?php echo $menuName; ?>" data-lang="<?php echo $langName; ?>" style="display:inline-block;margin-bottom:15px;">
                                    <img src="<?php echo $this->Html->url('/img'); ?>/bakery/icons/add.png" style="margin-bottom:-3px;margin-right:10px;">
                                    <span style='color:#333333;'>Menu <?php echo $menuName; ?></span>
                                </a>
                                <?php
                            }
                            echo "<br />";
                        }
                        ?>
                    </div>
                    <?php
                    if($i < $end)
                    {
                        ?>
                        <div style="border-top:1px solid #AAAAAA;border-bottom:1px solid #FFFFFF;height:0px;margin:10px;"></div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="bakery-action-box-bottom"></div>
        </div>
        <?php
    }
    ?>
</div>

<div id="bakery-main">
    <form id="frmPages" action="<?php echo $this->Html->url('/bakery'); ?>/pages/edit/<?php echo empty($this->data['PagesPage']['id']) ? '' : $this->data['PagesPage']['id']; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="goEditContent" id="goEditContent" value="0" />

        <div id="bakery-form">
            <h2 style="margin-top:0px;">
                <?php echo __d('cms', 'Page info'); ?>
                <a href="#" class="help" rel="#PageInfoHelp" title="<?php echo __d('cms', 'Help'); ?>">
                    <img src="<?php echo $this->Html->url('/img'); ?>/bakery/icons/help_icon.png" alt="<?php echo __d('cms', 'Help'); ?>" />
                </a>
            </h2>

            <?php
            $this->Form->inputDefaults(
            		array(
            				'div'	=> array(
            						'class' => 'form-group',
            				),
            				'class' => 'form-control',
            		)
            );
            
            if( !empty($this->data['PagesPage']['id']) )
            {
                echo $this->Form->input('PagesPage.id', array('type' => 'hidden'));
            }

            echo $this->Form->input('PagesPage.title',
                                array(
                                    'label' => __d('cms', 'Page Title'),
                                    'error' => __d('cms', 'This field cannot be empty'),
                                )
            );

            echo $this->Form->input('PagesPage.url',
                                array(
                                    'label' => __d('cms', 'URL'),
                                    'error' => empty($this->data['PagesPage']['url']) ? __d('cms', 'This field cannot be empty') : __d('cms', 'Another page is using this URL, please choose another one'),
                                )
            );

            if(count($languages) > 1)
            {
                echo $this->Form->input('PagesPage.lang',
                                    array(
                                        'type' => 'select',
                                        'label' => __d('cms', 'Language'),
                                        'options' => $languages,
                                    )
                );
            }
            else
            {
                echo $this->Form->input('PagesPage.lang', array('type' => 'hidden', 'value' => DEFAULT_SUPPORTED_LANGUAGE));
            }

            if(count($layouts) > 1)
            {
                echo $this->Form->input('PagesPage.layout',
                                    array(
                                        'type' => 'select',
                                        'options' => $layouts,
                                        'label' => __d('cms', 'Page layout'),
                                        'default' => 'page'
                                    )
                );
            }
            ?>

            <h2>
                <?php echo __d('cms', 'Publish information'); ?>
                <a href="" class="help" rel="#PagePublishHelp" title="<?php echo __d('cms', 'Help'); ?>">
                    <img src="<?php echo $this->Html->url('/img'); ?>/bakery/icons/help_icon.png" alt="<?php echo __d('cms', 'Help'); ?>" />
                </a>
            </h2>

            <div class="bakery-form-publish-info">
                <div id="bakery-form-publish-infoLabels" style="margin-bottom:5px;">
                    <label for="PagesPagePublish">Status</label>
                    <label for="PagesPagePublishDateDay" style="margin-left:101px;">Day</label>
                    <label for="PagesPagePublishDateMonth" style="margin-left:74px;">Month</label>
                    <label for="PagesPagePublishDateYear" style="margin-left:110px;">Year</label>
                    <label for="PagesPagePublishDateHour" style="margin-left:63px;">Hour</label>
                    <label for="PagesPagePublishDateMin" style="margin-left:67px;">Minute</label>
                </div>
                <?php
                echo $this->Form->input('PagesPage.publish',
                                    array(
                                        'type' => 'select',
                                        'options' => array('0' => __d('cms', 'Non publish'), '1' => __d('cms', 'Publish')),
                                        'label' => false,
                                        'style' => 'width:120px;',
                                    )
                );

                echo $this->Form->input('PagesPage.publish_date',
                                    array(
                                        'label' => false,
                                        'dateFormat' => 'DMY',
                                        'timeFormat' => '24',
                                        'monthNames' => array(
                                                            '01' => __d('cms', 'January'),
                                                            '02' => __d('cms', 'February'),
                                                            '03' => __d('cms', 'March'),
                                                            '04' => __d('cms', 'April'),
                                                            '05' => __d('cms', 'May'),
                                                            '06' => __d('cms', 'June'),
                                                            '07' => __d('cms', 'July'),
                                                            '08' => __d('cms', 'August'),
                                                            '09' => __d('cms', 'September'),
                                                            '10' => __d('cms', 'October'),
                                                            '11' => __d('cms', 'November'),
                                                            '12' => __d('cms', 'December'),
                                                    ),
                                    )
                );
                ?>
            </div>
            <div style="clear:both;"></div>

            <h2>
                <?php echo __d('cms', 'SEO Information'); ?>
                <a href="" class="help" rel="#PageSeoHelp" title="<?php echo __d('cms', 'Help'); ?>">
                    <img src="<?php echo $this->Html->url('/img'); ?>/bakery/icons/help_icon.png" alt="<?php echo __d('cms', 'Help'); ?>" />
                </a>
            </h2>
            <?php

            echo $this->Form->input('PagesPage.seo_title',
                                array(
                                    'label' => __d('cms', 'SEO Title'),
                                )
            );

            echo $this->Form->input('PagesPage.seo_keywords',
                                array(
                                    'label' => __d('cms', 'SEO Keywords')
                                )
            );

            if( !empty($this->data['PagesPage']['id']) )
            {
                ?>
                <div id="keywordsRecommendation"></div>

                <div style="text-align:right;margin:20px 0px;">
                    <a href="#" onclick="getKeywords(); return false;"><?php echo __d('cms', 'Get keywords recommendation'); ?></a>
                </div>
                <?php
            }

            echo $this->Form->input('PagesPage.seo_description',
                                array(
                                    'type' => 'textarea',
                                    'label' => __d('cms', 'SEO Description')
                                )
            );

            ?>
        </div>

        <div class="bakery-form-footer">
            <a href="#" id="editContent2" class="action-button-medium" onclick="this.onclick = function(){ return false; }; jQuery('#goEditContent').attr('value', '1'); jQuery('#frmPages').submit(); return false;"><?php echo __d('cms', 'Edit content'); ?></a>
            <a href="#" class="action-button-medium" onclick="this.onclick = function(){ return false; }; jQuery('#frmPages').submit(); return false;"><?php echo __d('cms', 'Save page'); ?></a>
        </div>
    </form>
</div>

<!-- Content Overlay -->
<script type="text/javascript">
    function openContentEditor() {
        <?php
        if(empty($this->data["PagesPage"]["id"]))
        {
            ?>
            var wContentEditor = window.open('/bakery/pages/edit_content', 'editContent', 'menubar=no,toolbar=no,status=no,directories=no,personalbar=no,width=1020,height=700,location=no,scrollbars=yes,resizable=yes');
            <?php
        }
        else
        {
            ?>
            var wContentEditor = window.open('/bakery/pages/edit_content/<?php echo $this->data["PagesPage"]["id"]; ?>', 'editContent', 'menubar=no,toolbar=no,status=no,directories=no,personalbar=no,width=1020,height=700,location=no,scrollbars=yes,resizable=yes');
            <?php
        }
        ?>
    }

    function addMenuLink(el) {
        var menuName = jQuery(el).attr('data-name');
        var menuLang = jQuery(el).attr('data-lang');

        jQuery.ajax({
            url: '/bakery/pagesajax/page_add_menu/<?php echo empty($this->data['PagesPage']['id']) ? '' : $this->data['PagesPage']['id']; ?>/' + menuName + '/' + menuLang,
            success: function(data) {
                        jQuery(el).find('img').attr('src', '/img/bakery/icons/delete.png');
                        jQuery(el).find('span').attr('style', 'font-weight:bold;font-size:1.2em;color:#0D5EC7;padding-bottom:5px;');
                        jQuery(el).attr('rel', data);

                        jQuery(el).unbind('click');
                        jQuery(el).click( function(e) {
                                removeMenuLink(el);
                                return false;
                            }
                        );
            }
        });
    }

    function removeMenuLink(el) {
        var menuId = jQuery(el).attr('rel');

        jQuery.ajax({
            url: '/bakery/pagesajax/page_remove_menu/' + menuId,
            success: function() {
                        jQuery(el).find('img').attr('src', '/img/bakery/icons/add.png');
                        jQuery(el).find('span').attr('style', 'color:#333333;');

                        jQuery(el).unbind('click');
                        jQuery(el).click( function(e) {
                                addMenuLink(el);
                                return false;
                            }
                        );
            }
        });
    }

    function getKeywords() {
        jQuery.ajax({
            url: '/bakery/pagesajax/page_keywords/<?php echo empty($this->data['PagesPage']['id']) ? '' : $this->data['PagesPage']['id']; ?>',
            success: function(data) {
                        jQuery('#keywordsRecommendation').html(data);
            }
        });
    }

    function insertKeyword(el) {
        if(jQuery('#PagesPageSeoKeywords').val() != '') {
            var keys = jQuery('#PagesPageSeoKeywords').val() + ',';
        } else {
            var keys = '';
        }
        jQuery('#PagesPageSeoKeywords').val(keys + jQuery(el).text());
    }

    //OnDomReady
    jQuery( function() {
        // Open content
        <?php
        if( !empty($goEditContent) )
        {
            ?>
            openContentEditor();
            <?php
        }
        ?>

        // Edit content click
        jQuery('#editContent').click(
            function() {
                if(jQuery('#PagesPageId').val()) {
                    jQuery.ajax(
                            {
                                async: false,
                                url: '/bakery/pages/edit/<?php echo empty($this->data['PagesPage']['id']) ? '' : $this->data['PagesPage']['id']; ?>',
                                type: 'POST',
                                data: jQuery('#frmPages').serialize()
                            }
                    );
                } else {
                    jQuery('#goEditContent').attr('value', '1');
                    jQuery('#frmPages').submit();
                    return false;
                }

                return true;
            }
        );


        // Add/Remove menu links
        jQuery('.addMenuLink').click(function(e) {
            addMenuLink(this);
            return false;
        } );
        jQuery('.removeMenuLink').click(function(e) {
            removeMenuLink(this);
            return false;
        } );

        // PageTitle onBlur
        jQuery('#PagesPageTitle').blur( function() {
                                            if(jQuery('#PagesPageSeoTitle').val() == '')
                                            {
                                                jQuery('#PagesPageSeoTitle').val( jQuery('#PagesPageTitle').val() );
                                            }
                                        }
        );
    });


</script>
