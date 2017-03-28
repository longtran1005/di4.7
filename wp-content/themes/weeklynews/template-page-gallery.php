<?php
/**
 * Template Name: Gallery Page
 */

get_header(); ?>

<!-- start:ad-top-banner -->
<?php get_template_part('elements/ad-top-banner'); ?>
<!-- end:ad-top-banner -->

<!-- start:container -->
<div class="container">
    <!-- start:page content -->
    <div id="page-content" class="hide-sidebar">
        
        <!-- start:main -->
        <div id="main">
            
            <!-- start:author-page -->
            <section id="video-page">
                
                <header>
                    <h2><?php the_title(); ?></h2>
                    <span class="borderline"></span>
                </header>
                
                <?php
                

                    $image_post_format_first    = '354_bfi_220';
                    $image_post_format_second   = '';
                    $image_post_first_width     = '354';
                    $image_post_first_height    = '220';
                    $image_post_second_width    = '0';
                    $image_post_second_height   = '0';
                    $shorten_text_chars         = 0;
                        
                    $category_id                = '';
                    $category_multiple_id       = '';
                    $post_tag_slug              = '';
                    $post_sort                  = '';
                    $post_limit                 = 9;
                    $post_offset                = 0;
                    $section_title              = '';
                    $section_link               = '';
                    $category_display           = '';
                    $post_paging                = true;

                    $args = array(
                        'posts_per_page' => $post_limit,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'post_format',
                                'field' => 'slug',
                                'terms' => array( 'post-format-gallery' )
                            )
                        )
                    );
                    
                    $r = new WP_Query( $args );
                    
                    // The Loop
                    if ( $r->have_posts() ) {
                        //$r->the_post();
                        
                        $post_counter   = 1;
    
                        $ajax_data      = 'data-block="block-gallery" data-cat="'. $category_multiple_id .'" data-count="'. $post_limit .'" data-max-pages="'. ($r->max_num_pages + 1) .'" data-offset="'. $post_offset .'" data-tag="'. $post_tag_slug .'" data-sort="'. $post_sort .'" data-display="'. $category_display .'" data-img-format-1="'. $image_post_format_first .'" data-img-format-2="'. $image_post_format_second .'" data-img-width-1="'. $image_post_first_width .'" data-img-width-2="'. $image_post_second_width .'" data-img-height-1="'. $image_post_first_height .'" data-img-height-2="'. $image_post_second_height .'" data-text="'. $shorten_text_chars .'"';
                        $ajax_block_id  = uniqid('mip-ajax-block-');
                        
                        $output = '<section id="'. $ajax_block_id .'" '. $ajax_data .'>';
                        $output .= '<div class="articles relative clearfix">';
                        
                        $post_ajax                              = new MipTheme_Ajax();
                        $post_ajax->ajax_query                  = $r;
                        $post_ajax->post_id                     = $post->ID;
                        $post_ajax->image_post_format_first     = $image_post_format_first;
                        $post_ajax->image_post_format_second    = $image_post_format_second;
                        $post_ajax->image_post_first_width      = $image_post_first_width;
                        $post_ajax->image_post_first_height     = $image_post_first_height;
                        $post_ajax->image_post_second_width     = $image_post_second_width;
                        $post_ajax->image_post_second_height    = $image_post_second_height;
                        $post_ajax->shorten_text_chars          = $shorten_text_chars;
                        $post_ajax->category_multiple_id        = $category_multiple_id;
                        $post_ajax->category_display            = $category_display;
                        
                        $output .= $post_ajax->formatBlockPostFormat();
                        $output .= '</div>';
                        
                        if ( $r->max_num_pages > 1 ) {
                            $output .= MipTheme_Ajax::setAjaxNav( $ajax_block_id );
                        }

                        $output .= '</section>';
                        
                        echo $output;
                        
                        
                    }
                    
                    /* Restore original Post Data */
                    wp_reset_postdata();

                ?>
                
            </section>
            <!-- end:author-page -->
            
        </div>
        <!-- end:main -->
        
    </div>
    <!-- end:page content -->
</div>
<!-- end:container -->

<?php
    //load footer
    get_footer();
?>