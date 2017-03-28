<?php
/**
 * Theme by: MipThemes
 * http://themes.mipdesign.com
 *
 * Our portfolio: http://themeforest.net/user/mip/portfolio
 * Thanks for using our theme!
 */

if ( ! class_exists( 'MipTheme_Img_Widget' ) ) {

    class MipTheme_Img_Widget extends WP_Widget {

        function __construct() {
            parent::__construct(
                'mp_img_widget', // Base ID
                __('WeeklyNews[Image]', THEMENAME), // Name
                array( 'description' => __( 'Display image', THEMENAME ), ) // Args
            );
        }

        public function widget( $args, $instance ) {
            $img_source             = apply_filters( 'widget_img_source', $instance['img_source'] );
            $img_source_retina      = apply_filters( 'widget_img_source_retina', $instance['img_source_retina'] );
            $img_link               = apply_filters( 'widget_img_link', $instance['img_link'] );
            $img_padding            = apply_filters( 'widget_img_padding', $instance['img_padding'] );
            $img_responsive         = apply_filters( 'img_responsive',  esc_textarea($instance['img_responsive']) );
            if (! empty( $instance['img_link_target'] ) ) { $img_link_target = apply_filters( 'widget_img_link_target', $instance['img_link_target'] ); } else { $img_link_target = false; }
            $img_linkTarget         = ( $img_link_target ) ? ' target="_blank"' : '';

            if ( !empty( $img_source ) ) {
                if ( !empty( $img_link ) ) {
                    echo '<aside class="widget"><div'. ( !empty( $img_padding ) ? ' style="padding:'. esc_attr($img_padding) .';"'  : '' ) .'><a href="'. esc_url($img_link) .'"'. $img_linkTarget .'><img src="'. esc_url($img_source) .'" alt=""'. ( !empty( $img_responsive ) ? ' class="img-responsive"'  : '' ) .''. ( !empty( $img_source_retina ) ? ' data-retina="'. esc_url($img_source_retina) .'"'  : '' ) .' /></a></div></aside>';
                } else {
                    echo '<aside class="widget"><div'. ( !empty( $img_padding ) ? ' style="padding:'. esc_attr($img_padding) .';"'  : '' ) .'><img src="'. esc_url($img_source) .'" alt=""'. ( !empty( $img_responsive ) ? ' class="img-responsive"'  : '' ) .''. ( !empty( $img_source_retina ) ? ' data-retina="'. esc_url($img_source_retina) .'"'  : '' ) .' /></div></aside>';
                }
            }
        }

        public function form( $instance ) {
            if ( isset( $instance[ 'img_source' ] ) ) { $img_source = $instance[ 'img_source' ];       } else { $img_source = ''; }
            if ( isset( $instance[ 'img_source_retina' ] ) ) { $img_source_retina = $instance[ 'img_source_retina' ];       } else { $img_source_retina = ''; }
            if ( isset( $instance[ 'img_link' ] ) ) { $img_link = $instance[ 'img_link' ];       } else { $img_link = ''; }
            if ( isset( $instance[ 'img_link_target' ] ) ) { $img_link_target = esc_textarea($instance[ 'img_link_target' ]);       } else { $img_link_target = ''; }
            if ( isset( $instance[ 'img_padding' ] ) ) { $img_padding = $instance[ 'img_padding' ];       } else { $img_padding = ''; }
            if ( isset( $instance[ 'img_responsive' ] ) ) { $img_responsive = esc_textarea($instance[ 'img_responsive' ]);       } else { $img_responsive = ''; }


            ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'img_source' ); ?>"><?php _e( 'Image source:', THEMENAME ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'img_source' ); ?>" name="<?php echo $this->get_field_name( 'img_source' ); ?>" type="text" value="<?php echo esc_attr( $img_source ); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'img_source_retina' ); ?>"><?php _e( 'Image Retina source:', THEMENAME ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'img_source_retina' ); ?>" name="<?php echo $this->get_field_name( 'img_source_retina' ); ?>" type="text" value="<?php echo esc_attr( $img_source_retina ); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'img_link' ); ?>"><?php _e( 'Image link:', THEMENAME ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'img_link' ); ?>" name="<?php echo $this->get_field_name( 'img_link' ); ?>" type="text" value="<?php echo esc_attr( $img_link ); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'img_padding' ); ?>"><?php _e( 'Image padding: (optional)', THEMENAME ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'img_padding' ); ?>" name="<?php echo $this->get_field_name( 'img_padding' ); ?>" type="text" value="<?php echo esc_attr( $img_padding ); ?>"><br />
                <i>* e.g. 10px 15px 20px 30px</i>
            </p>
            <p><input id="<?php echo $this->get_field_id( 'img_link_target' ); ?>" name="<?php echo $this->get_field_name( 'img_link_target' ); ?>" type="checkbox"<?php if ($img_link_target) echo ' checked="checked"'; ?>>&nbsp;<label for="<?php echo $this->get_field_id( 'img_link_target' ); ?>"><?php _e( 'Open in new window', THEMENAME ); ?></label></p>
            <p><input id="<?php echo $this->get_field_id( 'img_responsive' ); ?>" name="<?php echo $this->get_field_name( 'img_responsive' ); ?>" type="checkbox"<?php if ($img_responsive) echo ' checked="checked"'; ?>>&nbsp;<label for="<?php echo $this->get_field_id( 'img_responsive' ); ?>"><?php _e( 'Responsive image', THEMENAME ); ?></label></p>

            <?php
        }

        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['img_source'] = ( ! empty( $new_instance['img_source'] ) ) ? strip_tags( $new_instance['img_source'] ) : '';
            $instance['img_source_retina'] = ( ! empty( $new_instance['img_source_retina'] ) ) ? strip_tags( $new_instance['img_source_retina'] ) : '';
            $instance['img_link'] = ( ! empty( $new_instance['img_link'] ) ) ? strip_tags( $new_instance['img_link'] ) : '';
            $instance['img_link_target'] = ( ! empty( $new_instance['img_link_target'] ) ) ? strip_tags( $new_instance['img_link_target'] ) : '';
            $instance['img_padding'] = ( ! empty( $new_instance['img_padding'] ) ) ? strip_tags( $new_instance['img_padding'] ) : '';
            $instance['img_responsive'] = ( ! empty( $new_instance['img_responsive'] ) ) ? strip_tags( $new_instance['img_responsive'] ) : '';

            return $instance;
        }

    }

}


if ( ! class_exists( 'MipTheme_AdsImg_Widget' ) ) {

    class MipTheme_AdsImg_Widget extends WP_Widget {

        function __construct() {
            parent::__construct(
                'mp_ads_img_widget', // Base ID
                __('WeeklyNews[Image Ad]', THEMENAME), // Name
                array( 'description' => __( 'Display ads - max 300px', THEMENAME ), ) // Args
            );
        }

        public function widget( $args, $instance ) {
            $ad_source          = apply_filters( 'widget_ad_source', $instance['ad_source'] );
            //$ad_link            = apply_filters( 'widget_ad_link', $instance['ad_link'] );
            if (! empty( $instance['ad_link'] ) ) { $ad_link = apply_filters( 'widget_ad_link', $instance['ad_link'] ); } else { $ad_link = ''; }
            if (! empty( $instance['ad_link_target'] ) ) { $ad_link_target = apply_filters( 'widget_ad_link_target', $instance['ad_link_target'] ); } else { $ad_link_target = false; }
            $ad_background      = apply_filters( 'widget_ad_background', $instance['ad_background'] );
            $ad_backgroundClass = ( $ad_background ) ? ' ad-separator' : '';
            $ad_linkTarget      = ( $ad_link_target ) ? ' target="_blank"' : '';

            if ( !empty( $ad_source ) ) {
                echo '<div class="ad'. esc_attr($ad_backgroundClass) .'"><a href="'. esc_url($ad_link) .'"'. $ad_linkTarget .'><img src="'. esc_url($ad_source) .'" alt="" /></a></div>';
            }
        }

        public function form( $instance ) {
            if ( isset( $instance[ 'ad_source' ] ) ) { $ad_source = $instance[ 'ad_source' ];       } else { $ad_source = ''; }
            if ( isset( $instance[ 'ad_link' ] ) ) { $ad_link = $instance[ 'ad_link' ];       } else { $ad_link = ''; }
            if ( isset( $instance[ 'ad_link_target' ] ) ) { $ad_link_target = $instance[ 'ad_link_target' ];       } else { $ad_link_target = ''; }
            if ( isset( $instance[ 'ad_background' ] ) ) { $ad_background = $instance[ 'ad_background' ];       } else { $ad_background = ''; }
            ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'ad_source' ); ?>"><?php _e( 'Image source:', THEMENAME ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'ad_source' ); ?>" name="<?php echo $this->get_field_name( 'ad_source' ); ?>" type="text" value="<?php echo esc_attr( $ad_source ); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'ad_link' ); ?>"><?php _e( 'Image link:', THEMENAME ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'ad_link' ); ?>" name="<?php echo $this->get_field_name( 'ad_link' ); ?>" type="text" value="<?php echo esc_attr( $ad_link ); ?>">
            </p>
            <p><input id="<?php echo $this->get_field_id( 'ad_link_target' ); ?>" name="<?php echo $this->get_field_name( 'ad_link_target' ); ?>" type="checkbox"<?php if ($ad_link_target) echo ' checked="checked"'; ?>>&nbsp;<label for="<?php echo $this->get_field_id( 'ad_link_target' ); ?>"><?php _e( 'Open in new window', THEMENAME ); ?></label></p>
            <p><input id="<?php echo $this->get_field_id( 'ad_background' ); ?>" name="<?php echo $this->get_field_name( 'ad_background' ); ?>" type="checkbox"<?php if ($ad_background) echo ' checked="checked"'; ?>>&nbsp;<label for="<?php echo $this->get_field_id( 'ad_background' ); ?>"><?php _e( 'Show with background color', THEMENAME ); ?></label></p>
            <?php
        }

        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['ad_source']      = ( ! empty( $new_instance['ad_source'] ) )         ? strip_tags( $new_instance['ad_source'] ) : '';
            $instance['ad_link']        = ( ! empty( $new_instance['ad_link'] ) )           ? strip_tags( $new_instance['ad_link'] ) : '';
            $instance['ad_link_target'] = ( ! empty( $new_instance['ad_link_target'] ) )    ? strip_tags( $new_instance['ad_link_target'] ) : '';
            $instance['ad_background']  = ( ! empty( $new_instance['ad_background'] ) )     ? strip_tags( $new_instance['ad_background'] ) : '';

            return $instance;
        }

    }

}


if ( ! class_exists( 'MipTheme_AdsEmbed_Widget' ) ) {

    class MipTheme_AdsEmbed_Widget extends WP_Widget {

        function __construct() {
            parent::__construct(
                'mp_ads_embed_widget', // Base ID
                __('WeeklyNews[Embed Ad]', THEMENAME), // Name
                array( 'description' => __( 'Display ads - max 300px', THEMENAME ), ) // Args
            );
        }

        public function widget( $args, $instance ) {
            $ad_source          = apply_filters( 'widget_ad_source', $instance['ad_source'] );
            $ad_background      = apply_filters( 'widget_ad_background',  esc_textarea($instance['ad_background']) );
            $ad_backgroundClass = ( $ad_background ) ? ' ad-separator' : '';

            if ( ! empty( $ad_source ) ) {
                echo '<div class="ad'. esc_attr($ad_backgroundClass) .'">'. $ad_source .'</div>';
            }
        }

        public function form( $instance ) {
            if ( isset( $instance[ 'ad_source' ] ) ) { $ad_source = $instance[ 'ad_source' ];       } else { $ad_source = ''; }
            if ( isset( $instance[ 'ad_background' ] ) ) { $ad_background = esc_textarea($instance[ 'ad_background' ]);       } else { $ad_background = ''; }
            ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'ad_source' ); ?>"><?php _e( 'Ad source:', THEMENAME ); ?></label>
                <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id( 'ad_source' ); ?>" name="<?php echo $this->get_field_name( 'ad_source' ); ?>"><?php echo esc_attr( $ad_source ); ?></textarea>
            </p>
            <p><input id="<?php echo $this->get_field_id( 'ad_background' ); ?>" name="<?php echo $this->get_field_name( 'ad_background' ); ?>" type="checkbox"<?php if ($ad_background) echo ' checked="checked"'; ?>>&nbsp;<label for="<?php echo $this->get_field_id( 'ad_background' ); ?>"><?php _e( 'show with background color', THEMENAME ); ?></label></p>
            <?php
        }

        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['ad_source'] = ( ! empty( $new_instance['ad_source'] ) ) ? $new_instance['ad_source'] : '';
            $instance['ad_background'] = ( ! empty( $new_instance['ad_background'] ) ) ? strip_tags( $new_instance['ad_background'] ) : '';

            return $instance;
        }

    }

}


if ( ! class_exists( 'MipTheme_AdsSystem_Widget' ) ) {

    class MipTheme_AdsSystem_Widget extends WP_Widget {

        function __construct() {
            parent::__construct(
                'mp_ads_system_widget', // Base ID
                __('WeeklyNews[Ads System]', THEMENAME), // Name
                array( 'description' => __( 'Display ads from Ads System', THEMENAME ), ) // Args
            );
        }

        public function widget( $args, $instance ) {
            $ad_source          = apply_filters( 'widget_ad_source', $instance['ad_source'] );
            $ad_background      = apply_filters( 'widget_ad_background', $instance['ad_background'] );
            $ad_backgroundClass = ( $ad_background ) ? ' ad-separator' : '';

            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$ad_source;

            echo $ad_unit->formatLayoutAd( 'ad'. $ad_backgroundClass .'' );
        }

        public function form( $instance ) {
            if ( isset( $instance[ 'ad_source' ] ) ) { $ad_source = $instance[ 'ad_source' ];       } else { $ad_source = ''; }
            if ( isset( $instance[ 'ad_background' ] ) ) { $ad_background = $instance[ 'ad_background' ];       } else { $ad_background = ''; }
            ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'ad_source' ); ?>"><?php _e( 'Ad source:', THEMENAME ); ?></label>
                <select class="widefat" id="<?php echo $this->get_field_id( 'ad_source' ); ?>" name="<?php echo $this->get_field_name( 'ad_source' ); ?>">
            <?php

            $args   = array( 'post_type' => 'mp_ads', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' );
            $r      = new WP_Query( $args );
            while ( $r->have_posts() ) : $r->the_post();
                echo '<option value="'. get_the_ID() .'"'. ( ( esc_attr( $ad_source ) == get_the_ID() ) ? ' selected' : '' ) .'>'. get_the_title() .'</option>';
            endwhile;
            wp_reset_postdata();
            ?>
                </select>
            </p>
            <p><input id="<?php echo $this->get_field_id( 'ad_background' ); ?>" name="<?php echo $this->get_field_name( 'ad_background' ); ?>" type="checkbox"<?php if ($ad_background) echo ' checked="checked"'; ?>>&nbsp;<label for="<?php echo $this->get_field_id( 'ad_background' ); ?>"><?php _e( 'show with background color', THEMENAME ); ?></label></p>
            <?php
        }

        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['ad_source'] = ( ! empty( $new_instance['ad_source'] ) ) ? strip_tags( $new_instance['ad_source'] ) : '';
            $instance['ad_background'] = ( ! empty( $new_instance['ad_background'] ) ) ? strip_tags( $new_instance['ad_background'] ) : '';

            return $instance;
        }

    }

}


if ( ! class_exists( 'MipTheme_Quote_Widget' ) ) {

    class MipTheme_Quote_Widget extends WP_Widget {

        function __construct() {
            parent::__construct(
                'mp_quote_widget', // Base ID
                __('WeeklyNews[Quote]', THEMENAME), // Name
                array( 'description' => __( 'Display quote with author and source', THEMENAME ), ) // Args
            );
        }

        public function widget( $args, $instance ) {
            $title          = apply_filters( 'widget_title', $instance['title'] );
            $quote_text     = apply_filters( 'widget_quote', $instance['quote_text'] );
            $quote_source   = apply_filters( 'widget_source', $instance['quote_source'] );
            $no_margin_class  = ( isset( $instance['no_margin'] ) && (bool)$instance['no_margin']  ) ? ' no-bottom-margin' : '';

            echo '<aside class="widget module-quote'. $no_margin_class .'">';
            if ( ! empty( $title ) ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }
            if ( ! empty( $quote_text ) ) {
                echo '<blockquote><p>' . $quote_text .'</p>';
                if ( ! empty( $quote_source ) ) {
                    echo '<footer>' . $quote_source .'</footer>';
                }
                echo '</blockquote>';
            }
            echo '</aside>';
        }

        public function form( $instance ) {
            if ( isset( $instance[ 'title' ] ) ) { $title = $instance[ 'title' ];       } else { $title = __( 'Weekly Quote', THEMENAME ); }
            if ( isset( $instance[ 'quote_text' ] ) ) { $quote_text = $instance[ 'quote_text' ];       } else { $quote_text = ''; }
            if ( isset( $instance[ 'quote_source' ] ) ) { $quote_source = $instance[ 'quote_source' ];       } else { $quote_source = ''; }
            $nomargin       = isset( $instance['no_margin'] ) ? (bool) $instance['no_margin'] : false;
            ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEMENAME ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'quote_text' ); ?>"><?php _e( 'Quote:', THEMENAME ); ?></label>
                <textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'quote_text' ); ?>" name="<?php echo $this->get_field_name( 'quote_text' ); ?>"><?php echo esc_attr( $quote_text ); ?></textarea>

                <label for="<?php echo $this->get_field_id( 'quote_source' ); ?>"><?php _e( 'Source:', THEMENAME ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'quote_source' ); ?>" name="<?php echo $this->get_field_name( 'quote_source' ); ?>" type="text" value="<?php echo esc_attr( $quote_source ); ?>">
            </p>

            <p><input class="checkbox" type="checkbox" <?php checked( $nomargin ); ?> id="<?php echo $this->get_field_id( 'no_margin' ); ?>" name="<?php echo $this->get_field_name( 'no_margin' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'no_margin' ); ?>"><?php _e( 'No spacing after this widget', THEMENAME ); ?></label></p>
            <?php
        }

        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['quote_text'] = ( ! empty( $new_instance['quote_text'] ) ) ? strip_tags( $new_instance['quote_text'] ) : '';
            $instance['quote_source'] = ( ! empty( $new_instance['quote_source'] ) ) ? strip_tags( $new_instance['quote_source'] ) : '';
            $instance['no_margin'] = isset( $new_instance['no_margin'] ) ? (bool) $new_instance['no_margin'] : false;

            return $instance;
        }

    }

}


if ( ! class_exists( 'MipTheme_RecentPosts_Widget' ) ) {

    class MipTheme_RecentPosts_Widget extends WP_Widget {

        function __construct() {
            $widget_ops = array('classname' => 'mp_recent_entries_widget', 'description' => __( "Your site&#8217;s most recent Posts.", THEMENAME) );
            parent::__construct('mp_recent_posts_widget', __('WeeklyNews[Recent Posts]', THEMENAME), $widget_ops);
            $this->alt_option_name = 'mp_recent_entries_widget';

            add_action( 'save_post', array($this, 'flush_widget_cache') );
            add_action( 'deleted_post', array($this, 'flush_widget_cache') );
            add_action( 'switch_theme', array($this, 'flush_widget_cache') );
        }

        function widget($args, $instance) {

            ob_start();
            extract($args);

            $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts', THEMENAME );

            /** This filter is documented in wp-includes/default-widgets.php */
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
            $include_categories = ( ! empty( $instance['include_categories'] ) ) ? $instance['include_categories'] : '';
            $exclude_categories =( ! empty( $instance['exclude_categories'] ) ) ? $instance['exclude_categories'] : '';
            $include_tags       = ( ! empty( $instance['include_tags'] ) ) ? $instance['include_tags'] : '';
            $sort_order         = ( ! empty( $instance['sort_order'] ) ) ? $instance['sort_order'] : '';

            $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
            $offset = ( ! empty( $instance['offset'] ) ) ? absint( $instance['offset'] ) : 0;
            $text_limit = ( ! empty( $instance['text_limit'] ) ) ? absint( $instance['text_limit'] ) : 100;
            if ( ! $number ) $number = 5;
            if ( ! $offset ) $offset = 0;
            if ( ! $text_limit ) $text_limit = 100;
            $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
            $display_cats = isset( $instance['display_cats'] ) ? $instance['display_cats'] : 'root_category';
            $layout = isset( $instance['layout'] ) ? $instance['layout'] : 'layout_one';

            //$show_images = isset( $instance['show_images'] ) ? $instance['show_images'] : false;
            $show_views = isset( $instance['show_views'] ) ? $instance['show_views'] : 'no-views';
            $show_category = isset( $instance['show_category'] ) ? $instance['show_category'] : false;
            $show_mid_column = isset( $instance['show_mid_column'] ) ? $instance['show_mid_column'] : false;

            /**
             * Filter the arguments for the Recent Posts widget.
             *
             * @since 3.4.0
             *
             * @see WP_Query::get_posts()
             *
             * @param array $args An array of arguments used to retrieve the recent posts.
             */

            $args1 = array(
                'posts_per_page'        => $number,
                'no_found_rows'         => true,
                'post_status'           => 'publish',
                'offset'                => $offset,
                'ignore_sticky_posts'   => true,
                'tag'                   => $include_tags,
                'orderby'               => ( (in_array($sort_order, array('mip_post_views_count', '_mip_post_views_count_7_day_total', '_mip_post_views_count_24_hours_total'))) ? 'meta_value_num' : $sort_order ),
                'meta_key'              => ( (in_array($sort_order, array('mip_post_views_count', '_mip_post_views_count_7_day_total', '_mip_post_views_count_24_hours_total'))) ? $sort_order : '' )
            );

            $args2  = array();
            if ($include_categories) {
                //$include_categories = explode(",", $include_categories);
                $args2 = array(
                    'cat'      => $include_categories
                );
            }

            $args3  = array();
            if ($exclude_categories) {
                $exclude_categories = explode(",", $exclude_categories);
                $args3 = array(
                    'category__not_in'      => $exclude_categories
                );
            }

            $args   = array_merge($args1, $args2, $args3);

            $r = new WP_Query( apply_filters( 'widget_posts_args', $args ) );

            if ($r->have_posts()) :
    ?>
                <?php echo '<aside class="module-news">'; ?>

                <div class="js-open-webtv-in-popup">
                    <div class="red-border-top"></div>
                    <div class="whitebox new-lastest-new-widget">
                        <h3>
                            <a id="" href="#"><?php echo $title ?></a>
                            <i class="icon-red-arrow-right"></i>
                        </h3>
                        <ul class="listwhite">
                            <?php
                                $post_counter   = 1;
                                while ( $r->have_posts() ) :
                                    $r->the_post();
                            ?>
                                    <li class="active">
                                        <a href="<?php the_permalink(); ?>" title="">
                                            <?php echo the_title()  ?>
                                        </a>
                                    </li>
                            <?php
                                    $post_counter++;
                                endwhile;
                            ?>
                        </ul>
                    </div>
                </div>

                <?php echo '</aside>'; ?>
    <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

            endif;

        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['include_categories'] = strip_tags($new_instance['include_categories']);
            $instance['exclude_categories'] = strip_tags($new_instance['exclude_categories']);
            $instance['include_tags'] = strip_tags($new_instance['include_tags']);
            $instance['number'] = (int) $new_instance['number'];
            $instance['offset'] = (int) $new_instance['offset'];
            $instance['text_limit'] = (int) $new_instance['text_limit'];
            $instance['sort_order']         = strip_tags($new_instance['sort_order']);
            $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
            $instance['display_cats'] = $new_instance['display_cats'];
            $instance['layout'] = $new_instance['layout'];

            //$instance['show_images'] = isset( $new_instance['show_images'] ) ? (bool) $new_instance['show_images'] : false;
            $instance['show_views'] = strip_tags($new_instance['show_views']);
            $instance['show_category'] = isset( $new_instance['show_category'] ) ? (bool) $new_instance['show_category'] : false;
            $instance['show_mid_column'] = isset( $new_instance['show_mid_column'] ) ? (bool) $new_instance['show_mid_column'] : false;

            $this->flush_widget_cache();

            $alloptions = wp_cache_get( 'alloptions', 'options' );
            if ( isset($alloptions['mp_recent_entries_widget']) )
                    delete_option('mp_recent_entries_widget');

            return $instance;
        }

        function flush_widget_cache() {
            wp_cache_delete('mp_recent_entries_widget', 'widget');
        }

        function form( $instance ) {
            $title              = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
            $include_categories = isset( $instance['include_categories'] ) ? esc_attr( $instance['include_categories'] ) : '';
            $exclude_categories = isset( $instance['exclude_categories'] ) ? esc_attr( $instance['exclude_categories'] ) : '';
            $include_tags       = isset( $instance['include_tags'] ) ? esc_attr( $instance['include_tags'] ) : '';
            $number             = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
            $offset             = isset( $instance['offset'] ) ? absint( $instance['offset'] ) : 0;
            $text_limit         = isset( $instance['text_limit'] ) ? absint( $instance['text_limit'] ) : 100;
            $show_date          = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
            $layout             = isset( $instance['layout'] ) ? esc_attr( $instance['layout'] ) : 'layout_one';
            $display_cats       = isset( $instance['display_cats'] ) ? esc_attr( $instance['display_cats'] ) : 'root_category';
            //$show_images        = isset( $instance['show_images'] ) ? (bool) $instance['show_images'] : false;
            $show_views         = isset( $instance['show_views'] ) ? esc_attr($instance['show_views']) : 'no-views';
            $show_category      = isset( $instance['show_category'] ) ? (bool) $instance['show_category'] : false;
            $show_mid_column    = isset( $instance['show_mid_column'] ) ? (bool) $instance['show_mid_column'] : false;
            $sort_order         = isset( $instance['sort_order'] ) ? esc_attr( $instance['sort_order'] ) : '';
    ?>
            <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEMENAME ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p><label for="<?php echo $this->get_field_id( 'include_categories' ); ?>"><?php _e( 'Include categories (separate ID by commas):', THEMENAME ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'include_categories' ); ?>" name="<?php echo $this->get_field_name( 'include_categories' ); ?>" type="text" value="<?php echo $include_categories; ?>" /></p>

            <p><label for="<?php echo $this->get_field_id( 'exclude_categories' ); ?>"><?php _e( 'Exclude categories (separate ID by commas):', THEMENAME ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'exclude_categories' ); ?>" name="<?php echo $this->get_field_name( 'exclude_categories' ); ?>" type="text" value="<?php echo $exclude_categories; ?>" /></p>

            <p><label for="<?php echo $this->get_field_id( 'include_tags' ); ?>"><?php _e( 'Include tags (separate tag slugs by commas):', THEMENAME ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'include_tags' ); ?>" name="<?php echo $this->get_field_name( 'include_tags' ); ?>" type="text" value="<?php echo $include_tags; ?>" /></p>

            <p>
                <label for="<?php echo $this->get_field_id('layout'); ?>"><?php _e( 'Widget Layout (not applied to mid column):', THEMENAME ); ?>
                    <select class='widefat' id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>" type="text">
                        <option value='layout_one'<?php echo ($layout=='layout_one')?'selected':''; ?>><?php _e( 'Layout 1 (all small images)', THEMENAME ); ?></option>
                        <option value='layout_two'<?php echo ($layout=='layout_two')?'selected':''; ?>><?php _e( 'Layout 2 (one big + small images)', THEMENAME ); ?></option>
                        <option value='layout_three'<?php echo ($layout=='layout_three')?'selected':''; ?>><?php _e( 'Layout 3 (all big images)', THEMENAME ); ?></option>
                    </select>
                </label>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('display_cats'); ?>"><?php _e( 'Display category as:', THEMENAME ); ?>
                    <select class='widefat' id="<?php echo $this->get_field_id('display_cats'); ?>" name="<?php echo $this->get_field_name('display_cats'); ?>" type="text">
                        <option value='root_category'<?php echo ($display_cats=='root_category')?'selected':''; ?>><?php _e( 'Root Category', THEMENAME ); ?></option>
                        <option value='all'<?php echo ($display_cats=='all')?'selected':''; ?>><?php _e( 'Subcategories', THEMENAME ); ?></option>
                    </select>
                </label>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('sort_order'); ?>"><?php _e( 'Sort order:', THEMENAME ); ?>
                    <select class='widefat' id="<?php echo $this->get_field_id('sort_order'); ?>" name="<?php echo $this->get_field_name('sort_order'); ?>" type="text">
                        <option value='date'<?php echo ($sort_order=='date')?'selected':''; ?>><?php _e( 'Latest', THEMENAME ); ?></option>
                        <option value='rand'<?php echo ($sort_order=='rand')?'selected':''; ?>><?php _e( 'Random posts', THEMENAME ); ?></option>
                        <option value='name'<?php echo ($sort_order=='name')?'selected':''; ?>><?php _e( 'By name', THEMENAME ); ?></option>
                        <option value='modified'<?php echo ($sort_order=='modified')?'selected':''; ?>><?php _e( 'Last Modified', THEMENAME ); ?></option>
                        <option value='comment_count'<?php echo ($sort_order=='comment_count')?'selected':''; ?>><?php _e( 'Most Commented', THEMENAME ); ?></option>
                        <option value='mip_post_views_count'<?php echo ($sort_order=='mip_post_views_count')?'selected':''; ?>><?php _e( 'Most Viewed', THEMENAME ); ?></option>
                        <option value='_mip_post_views_count_24_hours_total'<?php echo ($sort_order=='_mip_post_views_count_24_hours_total')?'selected':''; ?>><?php _e( 'Most Viewed Last 24 Hours', THEMENAME ); ?></option>
                        <option value='_mip_post_views_count_7_day_total'<?php echo ($sort_order=='_mip_post_views_count_7_day_total')?'selected':''; ?>><?php _e( 'Most Viewed Last 7 Days', THEMENAME ); ?></option>
                    </select>
                </label>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('show_views'); ?>"><?php _e( 'Display Views:', THEMENAME ); ?>
                    <select class='widefat' id="<?php echo $this->get_field_id('show_views'); ?>" name="<?php echo $this->get_field_name('show_views'); ?>" type="text">
                        <option value='no_views'<?php echo ($show_views=='no_views')?'selected':''; ?>><?php _e( 'Do not display views', THEMENAME ); ?></option>
                        <option value='all_views'<?php echo ($show_views=='all_views')?'selected':''; ?>><?php _e( 'Display all views for post', THEMENAME ); ?></option>
                        <option value='last_24_hours'<?php echo ($show_views=='last_24_hours')?'selected':''; ?>><?php _e( 'Display only last 24 hours views for post', THEMENAME ); ?></option>
                        <option value='last_7_days'<?php echo ($show_views=='last_7_days')?'selected':''; ?>><?php _e( 'Display only last 7 days views for post', THEMENAME ); ?></option>
                    </select>
                </label>
            </p>

            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', THEMENAME ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

            <p><label for="<?php echo $this->get_field_id( 'offset' ); ?>"><?php _e( 'Post offset:', THEMENAME ); ?></label>
            <input id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" type="text" value="<?php echo $offset; ?>" size="3" /></p>

            <p><label for="<?php echo $this->get_field_id( 'text_limit' ); ?>"><?php _e( 'Limit text chars for mid column:', THEMENAME ); ?></label>
            <input id="<?php echo $this->get_field_id( 'text_limit' ); ?>" name="<?php echo $this->get_field_name( 'text_limit' ); ?>" type="text" value="<?php echo $text_limit; ?>" size="4" /></p>

            <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', THEMENAME ); ?></label></p>

            <p><input class="checkbox" type="checkbox" <?php checked( $show_category ); ?> id="<?php echo $this->get_field_id( 'show_category' ); ?>" name="<?php echo $this->get_field_name( 'show_category' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_category' ); ?>"><?php _e( 'Display category?', THEMENAME ); ?></label></p>

            <p><input class="checkbox" type="checkbox" <?php checked( $show_mid_column ); ?> id="<?php echo $this->get_field_id( 'show_mid_column' ); ?>" name="<?php echo $this->get_field_name( 'show_mid_column' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_mid_column' ); ?>"><?php _e( 'Style it for mid column?', THEMENAME ); ?></label></p>
    <?php
        }
    }

}


if ( ! class_exists( 'MipTheme_Timeline_Widget' ) ) {

    class MipTheme_Timeline_Widget extends WP_Widget {

        function __construct() {
            $widget_ops = array('classname' => 'mp_timeline_widget', 'description' => __( "Your site&#8217;s most recent Posts in timeline.", THEMENAME) );
            parent::__construct('mp_timeline_widget', __('WeeklyNews[Timeline]', THEMENAME), $widget_ops);
            $this->alt_option_name = 'mp_timeline_entries_widget';

            add_action( 'save_post', array($this, 'flush_widget_cache') );
            add_action( 'deleted_post', array($this, 'flush_widget_cache') );
            add_action( 'switch_theme', array($this, 'flush_widget_cache') );
        }

        function widget($args, $instance) {
            $cache = array();
            if ( ! $this->is_preview() ) {
                    $cache = wp_cache_get( 'mp_timeline_entries_widget', 'widget' );
            }

            if ( ! is_array( $cache ) ) {
                    $cache = array();
            }

            if ( ! isset( $args['widget_id'] ) ) {
                    $args['widget_id'] = $this->id;
            }

            if ( isset( $cache[ $args['widget_id'] ] ) ) {
                    echo $cache[ $args['widget_id'] ];
                    return;
            }

            ob_start();
            extract($args);

            $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Timeline', THEMENAME );

            /** This filter is documented in wp-includes/default-widgets.php */
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
            $offset = ( ! empty( $instance['offset'] ) ) ? absint( $instance['offset'] ) : 0;
            if ( ! $number ) $number = 5;
            if ( ! $offset ) $offset = 0;
            $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
            $display_cats = isset( $instance['display_cats'] ) ? $instance['display_cats'] : 'root_category';

            $tmp_cats = isset( $instance['cats'] ) ? $instance['cats'] : '';
            if( ! $cats = $tmp_cats )  $cats='';

            /**
             * @param array $args An array of arguments used to retrieve the recent posts.
             */
            $r = new WP_Query( apply_filters( 'widget_posts_args', array(
                    'posts_per_page'      => $number,
                    'category__in'        => $cats,
                    'no_found_rows'       => true,
                    'post_status'         => 'publish',
                    'offset'      => $offset,
                    'ignore_sticky_posts' => true
            ) ) );

            if ($r->have_posts()) :
    ?>
                <?php echo '<aside class="widget module-timeline">'; ?>
                <?php if ( $title ) echo $before_title . $title . $after_title; ?>

                <h3>
                    <a id="" href="#">SENASTE NYTT</a>
                    <i class="icon-red-arrow-right"></i>
                </h3>

                <!-- start:articles -->
                <div class="articles">
                <?php
                    while ( $r->have_posts() ) :
                        $r->the_post();
                        $category = get_the_category();
                ?>

                    <!-- start:article -->
                    <article>
                        <span class="published"><?php the_time( MIPTHEME_DATE_TIMELINE ) ?></span>
                        <span class="published-time"><?php the_time( MIPTHEME_TIME_DEFAULT ) ?></span>
                        <div class="cnt">

                            <?php
                                if ( $category ) :
                                    if ( $display_cats == 'root_category' ) :
                                        $curr_cat_id_tmp    = MipTheme_Util::get_category_top_parent_id($category[0]->term_id);
                                        $curr_cat_obj       = get_category($curr_cat_id_tmp);
                                        echo '<i class="bullet parent-bullet-'. esc_attr(MipTheme_Util::get_category_top_parent_id($curr_cat_id_tmp)) .' bullet-' . $curr_cat_id_tmp . '"></i>';
                                        echo '<span class="category parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($curr_cat_id_tmp)) .' cat-' . $curr_cat_id_tmp . '"><a href="' . get_category_link( $curr_cat_obj->term_id ) . '">'. $curr_cat_obj->name .'</a></span>';
                                    else :
                                        $curr_cat_id    = MipTheme_Util::get_category_last_child_id($category);
                                        echo '<i class="bullet parent-bullet-'. esc_attr(MipTheme_Util::get_category_top_parent_id($curr_cat_id)) .' bullet-' . $curr_cat_id . '"></i>';
                                        echo '<span class="category parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($curr_cat_id)) .' cat-' . $curr_cat_id . '"><a href="' . get_category_link( $curr_cat_id ) . '">'. get_cat_name($curr_cat_id) .'</a></span>';
                                    endif;
                                endif;
                            ?>
                            <h3><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h3>
                        </div>
                    </article>
                    <!-- end:article -->
                <?php endwhile; ?>
                </div>
                <!-- end:article-container -->
                <?php echo '</aside>'; ?>

    <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

            endif;

            if ( ! $this->is_preview() ) {
                $cache[ $args['widget_id'] ] = ob_get_flush();
                wp_cache_set( 'mp_timeline_entries_widget', $cache, 'widget' );
            } else {
                ob_end_flush();
            }
        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['number'] = (int) $new_instance['number'];
            $instance['offset'] = (int) $new_instance['offset'];
            $instance['cats'] = $new_instance['cats'];
            $instance['display_cats'] = $new_instance['display_cats'];
            $this->flush_widget_cache();

            $alloptions = wp_cache_get( 'alloptions', 'options' );
            if ( isset($alloptions['mp_timeline_entries_widget']) )
                    delete_option('mp_timeline_entries_widget');

            return $instance;
        }

        function flush_widget_cache() {
            wp_cache_delete('mp_timeline_entries_widget', 'widget');
        }

        function form( $instance ) {
            $title          = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
            $number         = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
            $offset         = isset( $instance['offset'] ) ? absint( $instance['offset'] ) : 0;
            $iCats          = isset( $instance['cats'] ) ?  $instance['cats'] : '';
            $display_cats   = isset( $instance['display_cats'] ) ? esc_attr( $instance['display_cats'] ) : 'root_category';
    ?>
            <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEMENAME ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p>
                <label for="<?php echo $this->get_field_id('display_cats'); ?>"><?php _e( 'Display category as:', THEMENAME ); ?>
                    <select class='widefat' id="<?php echo $this->get_field_id('display_cats'); ?>" name="<?php echo $this->get_field_name('display_cats'); ?>" type="text">
                        <option value='root_category'<?php echo ($display_cats=='root_category')?'selected':''; ?>><?php _e( 'Root Category', THEMENAME ); ?></option>
                        <option value='all'<?php echo ($display_cats=='all')?'selected':''; ?>><?php _e( 'Subcategories', THEMENAME ); ?></option>
                    </select>
                </label>
            </p>

            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', THEMENAME ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

            <p><label for="<?php echo $this->get_field_id( 'offset' ); ?>"><?php _e( 'Post offset:', THEMENAME ); ?></label>
            <input id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" type="text" value="<?php echo $offset; ?>" size="3" /></p>

            <p>
                <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e('Select categories to include in your timeline:', THEMENAME);?> </label>

                    <?php
                        $categories=  get_categories('hide_empty=0');
                        echo "<br/>";
                        foreach ($categories as $cat) {
                            $option='<input type="checkbox" id="'. $this->get_field_id( 'cats' ) .'[]" name="'. $this->get_field_name( 'cats' ) .'[]"';
                            if (is_array($iCats)) {
                                foreach ($iCats as $cats) {
                                    if($cats==$cat->term_id) {
                                         $option=$option.' checked="checked"';
                                    }
                                }
                            }
                            $option .= ' value="'.$cat->term_id.'" />';
                            $option .= '&nbsp;';
                            $option .= $cat->cat_name;
                            $option .= '<br />';
                            echo $option;
                        }

                    ?>

            </p>

    <?php
        }
    }

}


if ( ! class_exists( 'MipTheme_AudioPosts_Widget' ) ) {

    class MipTheme_AudioPosts_Widget extends WP_Widget {

        function __construct() {
            $widget_ops = array('classname' => 'mp_audio_posts_widget', 'description' => __( "Your site&#8217;s most recent Audio Posts.", THEMENAME) );
            parent::__construct('mp_audio_posts_widget', __('WeeklyNews[Audio Posts]', THEMENAME), $widget_ops);
            $this->alt_option_name = 'mp_audio_posts_entries_widget';

            add_action( 'save_post', array($this, 'flush_widget_cache') );
            add_action( 'deleted_post', array($this, 'flush_widget_cache') );
            add_action( 'switch_theme', array($this, 'flush_widget_cache') );
        }

        function widget($args, $instance) {
            $cache = array();
            if ( ! $this->is_preview() ) {
                    $cache = wp_cache_get( 'mp_timeline_entries_widget', 'widget' );
            }

            if ( ! is_array( $cache ) ) {
                    $cache = array();
            }

            if ( ! isset( $args['widget_id'] ) ) {
                    $args['widget_id'] = $this->id;
            }

            if ( isset( $cache[ $args['widget_id'] ] ) ) {
                    echo $cache[ $args['widget_id'] ];
                    return;
            }

            ob_start();
            extract($args);

            $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Audio Posts', THEMENAME );

            /** This filter is documented in wp-includes/default-widgets.php */
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
            $offset = ( ! empty( $instance['offset'] ) ) ? absint( $instance['offset'] ) : 0;
            if ( ! $number ) $number    = 5;
            if ( ! $offset ) $offset    = 0;
            $no_margin_class  = ( isset( $instance['no_margin'] ) && (bool)$instance['no_margin']  ) ? ' no-bottom-margin' : '';

            /**
             * @param array $args An array of arguments used to retrieve the recent posts.
             */
            $r = new WP_Query( apply_filters( 'widget_posts_args', array(
                'posts_per_page'      => $number,
                'no_found_rows'       => true,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true,
                'offset'                => $offset,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'post_format',
                        'field'    => 'slug',
                        'terms'    => array( 'post-format-audio' ),
                    ),
            ),
            ) ) );

            if ($r->have_posts()) :
    ?>
                <?php echo '<aside class="widget module-singles'. $no_margin_class .'">'; ?>
                <?php if ( $title ) echo $before_title . $title . $after_title; ?>
                <!-- start:singles-container -->
                <ul class="singles-container">
                <?php
                    while ( $r->have_posts() ) :
                        $r->the_post();
                        $audio_title = MipTheme_Util::get_meta( '_mp_featured_audio_title', $r->post->ID, '' );
                        $audio_author = MipTheme_Util::get_meta( '_mp_featured_audio_author', $r->post->ID, '' );
                        if ( $audio_title != '' ) :
                ?>
                    <li>
                        <span class="glyphicon glyphicon-play-circle"></span>
                        <a href="<?php the_permalink(); ?>"><?php echo $audio_title; ?></a>
                        <?php if ( $audio_author != '' ) echo '<span class="author">'. $audio_author .'</span>'; ?>
                    </li>
                <?php
                        endif;
                    endwhile;
                ?>
                </ul>
                <!-- end:singles-container -->
                <?php echo '</aside>'; ?>
    <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

            endif;

            if ( ! $this->is_preview() ) {
                $cache[ $args['widget_id'] ] = ob_get_flush();
                wp_cache_set( 'mp_audio_posts_entries_widget', $cache, 'widget' );
            } else {
                ob_end_flush();
            }
        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['number'] = (int) $new_instance['number'];
            $instance['offset'] = (int) $new_instance['offset'];
            $instance['no_margin'] = isset( $new_instance['no_margin'] ) ? (bool) $new_instance['no_margin'] : false;
            $this->flush_widget_cache();

            $alloptions = wp_cache_get( 'alloptions', 'options' );
            if ( isset($alloptions['mp_audio_posts_entries_widget']) )
                    delete_option('mp_audio_posts_entries_widget');

            return $instance;
        }

        function flush_widget_cache() {
            wp_cache_delete('mp_audio_posts_entries_widget', 'widget');
        }

        function form( $instance ) {
            $title          = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
            $number         = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
            $offset         = isset( $instance['offset'] ) ? absint( $instance['offset'] ) : 0;
            $nomargin       = isset( $instance['no_margin'] ) ? (bool) $instance['no_margin'] : false;
    ?>
            <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEMENAME ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', THEMENAME ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

            <p><label for="<?php echo $this->get_field_id( 'offset' ); ?>"><?php _e( 'Post offset:', THEMENAME ); ?></label>
            <input id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" type="text" value="<?php echo $offset; ?>" size="3" /></p>

            <p><input class="checkbox" type="checkbox" <?php checked( $nomargin ); ?> id="<?php echo $this->get_field_id( 'no_margin' ); ?>" name="<?php echo $this->get_field_name( 'no_margin' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'no_margin' ); ?>"><?php _e( 'No spacing after this widget', THEMENAME ); ?></label></p>

    <?php
        }
    }

}


if ( ! class_exists( 'MipTheme_Gallery_Widget' ) ) {

    class MipTheme_Gallery_Widget extends WP_Widget {

        const THUMB_SIZE 		= 45;

        function __construct() {
            $widget_ops = array('classname' => 'mp_gallery_widget', 'description' => __( "Your site&#8217;s most recent Audio Posts.", THEMENAME) );
            parent::__construct('mp_gallery_widget', __('WeeklyNews[Gallery]', THEMENAME), $widget_ops);
            $this->alt_option_name = 'mp_gallery_entries_widget';

            add_action( 'admin_init', array( $this, 'admin_init' ) );
            add_action( 'save_post', array($this, 'flush_widget_cache') );
            add_action( 'deleted_post', array($this, 'flush_widget_cache') );
            add_action( 'switch_theme', array($this, 'flush_widget_cache') );
        }

        public function defaults() {
            return array(
                'title'		=> '',
                'ids'		=> ''
            );
        }

        function widget($args, $instance) {
            $cache = array();
            if ( ! $this->is_preview() ) {
                    $cache = wp_cache_get( 'mp_timeline_entries_widget', 'widget' );
            }

            if ( ! is_array( $cache ) ) {
                    $cache = array();
            }

            if ( ! isset( $args['widget_id'] ) ) {
                    $args['widget_id'] = $this->id;
            }

            if ( isset( $cache[ $args['widget_id'] ] ) ) {
                    echo $cache[ $args['widget_id'] ];
                    return;
            }

            ob_start();
            extract($args);

            $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Gallery Thumbs', THEMENAME );

            /** This filter is documented in wp-includes/default-widgets.php */
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            $attachments = $this->get_attachments( $instance );
            if ($attachments) {
                $count = 0;

                echo '<aside class="widget module-photos">';
                if ( $title ) echo $before_title . $title . $after_title;
                echo '  <div id="weekly-gallery" class="weekly-gallery article-container">';
                echo '      <div class="row">';

                foreach( $attachments as $attachment ){
                    $post_thumb_first_format    = array(300,200);

                    $att_img_src_thumb_first    = wp_get_attachment_image_src( $attachment->ID, $post_thumb_first_format);
                    $att_img_src_thumb          = wp_get_attachment_image_src( $attachment->ID, 'post-thumb-7');
                    $att_img_src_zoom           = wp_get_attachment_image_src( $attachment->ID, 'full');

                    $url_thumb_first            = $att_img_src_thumb_first[0];
                    $url_thumb                  = $att_img_src_thumb[0];
                    $url_zoom                   = $att_img_src_zoom[0];

                    if ($count == 0) {
                        echo '          <article class="clearfix">';
                        echo '              <a href="'. esc_url($url_zoom) .'" title="'. esc_attr( $attachment->post_title ) .'"><img src="'. $url_thumb_first .'" width="300" height="209" alt="'. esc_attr( $attachment->post_title ) .'" class="img-responsive"><div class="zoomix"><i class="fa fa-search"></i></div></a>';
                        echo '          </article>';
                        echo '      </div>';
                        echo '      <div class="row">';
                    } else {
                        echo '      <div class="col-xs-4">';
                        echo '          <article class="clearfix">';
                        echo '              <a href="'. esc_url($url_zoom) .'" title="'. esc_attr( $attachment->post_title ) .'"><img src="'. $url_thumb .'" width="100" height="80" alt="'. esc_attr( $attachment->post_title ) .'" class="img-responsive"><div class="zoomix"><i class="fa fa-search"></i></div></a>';
                        echo '          </article>';
                        echo '      </div>';
                    }
                    $count++;
                }

                echo '      </div>';
                echo '  </div>';
                echo '</aside>';
            }

            if ( ! $this->is_preview() ) {
                $cache[ $args['widget_id'] ] = ob_get_flush();
                wp_cache_set( 'mp_gallery_entries_widget', $cache, 'widget' );
            } else {
                ob_end_flush();
            }
        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['ids'] = $new_instance['ids'];

            $this->flush_widget_cache();

            $alloptions = wp_cache_get( 'alloptions', 'options' );
            if ( isset($alloptions['mp_gallery_entries_widget']) )
                    delete_option('mp_gallery_entries_widget');

            return $instance;
        }

        function flush_widget_cache() {
            wp_cache_delete('mp_gallery_entries_widget', 'widget');
        }

        function form( $instance ) {
            $defaults 	= $this->defaults();
            $instance 	= wp_parse_args( (array) $instance, $defaults );
    ?>
            <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEMENAME ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>

            <p><label><?php _e( 'Images:', THEMENAME ); ?></label></p>
            <div class="mp-gallery-widget-thumbs">
            <?php
                // Add the thumbnails to the widget box
                $attachments = $this->get_attachments( $instance );

                foreach( $attachments as $attachment ){
                    $url = add_query_arg( array(
                            'w' 	=> self::THUMB_SIZE,
                            'h' 	=> self::THUMB_SIZE,
                            'crop'	=> 'true'
                    ), wp_get_attachment_url( $attachment->ID ) );
            ?>
                    <img src="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( $attachment->post_title ); ?>" alt="<?php echo esc_attr( $attachment->post_title ); ?>"
                            width="<?php echo self::THUMB_SIZE; ?>" height="<?php echo self::THUMB_SIZE; ?>" style="display:inline-block;border: 1px solid #aaa;padding: 2px;background-color: #fff;margin: 0 6px 6px 0;" />
            <?php } ?>
            </div>
            <p>
                <a class="button mp-gallery-choose-images"><?php _e( 'Choose Images', THEMENAME ); ?></a>
            </p>
            <input type="hidden" class="mp-gallery-widget-ids" name="<?php echo $this->get_field_name( 'ids' ); ?>" id="<?php echo $this->get_field_id( 'ids' ); ?>" value="<?php echo esc_attr( $instance['ids'] ); ?>" />

    <?php
        }

        // Fetch the images attached to the gallery Widget
        public function get_attachments( $instance ){
            $ids = explode( ',', $instance['ids'] );

            $attachments_query = new WP_Query( array(
                'post__in' 			=> $ids,
                'post_status' 		=> 'inherit',
                'post_type' 		=> 'attachment',
                'post_mime_type' 	=> 'image',
                'posts_per_page'	=> -1
            ) );

            $attachments = $attachments_query->get_posts();

            wp_reset_postdata();

            return $attachments;
        }


        public function admin_init() {
            global $pagenow;

            if ( 'widgets.php' == $pagenow ) {
                wp_enqueue_media();

                wp_enqueue_script( 'mp-gallery-widget-admin', get_template_directory_uri() . '/inc/js/admin.js', array(
                    'media-models',
                    'media-views'
                ) );

                $js_settings = array(
                    'thumbSize' => self::THUMB_SIZE
                );

                wp_localize_script( 'mp-gallery-widget-admin', '_wpGalleryWidgetAdminSettings', $js_settings );
            }
        }

    }

}


if ( ! class_exists( 'MipTheme_Reviews_Widget' ) ) {

    class MipTheme_Reviews_Widget extends WP_Widget {

        function __construct() {
            $widget_ops = array('classname' => 'mp_reviews_widget', 'description' => __( "Your site&#8217;s lates reviews.", THEMENAME) );
            parent::__construct('mp_reviews_widget', __('WeeklyNews[Reviews]', THEMENAME), $widget_ops);
            $this->alt_option_name = 'mp_reviews_widget_widget';

            add_action( 'save_post', array($this, 'flush_widget_cache') );
            add_action( 'deleted_post', array($this, 'flush_widget_cache') );
            add_action( 'switch_theme', array($this, 'flush_widget_cache') );
        }

        function widget($args, $instance) {

            global $post;

            extract($args);

            $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Latest Reviews', THEMENAME );

            /** This filter is documented in wp-includes/default-widgets.php */
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
            $include_categories = ( ! empty( $instance['include_categories'] ) ) ? $instance['include_categories'] : '';
            $exclude_categories =( ! empty( $instance['exclude_categories'] ) ) ? $instance['exclude_categories'] : '';
            $include_tags       = ( ! empty( $instance['include_tags'] ) ) ? $instance['include_tags'] : '';

            $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
            $offset = ( ! empty( $instance['offset'] ) ) ? absint( $instance['offset'] ) : 0;
            if ( ! $number ) $number = 5;
            if ( ! $offset ) $offset = 0;
            $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
            $show_category = isset( $instance['show_category'] ) ? $instance['show_category'] : false;
            $mid_column = isset( $instance['mid_column'] ) ? $instance['mid_column'] : false;
            $sort_reviews = isset( $instance['sort_reviews'] ) ? $instance['sort_reviews'] : 'meta_value_num';

            /**
             * @param array $args An array of arguments used to retrieve the recent posts.
             */

            $args1 = array(
                'posts_per_page'      => $number,
                'no_found_rows'       => true,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true,
                'tag'                   => $include_tags,
                'orderby' => $sort_reviews,
                'offset'      => $offset,
                'meta_key' => '_mp_review_post_total_score'
            );

            $args2  = array();
            if ($include_categories) {
                //$include_categories = explode(",", $include_categories);
                $args2 = array(
                    'cat'      => $include_categories
                );
            }

            $args3  = array();
            if ($exclude_categories) {
                $exclude_categories = explode(",", $exclude_categories);
                $args3 = array(
                    'category__not_in'      => $exclude_categories
                );
            }

            $args   = array_merge($args1, $args2, $args3);

            $r = new WP_Query( apply_filters( 'widget_posts_args', $args ) );

            if ($r->have_posts()) :
    ?>
                <?php echo '<aside class="module-news module-reviews">'; ?>
                <?php if ( $title ) echo $before_title . $title . $after_title; ?>
                <!-- start:article-container -->
                <div class="article-container">
                <?php
                    while ( $r->have_posts() ) :
                        $r->the_post();

                        if ( $mid_column ) :
                            $img_thumb          = array(159,127);
                            $img_width          = '159';
                            $img_height         = '127';
                        else :
                            $img_thumb          =  'post-thumb-7';
                            $img_width          = '100';
                            $img_height         = '80';
                        endif;

                        $att_img_src        = wp_get_attachment_image_src( get_post_thumbnail_id(), $img_thumb);
                        $curr_post_img      = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( '100x80_2' );
                        $category           = get_the_category();
                ?>
                    <!-- start:article -->
                    <article class="clearfix">
                        <?php if ( MipTheme_Util::noDummyImage( $curr_post_img ) ) : ?><a href="<?php the_permalink(); ?>"><?php echo MipTheme_Util::setImage($curr_post_img, get_the_title(), $img_width, $img_height, ''); ?></a><?php endif; ?>
                        <span class="published">
                            <?php
                                if ( $show_date ) : echo get_the_date( MIPTHEME_DATE_SIDEBAR ); endif;
                                if ( $category && $show_category ) : echo '<span class="category cat-' . $category[0]->cat_ID . ' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($category[0]->cat_ID)) .'"><a href="' . get_category_link( $category[0]->term_id ) . '">' . $category[0]->name.'</a></span>'; endif;
                            ?>
                        </span>
                        <h3><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h3>
                        <span class="stars"><span style="width:<?php echo round(redux_post_meta('mp_weeklynews', $post->ID, '_mp_review_post_total_score')); ?>%"></span></span>
                    </article>
                    <!-- end:article -->
                <?php
                    endwhile;
                ?>
                </div>
                <!-- end:article-container -->
                <?php echo '</aside>'; ?>

    <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

            endif;

        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['include_categories'] = strip_tags($new_instance['include_categories']);
            $instance['exclude_categories'] = strip_tags($new_instance['exclude_categories']);
            $instance['include_tags'] = strip_tags($new_instance['include_tags']);
            $instance['number'] = (int) $new_instance['number'];
            $instance['offset'] = (int) $new_instance['offset'];
            $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
            //$instance['show_images'] = isset( $new_instance['show_images'] ) ? (bool) $new_instance['show_images'] : false;
            $instance['show_category'] = isset( $new_instance['show_category'] ) ? (bool) $new_instance['show_category'] : false;
            $instance['mid_column'] = isset( $new_instance['mid_column'] ) ? (bool) $new_instance['mid_column'] : false;
            $instance['sort_reviews'] = $new_instance['sort_reviews'];

            $this->flush_widget_cache();

            $alloptions = wp_cache_get( 'alloptions', 'options' );
            if ( isset($alloptions['mp_reviews_widget_widget']) )
                    delete_option('mp_reviews_widget_widget');

            return $instance;
        }

        function flush_widget_cache() {
            wp_cache_delete('mp_reviews_widget_widget', 'widget');
        }

        function form( $instance ) {
            $title              = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
            $include_categories = isset( $instance['include_categories'] ) ? esc_attr( $instance['include_categories'] ) : '';
            $exclude_categories = isset( $instance['exclude_categories'] ) ? esc_attr( $instance['exclude_categories'] ) : '';
            $include_tags       = isset( $instance['include_tags'] ) ? esc_attr( $instance['include_tags'] ) : '';
            $number             = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
            $offset             = isset( $instance['offset'] ) ? absint( $instance['offset'] ) : 0;
            $show_date          = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
            //$show_images        = isset( $instance['show_images'] ) ? (bool) $instance['show_images'] : false;
            $show_category      = isset( $instance['show_category'] ) ? (bool) $instance['show_category'] : false;
            $mid_column         = isset( $instance['mid_column'] ) ? (bool) $instance['mid_column'] : false;
            $sort_reviews       = isset( $instance['sort_reviews'] ) ? esc_attr( $instance['sort_reviews'] ) : 'meta_value_num';

    ?>
            <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEMENAME ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p><label for="<?php echo $this->get_field_id( 'include_categories' ); ?>"><?php _e( 'Include categories (separate by commas):', THEMENAME ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'include_categories' ); ?>" name="<?php echo $this->get_field_name( 'include_categories' ); ?>" type="text" value="<?php echo $include_categories; ?>" /></p>

            <p><label for="<?php echo $this->get_field_id( 'exclude_categories' ); ?>"><?php _e( 'Exclude categories (separate by commas):', THEMENAME ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'exclude_categories' ); ?>" name="<?php echo $this->get_field_name( 'exclude_categories' ); ?>" type="text" value="<?php echo $exclude_categories; ?>" /></p>

            <p><label for="<?php echo $this->get_field_id( 'include_tags' ); ?>"><?php _e( 'Include tags (separate tag slugs by commas):', THEMENAME ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'include_tags' ); ?>" name="<?php echo $this->get_field_name( 'include_tags' ); ?>" type="text" value="<?php echo $include_tags; ?>" /></p>

            <p>
                <label for="<?php echo $this->get_field_id('sort_reviews'); ?>"><?php _e( 'Sort reviews by:', THEMENAME ); ?>
                    <select class='widefat' id="<?php echo $this->get_field_id('sort_reviews'); ?>" name="<?php echo $this->get_field_name('sort_reviews'); ?>" type="text">
                        <option value='meta_value_num'<?php echo ($sort_reviews=='meta_value_num')?'selected':''; ?>><?php _e( 'Best Score Reviews', THEMENAME ); ?></option>
                        <option value='date'<?php echo ($sort_reviews=='date')?'selected':''; ?>><?php _e( 'Latest reviews', THEMENAME ); ?></option>
                    </select>
                </label>
            </p>

            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', THEMENAME ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

            <p><label for="<?php echo $this->get_field_id( 'offset' ); ?>"><?php _e( 'Post offset:', THEMENAME ); ?></label>
            <input id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" type="text" value="<?php echo $offset; ?>" size="3" /></p>

            <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', THEMENAME ); ?></label></p>

            <p><input class="checkbox" type="checkbox" <?php checked( $show_category ); ?> id="<?php echo $this->get_field_id( 'show_category' ); ?>" name="<?php echo $this->get_field_name( 'show_category' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_category' ); ?>"><?php _e( 'Display category?', THEMENAME ); ?></label></p>

            <p><input class="checkbox" type="checkbox" <?php checked( $mid_column ); ?> id="<?php echo $this->get_field_id( 'mid_column' ); ?>" name="<?php echo $this->get_field_name( 'mid_column' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'mid_column' ); ?>"><?php _e( 'Style it for mid column?', THEMENAME ); ?></label></p>

    <?php
        }
    }

}


if ( ! class_exists( 'MipTheme_About_Widget' ) ) {

    class MipTheme_About_Widget extends WP_Widget {

        function __construct() {
            parent::__construct(
                'mp_about_widget', // Base ID
                __('WeeklyNews[About]', THEMENAME), // Name
                array( 'description' => __( 'Display text with social share buttons', THEMENAME ), ) // Args
            );
        }

        public function widget( $args, $instance ) {
            $title          = apply_filters( 'widget_title', $instance['title'] );
            $about_text           = apply_filters( 'widget_about_text', $instance['about_text'] );
            $link_facebook   = apply_filters( 'widget_link_facebook', $instance['link_facebook'] );
            $link_twitter   = apply_filters( 'widget_link_twitter', $instance['link_twitter'] );
            $link_linkedin   = apply_filters( 'widget_link_linkedin', $instance['link_linkedin'] );
            $link_googleplus   = apply_filters( 'widget_link_googleplus', $instance['link_googleplus'] );
            $link_vimeo   = apply_filters( 'widget_link_vimeo', $instance['link_vimeo'] );
            $link_youtube   = apply_filters( 'widget_link_youtube', $instance['link_youtube'] );

            echo '<aside class="widget module-about">';
            if ( ! empty( $title ) ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }
            if ( ! empty( $about_text ) ) echo '<p>'. $about_text .'</p>';
            if ( ! empty( $link_twitter ) ) echo '<a href="'. esc_url($link_twitter) .'" target="_blank"><i class="fa fa-twitter fa-lg"></i></a>';
            if ( ! empty( $link_facebook ) ) echo '<a href="'. esc_url($link_facebook) .'" target="_blank"><i class="fa fa-facebook-square fa-lg"></i></a>';
            if ( ! empty( $link_linkedin ) ) echo '<a href="'. esc_url($link_linkedin) .'" target="_blank"><i class="fa fa-linkedin-square fa-lg"></i></a>';
            if ( ! empty( $link_googleplus ) ) echo '<a href="'. esc_url($link_googleplus) .'" target="_blank"><i class="fa fa-google-plus-square fa-lg"></i></a>';
            if ( ! empty( $link_vimeo ) ) echo '<a href="'. esc_url($link_vimeo) .'" target="_blank"><i class="fa fa-vimeo-square fa-lg"></i></a>';
            if ( ! empty( $link_youtube ) ) echo '<a href="'. esc_url($link_youtube) .'" target="_blank"><i class="fa fa-youtube fa-lg"></i></a>';

            echo '</aside>';
        }

        public function form( $instance ) {
            if ( isset( $instance[ 'title' ] ) ) { $title = $instance[ 'title' ];       } else { $title = __( 'About us...', THEMENAME ); }
            if ( isset( $instance[ 'about_text' ] ) ) { $about_text = $instance[ 'about_text' ];       } else { $about_text = ''; }
            if ( isset( $instance[ 'link_facebook' ] ) ) { $link_facebook = $instance[ 'link_facebook' ];       } else { $link_facebook = ''; }
            if ( isset( $instance[ 'link_twitter' ] ) ) { $link_twitter = $instance[ 'link_twitter' ];       } else { $link_twitter = ''; }
            if ( isset( $instance[ 'link_linkedin' ] ) ) { $link_linkedin = $instance[ 'link_linkedin' ];       } else { $link_linkedin = ''; }
            if ( isset( $instance[ 'link_googleplus' ] ) ) { $link_googleplus = $instance[ 'link_googleplus' ];       } else { $link_googleplus = ''; }
            if ( isset( $instance[ 'link_vimeo' ] ) ) { $link_vimeo = $instance[ 'link_vimeo' ];       } else { $link_vimeo = ''; }
            if ( isset( $instance[ 'link_youtube' ] ) ) { $link_youtube = $instance[ 'link_youtube' ];       } else { $link_youtube = ''; }
            ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEMENAME ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'about_text' ); ?>"><?php _e( 'Text:', THEMENAME ); ?></label>
                <textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'about_text' ); ?>" name="<?php echo $this->get_field_name( 'about_text' ); ?>"><?php echo esc_attr( $about_text ); ?></textarea>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'link_facebook' ); ?>"><?php _e( 'Facebook Link:', THEMENAME ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'link_facebook' ); ?>" name="<?php echo $this->get_field_name( 'link_facebook' ); ?>" type="text" value="<?php echo esc_attr( $link_facebook ); ?>">

                <label for="<?php echo $this->get_field_id( 'link_twitter' ); ?>"><?php _e( 'Twitter Link:', THEMENAME ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'link_twitter' ); ?>" name="<?php echo $this->get_field_name( 'link_twitter' ); ?>" type="text" value="<?php echo esc_attr( $link_twitter ); ?>">

                <label for="<?php echo $this->get_field_id( 'link_linkedin' ); ?>"><?php _e( 'LinkedIn Link:', THEMENAME ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'link_linkedin' ); ?>" name="<?php echo $this->get_field_name( 'link_linkedin' ); ?>" type="text" value="<?php echo esc_attr( $link_linkedin ); ?>">

                <label for="<?php echo $this->get_field_id( 'link_googleplus' ); ?>"><?php _e( 'Google+ Link:', THEMENAME ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'link_googleplus' ); ?>" name="<?php echo $this->get_field_name( 'link_googleplus' ); ?>" type="text" value="<?php echo esc_attr( $link_googleplus ); ?>">

                <label for="<?php echo $this->get_field_id( 'link_vimeo' ); ?>"><?php _e( 'Vimeo Link:', THEMENAME ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'link_vimeo' ); ?>" name="<?php echo $this->get_field_name( 'link_vimeo' ); ?>" type="text" value="<?php echo esc_attr( $link_vimeo ); ?>">

                <label for="<?php echo $this->get_field_id( 'link_youtube' ); ?>"><?php _e( 'Youtube Link:', THEMENAME ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'link_youtube' ); ?>" name="<?php echo $this->get_field_name( 'link_youtube' ); ?>" type="text" value="<?php echo esc_attr( $link_youtube ); ?>">
            </p>
            <?php
        }

        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

            if ( current_user_can('unfiltered_html') )
    			$instance['about_text'] =  $new_instance['about_text'];
    		else
    			$instance['about_text'] = wp_kses_post( stripslashes( $new_instance['about_text'] ) );
            //$instance['about_text'] = ( ! empty( $new_instance['about_text'] ) ) ? strip_tags( $new_instance['about_text'] ) : '';
            $instance['link_facebook'] = ( ! empty( $new_instance['link_facebook'] ) ) ? strip_tags( $new_instance['link_facebook'] ) : '';
            $instance['link_twitter'] = ( ! empty( $new_instance['link_twitter'] ) ) ? strip_tags( $new_instance['link_twitter'] ) : '';
            $instance['link_linkedin'] = ( ! empty( $new_instance['link_linkedin'] ) ) ? strip_tags( $new_instance['link_linkedin'] ) : '';
            $instance['link_googleplus'] = ( ! empty( $new_instance['link_googleplus'] ) ) ? strip_tags( $new_instance['link_googleplus'] ) : '';
            $instance['link_vimeo'] = ( ! empty( $new_instance['link_vimeo'] ) ) ? strip_tags( $new_instance['link_vimeo'] ) : '';
            $instance['link_youtube'] = ( ! empty( $new_instance['link_youtube'] ) ) ? strip_tags( $new_instance['link_youtube'] ) : '';

            return $instance;
        }

    }

}


if ( ! class_exists( 'MipTheme_RelatedPosts_Widget' ) ) {

    class MipTheme_RelatedPosts_Widget extends WP_Widget {

        function __construct() {
            $widget_ops = array('classname' => 'mp_related_entries_widget', 'description' => __( "Your site&#8217;s related Posts.", THEMENAME) );
            parent::__construct('mp_related_posts_widget', __('WeeklyNews[Related Posts]', THEMENAME), $widget_ops);
            $this->alt_option_name = 'mp_related_entries_widget';

            add_action( 'save_post', array($this, 'flush_widget_cache') );
            add_action( 'deleted_post', array($this, 'flush_widget_cache') );
            add_action( 'switch_theme', array($this, 'flush_widget_cache') );
        }

        function widget($args, $instance) {

            if ( !is_single() ) return;

            ob_start();
            extract($args);

            $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Related Posts', THEMENAME );

            /** This filter is documented in wp-includes/default-widgets.php */
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
            $filter_related = ( ! empty( $instance['filter_related'] ) ) ? $instance['filter_related'] : '';
            $sort_order     = ( ! empty( $instance['sort_order'] ) ) ? $instance['sort_order'] : '';

            $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
            $offset = ( ! empty( $instance['offset'] ) ) ? absint( $instance['offset'] ) : 0;
            if ( ! $number ) $number = 5;
            if ( ! $offset ) $offset = 0;
            $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
            //$show_images = isset( $instance['show_images'] ) ? $instance['show_images'] : false;
            $show_category = isset( $instance['show_category'] ) ? $instance['show_category'] : false;
            $show_mid_column = isset( $instance['show_mid_column'] ) ? $instance['show_mid_column'] : false;

            // set args
            $args = array();
            global $post;

            if ( $filter_related == 'category' ) {
                // if filter by cat
                $categories = get_the_category($post->ID);
                if ($categories) {
                    $category_ids = array();
                    foreach ($categories as $individual_category) $category_ids[] = $individual_category->term_id;
                    $args = array(
                        'category__in'          => $category_ids,
                        'post__not_in'          => array($post->ID),
                        'posts_per_page'        => $number,
                        'ignore_sticky_posts'   => 1,
                        'orderby'               => $sort_order,
                        'offset'                => $offset,
                        'meta_key'              => ( ($sort_order == 'meta_value_num') ? 'mip_post_views_count' : '' ),
                    );
                }
            } else {
                // if filter by tags
                $tags = wp_get_post_tags($post->ID);
                if ($tags) {
                    $tag_ids    = array();
                    foreach($tags as $individual_tag) {
                        $tag_ids[] = $individual_tag->term_id;
                    }
                    $args=array(
                        'tag__in'               => $tag_ids,
                        'post__not_in'          => array($post->ID),
                        'posts_per_page'        => $number,
                        'ignore_sticky_posts '  => 1,
                        'orderby'               => $sort_order,
                        'offset'                => $offset,
                        'meta_key'              => ( ($sort_order == 'meta_value_num') ? 'mip_post_views_count' : '' ),
                    );
                }
            }

            $r = new WP_Query( apply_filters( 'widget_posts_args', $args ) );

            if ($r->have_posts()) :
    ?>
                <?php echo '<aside class="module-news">'; ?>
                <?php if ( $title ) echo $before_title . $title . $after_title; ?>
                <!-- start:article-container -->
                <div class="article-container">
                <?php
                    while ( $r->have_posts() ) :
                        $r->the_post();

                        $att_img_src        = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumb-7');
                        $curr_post_img      = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( '100x80_2' );
                        $category           = get_the_category();
                        if ( $show_mid_column ) :
                ?>
                    <!-- start:article -->
                    <article class="clearfix">
                        <h3><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h3>
                        <span class="text"><?php echo MipTheme_Util::ShortenText(get_the_content(), 100); ?></span>
                        <span class="published">
                            <?php
                                if ( $show_date ) : echo get_the_date( MIPTHEME_DATE_SIDEBAR ); endif;
                                if ( $category && $show_category ) : echo ' in <span class="category cat-' . $category[0]->cat_ID . '"><a href="' . get_category_link( $category[0]->term_id ) . '">' . $category[0]->name.'</a></span>'; endif;
                            ?>
                        </span>
                    </article>
                    <!-- end:article -->
                <?php
                        else :
                ?>
                    <!-- start:article -->
                    <article class="clearfix">
                        <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($curr_post_img); ?>" width="25" height="20" alt=""></a>
                        <span class="published">
                            <?php
                                if ( $show_date ) : echo get_the_date( MIPTHEME_DATE_SIDEBAR ); endif;
                                if ( $category && $show_category ) : echo '<span class="category cat-' . $category[0]->cat_ID . ' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($category[0]->cat_ID)) .'"><a href="' . get_category_link( $category[0]->term_id ) . '">' . $category[0]->name.'</a></span>'; endif;
                            ?>
                        </span>
                        <a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
                    </article>
                    <!-- end:article -->
                <?php
                        endif;
                    endwhile;
                ?>
                </div>
                <!-- end:article-container -->
                <?php echo '</aside>'; ?>
    <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

            endif;


        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title']              = strip_tags($new_instance['title']);
            $instance['filter_related']     = strip_tags($new_instance['filter_related']);
            $instance['sort_order']         = strip_tags($new_instance['sort_order']);
            $instance['number']             = (int) $new_instance['number'];
            $instance['offset']             = (int) $new_instance['offset'];
            $instance['show_date']          = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
            //$instance['show_images'] = isset( $new_instance['show_images'] ) ? (bool) $new_instance['show_images'] : false;
            $instance['show_category']      = isset( $new_instance['show_category'] ) ? (bool) $new_instance['show_category'] : false;
            $instance['show_mid_column']    = isset( $new_instance['show_mid_column'] ) ? (bool) $new_instance['show_mid_column'] : false;

            $this->flush_widget_cache();

            $alloptions = wp_cache_get( 'alloptions', 'options' );
            if ( isset($alloptions['mp_related_entries_widget']) )
                    delete_option('mp_related_entries_widget');

            return $instance;
        }

        function flush_widget_cache() {
            wp_cache_delete('mp_related_entries_widget', 'widget');
        }

        function form( $instance ) {
            $title              = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
            $filter_related     = isset( $instance['filter_related'] ) ? esc_attr( $instance['filter_related'] ) : '';
            $sort_order         = isset( $instance['sort_order'] ) ? esc_attr( $instance['sort_order'] ) : '';
            $number             = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
            $offset             = isset( $instance['offset'] ) ? absint( $instance['offset'] ) : 0;
            $show_date          = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
            $show_category      = isset( $instance['show_category'] ) ? (bool) $instance['show_category'] : false;
            $show_mid_column    = isset( $instance['show_mid_column'] ) ? (bool) $instance['show_mid_column'] : false;
    ?>
            <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEMENAME ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p>
                <label for="<?php echo $this->get_field_id('filter_related'); ?>"><?php _e( 'Filter related posts by:', THEMENAME ); ?>
                    <select class='widefat' id="<?php echo $this->get_field_id('filter_related'); ?>" name="<?php echo $this->get_field_name('filter_related'); ?>" type="text">
                        <option value='category'<?php echo ($filter_related=='category')?'selected':''; ?>><?php _e( 'Category', THEMENAME ); ?></option>
                        <option value='tag'<?php echo ($filter_related=='tag')?'selected':''; ?>><?php _e( 'Tag', THEMENAME ); ?></option>
                    </select>
                </label>
            </p>

             <p>
                <label for="<?php echo $this->get_field_id('sort_order'); ?>"><?php _e( 'Sort order:', THEMENAME ); ?>
                    <select class='widefat' id="<?php echo $this->get_field_id('sort_order'); ?>" name="<?php echo $this->get_field_name('sort_order'); ?>" type="text">
                        <option value='date'<?php echo ($sort_order=='date')?'selected':''; ?>><?php _e( 'Latest', THEMENAME ); ?></option>
                        <option value='rand'<?php echo ($sort_order=='rand')?'selected':''; ?>><?php _e( 'Random posts', THEMENAME ); ?></option>
                        <option value='name'<?php echo ($sort_order=='name')?'selected':''; ?>><?php _e( 'By name', THEMENAME ); ?></option>
                        <option value='modified'<?php echo ($sort_order=='modified')?'selected':''; ?>><?php _e( 'Last Modified', THEMENAME ); ?></option>
                        <option value='comment_count'<?php echo ($sort_order=='comment_count')?'selected':''; ?>><?php _e( 'Most Commented', THEMENAME ); ?></option>
                        <option value='meta_value_num'<?php echo ($sort_order=='meta_value_num')?'selected':''; ?>><?php _e( 'Most Viewed', THEMENAME ); ?></option>
                    </select>
                </label>
            </p>

            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', THEMENAME ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

            <p><label for="<?php echo $this->get_field_id( 'offset' ); ?>"><?php _e( 'Post offset:', THEMENAME ); ?></label>
            <input id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" type="text" value="<?php echo $offset; ?>" size="3" /></p>

            <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', THEMENAME ); ?></label></p>

            <p><input class="checkbox" type="checkbox" <?php checked( $show_category ); ?> id="<?php echo $this->get_field_id( 'show_category' ); ?>" name="<?php echo $this->get_field_name( 'show_category' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_category' ); ?>"><?php _e( 'Display category?', THEMENAME ); ?></label></p>

            <p><input class="checkbox" type="checkbox" <?php checked( $show_mid_column ); ?> id="<?php echo $this->get_field_id( 'show_mid_column' ); ?>" name="<?php echo $this->get_field_name( 'show_mid_column' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_mid_column' ); ?>"><?php _e( 'Style it for mid column?', THEMENAME ); ?></label></p>
    <?php
        }
    }

}


if ( ! class_exists( 'MipTheme_Tags_Widget' ) ) {

    class MipTheme_Tags_Widget extends WP_Widget {

        function __construct() {
            parent::__construct(
                'mp_tags_widget', // Base ID
                __('WeeklyNews[Tags]', THEMENAME), // Name
                array( 'description' => __( 'Display tags', THEMENAME ), ) // Args
            );
        }

        public function widget( $args, $instance ) {
            $title                  = apply_filters( 'widget_title', $instance['title'] );
            $show_posts_count       = isset( $instance['show_posts_count'] ) ? $instance['show_posts_count'] : false;
            $number                 = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
            $html                   = '';

            echo '<aside class="widget module-tags">';
            if ( ! empty( $title ) ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }

            $args = array(
                'number'    => $number,
                'orderby'    => 'count',
                'order'    => 'DESC'
            );
            $tags = get_tags( $args );

            foreach ( $tags as $tag ) {
                $tag_link = get_tag_link( $tag->term_id );

                $html .= "<li><a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
                if ($show_posts_count) $html .= "<span>{$tag->count}</span> ";
                $html .= "{$tag->name}</a></li>";
            }
            echo '<ul class="tags">'. $html .'</ul>';
            echo '</aside>';
        }

        public function form( $instance ) {
            if ( isset( $instance[ 'title' ] ) ) { $title = $instance[ 'title' ];       } else { $title = __( 'Weekly Tags', THEMENAME ); }
            $show_posts_count           = isset( $instance['show_posts_count'] ) ? (bool) $instance['show_posts_count'] : false;
            $number                     = isset( $instance['number'] ) ? absint( $instance['number'] ) : 10;
            ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEMENAME ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p><input class="checkbox" type="checkbox" <?php checked( $show_posts_count ); ?> id="<?php echo $this->get_field_id( 'show_posts_count' ); ?>" name="<?php echo $this->get_field_name( 'show_posts_count' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_posts_count' ); ?>"><?php _e( 'Display post count?', THEMENAME ); ?></label></p>

            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of tags to show:', THEMENAME ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
            <?php
        }

        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title']              = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['show_posts_count']   = isset( $new_instance['show_posts_count'] ) ? (bool) $new_instance['show_posts_count'] : false;
            $instance['number']             = (int) $new_instance['number'];

            return $instance;
        }

    }

}



if ( ! class_exists( 'MipTheme_Author_Widget' ) ) {

    class MipTheme_Author_Widget extends WP_Widget {

        function __construct() {
            $widget_ops = array('classname' => 'mp_author_widget', 'description' => __( "Author&#8217;s most recent Posts.", THEMENAME) );
            parent::__construct('mp_author_widget', __('WeeklyNews[Authors posts]', THEMENAME), $widget_ops);
            $this->alt_option_name = 'mp_author_widget';

            add_action( 'save_post', array($this, 'flush_widget_cache') );
            add_action( 'deleted_post', array($this, 'flush_widget_cache') );
            add_action( 'switch_theme', array($this, 'flush_widget_cache') );
        }

        function widget($args, $instance) {

            ob_start();
            extract($args);

            $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( '', THEMENAME );

            /** This filter is documented in wp-includes/default-widgets.php */
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            $exclude_posts =( ! empty( $instance['exclude_posts'] ) ) ? $instance['exclude_posts'] : '';
            $sort_order     = ( ! empty( $instance['sort_order'] ) ) ? $instance['sort_order'] : '';

            $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
            $offset = ( ! empty( $instance['offset'] ) ) ? absint( $instance['offset'] ) : 0;
            if ( ! $number ) $number = 5;
            if ( ! $offset ) $offset = 0;
            $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
            $display_cats = isset( $instance['display_cats'] ) ? $instance['display_cats'] : 'root_category';
            $display_avatar = isset( $instance['display_avatar'] ) ? $instance['display_avatar'] : 'no-avatar';
            $select_author = isset( $instance['select_author'] ) ? $instance['select_author'] : 0;

            //$show_images = isset( $instance['show_images'] ) ? $instance['show_images'] : false;
            $show_views = isset( $instance['show_views'] ) ? $instance['show_views'] : false;
            $show_category = isset( $instance['show_category'] ) ? $instance['show_category'] : false;
            $show_mid_column = isset( $instance['show_mid_column'] ) ? $instance['show_mid_column'] : false;


            $title          = ( $title != '' ) ? '<em>'. $title .'</em>' : $title;
            $title          = $title . '<a href="'. get_author_posts_url($select_author) .'">'. get_the_author_meta( 'display_name', $select_author ) .'</a>';

            /**
             * Filter the arguments for the Recent Posts widget.
             *
             * @since 3.4.0
             *
             * @see WP_Query::get_posts()
             *
             * @param array $args An array of arguments used to retrieve the recent posts.
             */

            $args1 = array(
                'posts_per_page'        => $number,
                'author'                => $select_author,
                'no_found_rows'         => true,
                'post_status'           => 'publish',
                'offset'                => $offset,
                'ignore_sticky_posts'   => true,
                'orderby'               => $sort_order,
                'meta_key'              => ( ($sort_order == 'meta_value_num') ? 'mip_post_views_count' : '' )
            );

            $args2  = array();
            if ($exclude_posts) {
                $exclude_posts = explode(",", $exclude_posts);
                $args2 = array(
                    'post__not_in'      => $exclude_posts
                );
            }

            $args   = array_merge($args1, $args2);

            $r = new WP_Query( apply_filters( 'widget_posts_args', $args ) );

            if ($r->have_posts()) :
    ?>
                <aside class="module-news module-author <?php echo $display_avatar; ?>">
                <?php
                    if ($display_avatar == 'avatar-mid') echo '<div class="avatar-wrap"><a href="'. get_author_posts_url($select_author) .'">'. get_avatar($select_author, 85) .'</a></div>';
                    if ($display_avatar == 'avatar-right') echo '<a href="'. get_author_posts_url($select_author) .'">'. get_avatar($select_author, 55) .'</a>';

                    if ( $title ) echo $before_title . $title . $after_title;
                ?>
                <!-- start:article-container -->
                <div class="article-container">
                <?php
                    while ( $r->have_posts() ) :
                        $r->the_post();
                        $att_img_src    = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumb-7');
                        $curr_post_img  = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( '100x80_2' );
                        $category       = get_the_category();
                        if ( $show_mid_column ) :
                ?>
                    <!-- start:article -->
                    <article class="clearfix">
                        <?php
                            if ( $category && $show_category ) :
                                if ( $display_cats == 'root_category' ) :
                                    $curr_cat_id_tmp    = MipTheme_Util::get_category_top_parent_id($category[0]->term_id);
                                    $curr_cat_obj       = get_category($curr_cat_id_tmp);
                                    echo '<span class="category cat-' . $curr_cat_id_tmp . ' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($curr_cat_id_tmp)) .'"><a href="' . get_category_link( $curr_cat_id_tmp ) . '">'. $curr_cat_obj->name .'</a></span>';
                                else :
                                    echo '<span class="category cat-' . $category[0]->cat_ID . ' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($category[0]->cat_ID)) .'"><a href="' . get_category_link( $category[0]->term_id ) . '">'. $category[0]->name .'</a></span>';
                                endif;
                            endif;
                        ?>
                        <h3><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h3>
                        <span class="published">
                            <?php
                                if ( $show_date ) : echo '<span class="icon fa-calendar" itemprop="dateCreated">'. get_the_date( MIPTHEME_DATE_SIDEBAR ) .'</span>'; endif;
                                if ( $show_views ) : echo '<span class="icon fa-eye">'. MipTheme_Post_Views::get_post_views(get_the_ID()) .'</span>'; endif;
                            ?>
                        </span>
                    </article>
                    <!-- end:article -->
                <?php
                        else :
                ?>
                    <!-- start:article -->
                    <article class="clearfix">
                        <?php if ( MipTheme_Util::noDummyImage( $curr_post_img ) ) : ?><a href="<?php the_permalink(); ?>"><?php echo MipTheme_Util::setImage($curr_post_img, get_the_title(), 100, 80, ''); ?></a><?php endif; ?>
                        <?php
                            if ( $category && $show_category ) :
                                if ( $display_cats == 'root_category' ) :
                                    $curr_cat_id_tmp    = MipTheme_Util::get_category_top_parent_id($category[0]->term_id);
                                    $curr_cat_obj       = get_category($curr_cat_id_tmp);
                                    echo '<span class="category cat-' . $curr_cat_id_tmp . ' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($curr_cat_id_tmp)) .'"><a href="' . get_category_link( $curr_cat_id_tmp ) . '">'. $curr_cat_obj->name .'</a></span>';
                                else :
                                    echo '<span class="category cat-' . $category[0]->cat_ID . ' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($category[0]->cat_ID)) .'"><a href="' . get_category_link( $category[0]->term_id ) . '">'. $category[0]->name .'</a></span>';
                                endif;
                            endif;
                        ?>
                        <h3><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h3>
                        <span class="published">
                            <?php
                                if ( $show_date ) : echo '<span class="icon fa-calendar" itemprop="dateCreated">'. get_the_date( MIPTHEME_DATE_SIDEBAR ) .'</span>'; endif;
                                if ( $show_views ) : echo '<span class="icon fa-eye">'. MipTheme_Post_Views::get_post_views(get_the_ID()) .'</span>'; endif;
                            ?>
                        </span>
                    </article>
                    <!-- end:article -->
                <?php
                        endif;
                    endwhile;
                ?>
                </div>
                <!-- end:article-container -->
                <?php echo '</aside>'; ?>
    <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

            endif;

        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['exclude_posts'] = strip_tags($new_instance['exclude_posts']);
            $instance['number'] = (int) $new_instance['number'];
            $instance['offset'] = (int) $new_instance['offset'];
            $instance['sort_order']         = strip_tags($new_instance['sort_order']);
            $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
            $instance['display_cats'] = $new_instance['display_cats'];
            $instance['display_avatar'] = $new_instance['display_avatar'];
            $instance['select_author'] = $new_instance['select_author'];

            //$instance['show_images'] = isset( $new_instance['show_images'] ) ? (bool) $new_instance['show_images'] : false;
            $instance['show_views'] = isset( $new_instance['show_views'] ) ? (bool) $new_instance['show_views'] : false;
            $instance['show_category'] = isset( $new_instance['show_category'] ) ? (bool) $new_instance['show_category'] : false;
            $instance['show_mid_column'] = isset( $new_instance['show_mid_column'] ) ? (bool) $new_instance['show_mid_column'] : false;

            $this->flush_widget_cache();

            $alloptions = wp_cache_get( 'alloptions', 'options' );
            if ( isset($alloptions['mp_author_widget']) )
                    delete_option('mp_author_widget');

            return $instance;
        }

        function flush_widget_cache() {
            wp_cache_delete('mp_author_widget', 'widget');
        }

        function form( $instance ) {
            global $mp_weeklynews;

            $title              = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
            $exclude_posts = isset( $instance['exclude_posts'] ) ? esc_attr( $instance['exclude_posts'] ) : '';
            $number             = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
            $offset             = isset( $instance['offset'] ) ? absint( $instance['offset'] ) : 0;
            $show_date          = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
            $display_cats       = isset( $instance['display_cats'] ) ? esc_attr( $instance['display_cats'] ) : 'root_category';
            $display_avatar     = isset( $instance['display_avatar'] ) ? esc_attr( $instance['display_avatar'] ) : 'no-avatar';
            $select_author       = isset( $instance['select_author'] ) ? esc_attr( $instance['select_author'] ) : 0;
            //$show_images        = isset( $instance['show_images'] ) ? (bool) $instance['show_images'] : false;
            $show_views         = isset( $instance['show_views'] ) ? (bool) $instance['show_views'] : false;
            $show_category      = isset( $instance['show_category'] ) ? (bool) $instance['show_category'] : false;
            $show_mid_column    = isset( $instance['show_mid_column'] ) ? (bool) $instance['show_mid_column'] : false;
            $sort_order         = isset( $instance['sort_order'] ) ? esc_attr( $instance['sort_order'] ) : '';
            $authors_exclude    = $mp_weeklynews['_mp_authorteampage_exclude'];

            $args = array(
                'role' => 'Author',
                'exclude' => array( $authors_exclude ),
                'orderby' => 'display_name',
                'order' => 'DESC'
            );

            // The Query
            $user_query  = new WP_User_Query( $args );
            foreach ( $user_query->results as $user ) {

            }

    ?>
            <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEMENAME ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p>
                <label for="<?php echo $this->get_field_id('select_author'); ?>"><?php _e( 'Select author:', THEMENAME ); ?>
                    <select class='widefat' id="<?php echo $this->get_field_id('select_author'); ?>" name="<?php echo $this->get_field_name('select_author'); ?>" type="text">
                        <?php foreach ( $user_query->results as $user ) { ?>
                        <option value='<?php echo $user->ID; ?>'<?php echo ($select_author== $user->ID)?' selected':''; ?>><?php echo $user->display_name; ?></option>
                        <?php } ?>
                    </select>
                </label>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('display_avatar'); ?>"><?php _e( 'Display avatar as:', THEMENAME ); ?>
                    <select class='widefat' id="<?php echo $this->get_field_id('display_avatar'); ?>" name="<?php echo $this->get_field_name('display_avatar'); ?>" type="text">
                        <option value='no-avatar'<?php echo ($display_avatar=='no-avatar')?'selected':''; ?>><?php _e( 'No Avatar', THEMENAME ); ?></option>
                        <option value='avatar-mid'<?php echo ($display_avatar=='avatar-mid')?'selected':''; ?>><?php _e( 'Avatar on top', THEMENAME ); ?></option>
                        <option value='avatar-right'<?php echo ($display_avatar=='avatar-right')?'selected':''; ?>><?php _e( 'Avatar on right', THEMENAME ); ?></option>
                    </select>
                </label>
            </p>

            <p><label for="<?php echo $this->get_field_id( 'exclude_posts' ); ?>"><?php _e( 'Exclude posts (separate ID by commas):', THEMENAME ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'exclude_posts' ); ?>" name="<?php echo $this->get_field_name( 'exclude_posts' ); ?>" type="text" value="<?php echo $exclude_posts; ?>" /></p>

            <p>
                <label for="<?php echo $this->get_field_id('display_cats'); ?>"><?php _e( 'Display category as:', THEMENAME ); ?>
                    <select class='widefat' id="<?php echo $this->get_field_id('display_cats'); ?>" name="<?php echo $this->get_field_name('display_cats'); ?>" type="text">
                        <option value='root_category'<?php echo ($display_cats=='root_category')?'selected':''; ?>><?php _e( 'Root Category', THEMENAME ); ?></option>
                        <option value='all'<?php echo ($display_cats=='all')?'selected':''; ?>><?php _e( 'Subcategories', THEMENAME ); ?></option>
                    </select>
                </label>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('sort_order'); ?>"><?php _e( 'Sort order:', THEMENAME ); ?>
                    <select class='widefat' id="<?php echo $this->get_field_id('sort_order'); ?>" name="<?php echo $this->get_field_name('sort_order'); ?>" type="text">
                        <option value='date'<?php echo ($sort_order=='date')?'selected':''; ?>><?php _e( 'Latest', THEMENAME ); ?></option>
                        <option value='rand'<?php echo ($sort_order=='rand')?'selected':''; ?>><?php _e( 'Random posts', THEMENAME ); ?></option>
                        <option value='name'<?php echo ($sort_order=='name')?'selected':''; ?>><?php _e( 'By name', THEMENAME ); ?></option>
                        <option value='modified'<?php echo ($sort_order=='modified')?'selected':''; ?>><?php _e( 'Last Modified', THEMENAME ); ?></option>
                        <option value='comment_count'<?php echo ($sort_order=='comment_count')?'selected':''; ?>><?php _e( 'Most Commented', THEMENAME ); ?></option>
                        <option value='meta_value_num'<?php echo ($sort_order=='meta_value_num')?'selected':''; ?>><?php _e( 'Most Viewed', THEMENAME ); ?></option>
                    </select>
                </label>
            </p>

            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', THEMENAME ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

            <p><label for="<?php echo $this->get_field_id( 'offset' ); ?>"><?php _e( 'Post offset:', THEMENAME ); ?></label>
            <input id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" type="text" value="<?php echo $offset; ?>" size="3" /></p>

            <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', THEMENAME ); ?></label></p>

            <p><input class="checkbox" type="checkbox" <?php checked( $show_category ); ?> id="<?php echo $this->get_field_id( 'show_category' ); ?>" name="<?php echo $this->get_field_name( 'show_category' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_category' ); ?>"><?php _e( 'Display category?', THEMENAME ); ?></label></p>

            <p><input class="checkbox" type="checkbox" <?php checked( $show_views ); ?> id="<?php echo $this->get_field_id( 'show_views' ); ?>" name="<?php echo $this->get_field_name( 'show_views' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_views' ); ?>"><?php _e( 'Display post views?', THEMENAME ); ?></label></p>

            <p><input class="checkbox" type="checkbox" <?php checked( $show_mid_column ); ?> id="<?php echo $this->get_field_id( 'show_mid_column' ); ?>" name="<?php echo $this->get_field_name( 'show_mid_column' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_mid_column' ); ?>"><?php _e( 'Style it for mid column?', THEMENAME ); ?></label></p>
    <?php
            wp_reset_postdata();
        }
    }

}


if ( ! class_exists( 'MipTheme_Sorry_Box_Widget' ) ) {

    class MipTheme_Sorry_Box_Widget extends WP_Widget {

        function __construct() {
            parent::__construct(
                'mp_sorry_box_widget', // Base ID
                __('WeeklyNews[SorryBox]', THEMENAME), // Name
                array( 'description' => __( 'Display sorry box', THEMENAME ), ) // Args
            );
        }

        public function widget( $args, $instance ) {
            $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( '', THEMENAME );
            $message = ( ! empty( $instance['message'] ) ) ? $instance['message'] : __( '', THEMENAME );
            ?>
            <aside class="module-news">
                <div class="js-open-webtv-in-popup">
                    <div class="red-border-top"></div>
                    <div class="whitebox new-lastest-new-widget">
                        <h3>
                            <a id="" href="#"><?php echo $title;?></a>
                            <i class="icon-red-arrow-right"></i>
                        </h3>
                        <ul class="listwhite">
                            <li class="active">
                                <?php echo $message;?>
                            </li>
                        </ul>
                    </div>
                </div>

            </aside>

        <?php
        }
        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['message'] = strip_tags($new_instance['message']);

            $this->flush_widget_cache();

            $alloptions = wp_cache_get( 'alloptions', 'options' );
            if ( isset($alloptions['mp_sorry_box_widget']) )
                delete_option('mp_sorry_box_widget');

            return $instance;
        }

        function flush_widget_cache() {
            wp_cache_delete('mp_sorry_box_widget', 'widget');
        }

        function form( $instance ) {
            $title              = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
            $message = isset( $instance['message'] ) ? esc_attr( $instance['message'] ) : '';
            ?>
            <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEMENAME ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p>
                <label for="<?php echo $this->get_field_id( 'ad_source' ); ?>"><?php _e( 'Message:', THEMENAME ); ?></label>
                <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id( 'message' ); ?>" name="<?php echo $this->get_field_name( 'message' ); ?>"><?php echo esc_attr( $message ); ?></textarea>
            </p>

        <?php
        }

    }

}

if ( ! class_exists( 'MipTheme_MostReadPosts_Widget' ) ) {

    class MipTheme_MostReadPosts_Widget extends WP_Widget {

        function __construct() {
            $widget_ops = array('classname' => 'mp_most_read_entries_widget', 'description' => __( "Your site&#8217;s most read Posts.", THEMENAME) );
            parent::__construct('mp_most_read_posts_widget', __('WeeklyNews[Most Read Posts]', THEMENAME), $widget_ops);
            $this->alt_option_name = 'mp_most_read_entries_widget';

            add_action( 'save_post', array($this, 'flush_widget_cache') );
            add_action( 'deleted_post', array($this, 'flush_widget_cache') );
            add_action( 'switch_theme', array($this, 'flush_widget_cache') );
        }

        function widget($args, $instance) {

            ob_start();
            extract($args);

            $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Most Read Posts', THEMENAME );

            /** This filter is documented in wp-includes/default-widgets.php */
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
            $include_categories = ( ! empty( $instance['include_categories'] ) ) ? $instance['include_categories'] : '';
            $exclude_categories =( ! empty( $instance['exclude_categories'] ) ) ? $instance['exclude_categories'] : '';
            $include_tags       = ( ! empty( $instance['include_tags'] ) ) ? $instance['include_tags'] : '';
            $sort_order         = ( ! empty( $instance['sort_order'] ) ) ? $instance['sort_order'] : '';

            $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
            $offset = ( ! empty( $instance['offset'] ) ) ? absint( $instance['offset'] ) : 0;
            $text_limit = ( ! empty( $instance['text_limit'] ) ) ? absint( $instance['text_limit'] ) : 100;
            if ( ! $number ) $number = 5;
            if ( ! $offset ) $offset = 0;
            if ( ! $text_limit ) $text_limit = 100;
            $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
            $display_cats = isset( $instance['display_cats'] ) ? $instance['display_cats'] : 'root_category';
            $layout = isset( $instance['layout'] ) ? $instance['layout'] : 'layout_one';

            //$show_images = isset( $instance['show_images'] ) ? $instance['show_images'] : false;
            $show_views = isset( $instance['show_views'] ) ? $instance['show_views'] : 'no-views';
            $show_category = isset( $instance['show_category'] ) ? $instance['show_category'] : false;
            $show_mid_column = isset( $instance['show_mid_column'] ) ? $instance['show_mid_column'] : false;

            /**
             * Filter the arguments for the Recent Posts widget.
             *
             * @since 3.4.0
             *
             * @see WP_Query::get_posts()
             *
             * @param array $args An array of arguments used to retrieve the recent posts.
             */

            $args1 = array(
                'posts_per_page'        => $number,
                'no_found_rows'         => true,
                'post_status'           => 'publish',
                'offset'                => $offset,
                'ignore_sticky_posts'   => true,
                'tag'                   => $include_tags,
                'orderby'               => ( (in_array($sort_order, array('mip_post_views_count', '_mip_post_views_count_7_day_total', '_mip_post_views_count_24_hours_total'))) ? 'meta_value_num' : $sort_order ),
                'meta_key'              => ( (in_array($sort_order, array('mip_post_views_count', '_mip_post_views_count_7_day_total', '_mip_post_views_count_24_hours_total'))) ? $sort_order : '' )
            );

            $args2  = array();
            if ($include_categories) {
                //$include_categories = explode(",", $include_categories);
                $args2 = array(
                    'cat'      => $include_categories
                );
            }

            $args3  = array();
            if ($exclude_categories) {
                $exclude_categories = explode(",", $exclude_categories);
                $args3 = array(
                    'category__not_in'      => $exclude_categories
                );
            }

            $args   = array_merge($args1, $args2, $args3);

//            $r = new WP_Query( apply_filters( 'widget_posts_args', $args ) );
            $r = new WP_Query( array( 'posts_per_page' => $number, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC'  ) );

            if ($r->have_posts()) :
                ?>
                <?php echo '<aside class="module-news">'; ?>

                <div class="js-open-webtv-in-popup">
                    <div class="red-border-top"></div>
                    <div class="whitebox new-lastest-new-widget">
                        <h3>
                            <a id="" href="#"><?php echo $title ?></a>
                            <i class="icon-red-arrow-right"></i>
                        </h3>
                        <ul class="listwhite">
                            <?php
                            $post_counter   = 1;
                            while ( $r->have_posts() ) :
                                $r->the_post();
                                ?>
                                <li class="active">
                                    <a href="<?php the_permalink(); ?>" title="">
                                        <?php echo the_title()  ?>
                                    </a>
                                </li>
                                <?php
                                $post_counter++;
                            endwhile;
                            ?>
                        </ul>
                    </div>
                </div>

                <?php echo '</aside>'; ?>
                <?php
                // Reset the global $the_post as this query will have stomped on it
                wp_reset_postdata();

            endif;

        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['include_categories'] = strip_tags($new_instance['include_categories']);
            $instance['exclude_categories'] = strip_tags($new_instance['exclude_categories']);
            $instance['include_tags'] = strip_tags($new_instance['include_tags']);
            $instance['number'] = (int) $new_instance['number'];
            $instance['offset'] = (int) $new_instance['offset'];
            $instance['text_limit'] = (int) $new_instance['text_limit'];
            $instance['sort_order']         = strip_tags($new_instance['sort_order']);
            $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
            $instance['display_cats'] = $new_instance['display_cats'];
            $instance['layout'] = $new_instance['layout'];

            //$instance['show_images'] = isset( $new_instance['show_images'] ) ? (bool) $new_instance['show_images'] : false;
            $instance['show_views'] = strip_tags($new_instance['show_views']);
            $instance['show_category'] = isset( $new_instance['show_category'] ) ? (bool) $new_instance['show_category'] : false;
            $instance['show_mid_column'] = isset( $new_instance['show_mid_column'] ) ? (bool) $new_instance['show_mid_column'] : false;

            $this->flush_widget_cache();

            $alloptions = wp_cache_get( 'alloptions', 'options' );
            if ( isset($alloptions['mp_most_read_entries_widget']) )
                delete_option('mp_most_read_entries_widget');

            return $instance;
        }

        function flush_widget_cache() {
            wp_cache_delete('mp_most_read_entries_widget', 'widget');
        }

        function form( $instance ) {
            $title              = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
            $include_categories = isset( $instance['include_categories'] ) ? esc_attr( $instance['include_categories'] ) : '';
            $exclude_categories = isset( $instance['exclude_categories'] ) ? esc_attr( $instance['exclude_categories'] ) : '';
            $include_tags       = isset( $instance['include_tags'] ) ? esc_attr( $instance['include_tags'] ) : '';
            $number             = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
            $offset             = isset( $instance['offset'] ) ? absint( $instance['offset'] ) : 0;
            $text_limit         = isset( $instance['text_limit'] ) ? absint( $instance['text_limit'] ) : 100;
            $show_date          = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
            $layout             = isset( $instance['layout'] ) ? esc_attr( $instance['layout'] ) : 'layout_one';
            $display_cats       = isset( $instance['display_cats'] ) ? esc_attr( $instance['display_cats'] ) : 'root_category';
            //$show_images        = isset( $instance['show_images'] ) ? (bool) $instance['show_images'] : false;
            $show_views         = isset( $instance['show_views'] ) ? esc_attr($instance['show_views']) : 'no-views';
            $show_category      = isset( $instance['show_category'] ) ? (bool) $instance['show_category'] : false;
            $show_mid_column    = isset( $instance['show_mid_column'] ) ? (bool) $instance['show_mid_column'] : false;
            $sort_order         = isset( $instance['sort_order'] ) ? esc_attr( $instance['sort_order'] ) : '';
            ?>
            <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEMENAME ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', THEMENAME ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

    <?php
        }
    }

}
function miptheme_load_widgets() {
    register_widget( 'MipTheme_Img_Widget' );
    register_widget( 'MipTheme_AdsImg_Widget' );
    register_widget( 'MipTheme_AdsEmbed_Widget' );
    register_widget( 'MipTheme_AdsSystem_Widget' );
    register_widget( 'MipTheme_Quote_Widget' );
    register_widget( 'MipTheme_RecentPosts_Widget' );
    register_widget( 'MipTheme_Timeline_Widget' );
    register_widget( 'MipTheme_AudioPosts_Widget' );
    register_widget( 'MipTheme_Gallery_Widget' );
    register_widget( 'MipTheme_Reviews_Widget' );
    register_widget( 'MipTheme_About_Widget' );
    register_widget( 'MipTheme_RelatedPosts_Widget' );
    register_widget( 'MipTheme_Tags_Widget' );
    register_widget( 'MipTheme_Author_Widget' );
    register_widget( 'MipTheme_MostReadPosts_Widget' );
    register_widget( 'MipTheme_Sorry_Box_Widget' );

}
