<?php
/**
 * WeeklyNews Theme
 * 
 * Theme by: MipThemes
 * http://themes.mipdesign.com
 *
 * Our portfolio: http://themeforest.net/user/mip/portfolio
 * Thanks for using our theme!
 *
 * File Date: 08/19/14
 */

global $curr_cat_id, $curr_cat_obj, $cat_template, $post_counter;
?>

<div class="scroll-area">
    <div class="container">
        <div class="row">
            <div class="section col-lg-6 col-md-8 col-xs-12">
                <?php
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        $row_link = get_permalink($post->ID);
                        $thumbnail = get_post_thumbnail_id(  $post->ID );
                        $type_display = get_field('type_display_on_home_page', $post->ID);
                        $headline_font_size = get_field('headline', $post->ID);
                        $image_src = "";
                        $font_size_class = "";

                        $title = $post->post_title;
                        $font_size_class = MipTheme_Util::getHeadlineFontSize($headline_font_size, $type_display, $row->post_title);


                        ?>
                        <div class="lp_row1">
                            <div class="spteaser">
                                <?php
                                if ($type_display == "image-left" || $type_display == "image-right") {
                                    $image_src = wp_get_attachment_image_src($thumbnail, 'post-thumb-2');

                                    if ($type_display == "image-left") {
                                        $class = "imgleft";
                                    } else {
                                        $class = "imgright";
                                    }
                                    ?>
                                    <div class="widget <?php  echo $class;?>">
                                        <a href="<?php  echo $row_link;?>">
                                            <span class="gate">
                                                <img src="<?php  echo $image_src[0];?>" width="256" height="144">
                                                <var>
                                                    <span>Foto:&nbsp;Colourbox</span>
                                                </var>
                                            </span>
                                        </a>
                                        <h2>
                                            <a href="<?php  echo $row_link;?>">
                                                <span class="<?php echo $font_size_class;?>">
                                                    <?php echo $title; ?>
                                                </span>
                                            </a>
                                        </h2>
                                        <p>
                                            <a href="<?php  echo $row_link;?>">
                                                <?php  echo get_field("summary", $post->ID);?>
                                            </a>
                                        </p>
                                    </div>
                                <?php
                                } else {
                                    $image_src = wp_get_attachment_image_src($thumbnail, 'post-thumb-wide');
                                    ?>
                                    <div class="widget <?php  echo $class;?>">
                                        <?php if ($image_src) {
                                            ?>
                                            <a href="<?php  echo $row_link?>">
                                                <span class="gate imgtopic bigfoto">
                                                    <img src="<?php  echo $image_src[0];?>" width="532" height="130">
                                                    <var>
                                                        <span><?php  echo $title?></span>
                                                        <span>Foto:&nbsp;Colourbox</span>
                                                    </var>
                                                </span>
                                            </a>
                                        <?php } ?>
                                        <h2>
                                            <a href="<?php  echo get_permalink($post->ID);?>">
                                                <span class="<?php echo $font_size_class;?>"><?php echo $title?><br></span>
                                            </a>
                                        </h2>
                                        <p>
                                            <a href="<?php  echo get_permalink($post->ID);?>">
                                                <?php  echo get_field("summary", $post->ID);?>
                                            </a>
                                        </p>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                    } //endwhile;
                    get_template_part('elements/parts/'. $cat_pagination );
                    ?>
                <?php
                }else{
                    echo "No Post.";
                }
                ?>
</div>

</div>

</div>
</div>
</div>
</div>