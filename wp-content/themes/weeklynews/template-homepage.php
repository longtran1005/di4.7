<?php
/**
 * Template Name: Home page
 */
    get_header();
    $posts_hompage = get_field("articles_on_home_page");
?>

<div class="scroll-area">
    <div class="container">
        <div class="row">
            <div class="section col-lg-6 col-md-8 col-xs-12">
                <div>
                    <?php foreach ($posts_hompage as $row) {
                        if(get_post_status($row->ID) === 'publish') {  //show post only if it's published
                            $currentTime = current_time('timestamp');

                            if(strtotime($row->post_date) <= $currentTime):
                            $row_link = get_permalink($row->ID);
                            
                            $thumbnail = get_post_thumbnail_id($row->ID);
                            $thumb_img = get_post( $thumbnail );
                            $type_display = get_field('type_display_on_home_page', $row->ID);

                            $image_src = "";
                            $font_size_class = "";
                            $headline_font_size = get_field('headline_font_size', $row->ID);
                            $font_size_class = MipTheme_Util::getHeadlineFontSize($headline_font_size, $type_display, $row->post_title);
                                $caption_img = get_post_meta($row->ID, '_mp_featured_image_caption', true);
                            if (!$caption_img) {
                                $caption_img = $thumb_img->post_excerpt;
                            }
                            ?>
                            <div class="lp_row1">
                                <div class="spteaser ">
                                    <?php
                                    if ($type_display == "image-left" || $type_display == "image-right") {
                                        $image_src = wp_get_attachment_image_src($thumbnail, 'post-thumb-2');
                                        $class = $type_display == "image-left" ? "imgleft" : "imgright";
                                        
                                        ?>
                                        <div class="widget <?php echo $class;?>">
                                            <a href="<?php echo $row_link;?>" class="" target="">
                                                <span class="gate">
                                                <img src="<?php echo $image_src[0];?>" width="256" height="144">
                                                <?php if ($thumb_img != null && ($thumb_img->post_content != null || $thumb_img->post_excerpt != null)) : ?>
                                                    <var>
                                                        <span><?php echo $thumb_img->post_content ?></span>
                                                        <span><?php echo $caption_img ?></span>
                                                    </var>
                                                <?php endif; ?>
                                                </span>
                                            </a>
                                            <h2>
                                                <a href="<?php echo $row_link;?>">
                                                    <span class="<?php echo $font_size_class;?>"><?php echo $row->post_title?></span>
                                                </a>
                                            </h2>
                                            <p>
                                                <a href="<?php echo $row_link;?>">
                                                    <?php echo get_field("summary", $row->ID);?>
                                                </a>
                                            </p>
                                        </div>
                                        <?php
                                    } else {
                                        $image_src = wp_get_attachment_image_src($thumbnail, 'post-thumb-wide');
                                        $class = "full-width";                                    
                                        ?>
                                        <div class="widget <?php echo $class;?>">
                                            <?php if ($image_src) {
                                                ?>
                                                <a href="<?php echo $row_link?>" class="" target="">
                                                    <span class="gate imgtopic bigfoto">
                                                    <img src="<?php echo $image_src[0];?>" width="532" height="130">
                                                    
                                                    <?php if ($thumb_img != null && ($thumb_img->post_content != null || $thumb_img->post_excerpt != null)) : ?>
                                                        <var>
                                                            <span><?php echo $thumb_img->post_content ?></span>
                                                            <span><?php echo $caption_img ?></span>
                                                        </var>
                                                    <?php endif; ?>
                                                    </span>
                                                </a>
                                            <?php } ?>
                                            <h2>
                                                <a href="<?php echo get_permalink($row->ID);?>">
                                                    <span class="<?php echo $font_size_class;?>"><?php echo $row->post_title?><br></span>
                                                </a>
                                            </h2>
                                            <p>
                                                <a href="<?php echo get_permalink($row->ID);?>">
                                                    <?php echo get_field("summary", $row->ID);?>
                                                </a>
                                            </p>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php
                        endif; //endif
                        }
                    }//endforeach
                    ?>
                </div>
            </div>

            <div class="aside col-lg-3 col-md-4 col-xs-12">
                <a class="secondcol-prenumerera skip-frame-reload" href="http://www.di.se/pren/digital-paketering/digitalpaper/">Prenumerera</a>
                <?php get_sidebar('mid') ?>
            </div>
            <div class="sidebar col-lg-2 col-md-12 col-xs-12">
                
            </div>
            <div class="fourthcol col-lg-2 col-md-12 col-xs-12">
                
            </div>
        </div>
    </div>
</div>

<?php
    get_footer();
?>
