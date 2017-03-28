<?php
/**
 * Theme by: MipThemes
 * http://themes.mipdesign.com
 *
 * Our portfolio: http://themeforest.net/user/mip/portfolio
 * Thanks for using our theme!
 */

if ( ! class_exists( 'MipTheme_Article' ) ) {

    class MipTheme_Article {

        // init var
        public $cat_ID;
        public $cat_name                = '';
        public $article_link            = '';
        public $article_title           = '';
        public $article_content         = '';
        public $article_more            = 0;
        public $article_thumb           = '';
        public $article_post_date       = '';
        public $article_comments_count  = '';
        public $article_comments_link   = '';
        public $article_review          = false;
        public $article_review_score    = 0;
        public $article_show_summary    = 0;
        public $article_show_cat_label  = 0;
        public $article_author          = '';
        public $article_author_url      = '';
        public $article_post_type       = 'standard';
        public $article_price           = '';
        public $article_add_to_cart     = false;
        public $article_no_ajax_call    = true;

        private function setCategoryLabel() {
            global $mp_weeklynews;
            $article_show_cat_label = ( isset($mp_weeklynews['_mp_posts_enable_image_categories']) && (bool)$mp_weeklynews['_mp_posts_enable_image_categories']) ? (bool)$mp_weeklynews['_mp_posts_enable_image_categories'] : false;
            $article_show_post_type = ( isset($mp_weeklynews['_mp_posts_enable_image_post_formats']) && (bool)$mp_weeklynews['_mp_posts_enable_image_post_formats']) ? (bool)$mp_weeklynews['_mp_posts_enable_image_post_formats'] : false;
            $article_post_type      = '';

            if ( $article_show_post_type ) {
                $article_post_type      = get_post_format( $this->article_link );
                switch ($article_post_type) {
                    case 'audio':
                        $article_post_type  = '<i class="fa fa-music"></i>';
                    break;
                    case 'video':
                        $article_post_type  = '<i class="fa fa-video-camera"></i>';
                    break;
                    case 'gallery':
                        $article_post_type  = '<i class="fa fa-picture-o"></i>';
                    break;
                    case 'image':
                        $article_post_type  = '<i class="fa fa-eye"></i>';
                    break;
                }
            }

            if ( $article_show_cat_label ) {
                return '<a href="'. get_category_link($this->cat_ID) .'" class="theme">'. $this->cat_name . $article_post_type .'</a>';
            }
        }

        private function setCategoryLabelSpan() {
            global $mp_weeklynews;
            $article_show_cat_label  = $mp_weeklynews['_mp_posts_enable_image_categories'];
            if ( $article_show_cat_label ) {
                return '<a href="'. get_category_link($this->cat_ID) .'" class="category">'. $this->cat_name .'</a>';
            }
        }

        private function getReviewScore() {
            //$this->article_review_score      = redux_post_meta('mp_weeklynews', $this->article_link, '_mp_review_post_total_score');
            $this->article_review_score      = get_post_meta( $this->article_link, '_mp_review_post_total_score', true );
            if ( isset($this->article_review_score) && ($this->article_review_score != '') ) {
                return round($this->article_review_score);
            }
        }

        private function getWooReviewScore() {
            if ( isset($this->article_review_score) && ($this->article_review_score != '') ) {
                return '<span class="stars"><span style="width:'. round($this->article_review_score/5 * 100) .'%"></span></span>';
            }
        }

        private function getViews() {
            global $mp_weeklynews;
            if ( isset($mp_weeklynews['_mp_cat_show_postmeta_options'])&&(bool)$mp_weeklynews['_mp_cat_show_postmeta_options']['views'] ) {
                return '<span class="icon fa-eye">'. MipTheme_Post_Views::get_post_views($this->article_link) .'</span>';
            }
        }

        private function addToCart() {
            if ( (bool)$this->article_add_to_cart ) {
                return '<a href="?add-to-cart='. $this->article_link .'" rel="nofollow" data-product_id="'. $this->article_link .'" data-product_sku="" data-quantity="1" class="button add_to_cart_button product_type_simple">'. __('Add To Cart', THEMENAME) .'</a>';
            }
        }

        private function setBoxImage( $imgWidth, $imgHeight, $imgClass = ' class="img-responsive"', $itemProp = ' itemprop="image"' ) {
            global $mp_weeklynews;
            $img_lazy_load  = (isset($mp_weeklynews['_mp_posts_enable_lazy_load']) && (bool)$mp_weeklynews['_mp_posts_enable_lazy_load']) ? true : false;
            if ( $img_lazy_load && $this->article_no_ajax_call ) {
                return '<img'. $itemProp .' class="bttrlazyloading'. ( ($imgClass != '') ? ' img-responsive' : '' ) .'" data-bttrlazyloading-md-src="'. esc_url($this->article_thumb) .'" width="'. $imgWidth .'" height="'. $imgHeight .'" alt="'. esc_attr($this->article_title) .'"'. $imgClass .' />
                        <noscript><img itemprop="image" src="'. esc_url($this->article_thumb) .'" width="'. $imgWidth .'" height="'. $imgHeight .'" alt="'. esc_attr($this->article_title) .'"'. $imgClass .' /></noscript>';
            } else {
                return '<img'. $itemProp .' src="'. esc_url($this->article_thumb) .'" width="'. $imgWidth .'" height="'. $imgHeight .'" alt="'. esc_attr($this->article_title) .'"'. $imgClass .' />';
            }
        }

        private function setPostMeta( $nType = 1, $fDate = MIPTHEME_DATE_DEFAULT ) {
            global $mp_weeklynews;
            $postMeta   = '';

            if ( isset($mp_weeklynews['_mp_cat_show_postmeta']) && (bool)$mp_weeklynews['_mp_cat_show_postmeta'] ) {
                if ( $nType == 1 ) {
                    if ( isset($mp_weeklynews['_mp_cat_show_postmeta_options'])&&(bool)$mp_weeklynews['_mp_cat_show_postmeta_options']['date'] ) {
                        $postMeta   .= '<span class="icon fa-calendar" itemprop="dateCreated">'. get_the_date($fDate) .'</span>';
                    }
                    if ( isset($mp_weeklynews['_mp_cat_show_postmeta_options'])&&(bool)$mp_weeklynews['_mp_cat_show_postmeta_options']['comments'] ) {
                        if ( isset($mp_weeklynews['_mp_post_facebook_comments_enable'])&&(bool)$mp_weeklynews['_mp_post_facebook_comments_enable']) {
                            $comment_count_total  = '<fb:comments-count href="'. get_permalink($this->article_link) .'"></fb:comments-count>';
                        } else {
                            $comment_count          = wp_count_comments($this->article_link);
                            $comment_count_total  = '<a href="'. get_comments_link($this->article_link) .'">'. $comment_count->total_comments .'</a>';
                        }

                        $postMeta   .= '<span class="icon fa-comments">'. $comment_count_total .'</span>';
                    }
                    $postMeta   .= $this->getViews();

                    if ( $postMeta != '' ) return '<span class="published" itemprop="dateCreated">'. $postMeta .'</span>';

                } else {
                    return '<span class="published" itemprop="dateCreated">'. $this->article_post_date .'</span>';
                }
            }
        }

        private function setPostMetaLinkbox() {
            global $mp_weeklynews;
            $postMeta   = '';
            if ( isset($mp_weeklynews['_mp_cat_show_postmeta_linkbox']) && (bool)$mp_weeklynews['_mp_cat_show_postmeta_linkbox'] ) {
                if ( isset($mp_weeklynews['_mp_cat_postmeta_linkbox_options'])&&(bool)$mp_weeklynews['_mp_cat_postmeta_linkbox_options']['date'] ) {
                    $postMeta   .= '<span class="fa-calendar" itemprop="dateCreated">'. get_the_date(MIPTHEME_DATE_DEFAULT_SHORT) .'</span>';
                }
                if ( isset($mp_weeklynews['_mp_cat_postmeta_linkbox_options'])&&(bool)$mp_weeklynews['_mp_cat_postmeta_linkbox_options']['comments'] ) {
                    if ( isset($mp_weeklynews['_mp_post_facebook_comments_enable'])&&(bool)$mp_weeklynews['_mp_post_facebook_comments_enable']) {
                        $comment_count_total  = '<fb:comments-count href="'. get_permalink($this->article_link) .'"></fb:comments-count>';
                    } else {
                        $comment_count          = wp_count_comments($this->article_link);
                        $comment_count_total  = '<a href="'. get_comments_link($this->article_link) .'">'. $comment_count->total_comments .'</a>';
                    }

                    $postMeta   .= '<span class="fa-comments">'. $comment_count_total .'</span>';
                }
                $postMeta   .= $this->getViews();

                if ( $postMeta != '' ) return '<div class="postmeta">'. $postMeta .'</div>';
            }
        }

        private function setPostTypeIcon() {
            switch ( $this->article_post_type ) {
                case 'standard':
                    return '<i class="fa fa-pencil"></i>';
                break;
                case 'gallery':
                    return '<i class="fa fa-image"></i>';
                break;
                case 'image':
                    return '<i class="fa fa-image"></i>';
                break;
                case 'video':
                    return '<i class="fa fa-video-camera"></i>';
                break;
                case 'audio':
                    return '<i class="fa fa-music"></i>';
                break;
                case 'quote':
                    return '<i class="fa fa-quote-left"></i>';
                break;
            }
        }


        private function noDummyImage() {
            $pos_value = strrpos($this->article_thumb, "dummy");
            if ( $this->article_thumb ) {
                if ($pos_value === false) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        private function substituteArticleStyle1( $textInt = 250 ) {
            return    '<!-- start:article.linkbox -->
                    <article class="linkbox linkbox-sub large cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                        '. $this->setCategoryLabel() .'
                        <h2 itemprop="name"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h2>
                        '. $this->setPostMetaLinkbox() .'
                        <span class="text">'. MipTheme_Util::ShortenText($this->article_content, $textInt) .'</span>
                    </article>
                    <!-- end:article.linkbox -->';
        }

        public function substituteArticleStyle2( $textInt = 200 ) {
            return    '<!-- start:article.linkbox -->
                    <article class="linkbox linkbox-sub cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                        '. $this->setCategoryLabel() .'
                        <h3 itemprop="name"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                        '. $this->setPostMetaLinkbox() .'
                        <span class="text">'. MipTheme_Util::ShortenText($this->article_content, $textInt) .'</span>
                    </article>
                    <!-- end:article.linkbox -->';
        }

        public function substituteArticleStyle3( $textInt = 110 ) {
            return    '<!-- start:article.linkbox -->
                    <article class="linkbox linkbox-sub medium cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                        '. $this->setCategoryLabelSpan() .'
                        <h3 itemprop="name"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                        '. $this->setPostMetaLinkbox() .'
                        <span class="text">'. MipTheme_Util::ShortenText($this->article_content, $textInt) .'</span>
                    </article>
                    <!-- end:article.linkbox -->';
        }

        public function substituteReviewStyle1( $imgWidth = 120, $imgHeight = 105, $textInt = 80 ) {
            return    '<!-- start:article.linkbox.large -->
                <article class="text-center" itemscope itemtype="http://schema.org/Article">
                    <a itemprop="url" href="'. get_permalink($this->article_link) .'">
                        <h3 itemprop="name">'. $this->article_title .'</h3>
                    </a>
                    <span class="text">'. MipTheme_Util::ShortenText($this->article_content, $textInt) .'</span>
                    <span class="stars"><span style="width:'. $this->getReviewScore() .'%"></span></span>
                </article>
                <!-- end:article.linkbox.large -->';
        }


        public function formatArticleStyle1( $imgWidth = 560, $imgHeight = 390 ) {
            if ( $this->noDummyImage() ) {
                return    '<!-- start:article.linkbox -->
                        <article class="linkbox large cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                            <a itemprop="url" href="'. get_permalink($this->article_link) .'">
                                '. $this->setBoxImage( $imgWidth, $imgHeight ) .'
                                <div class="overlay">
                                    <h2 itemprop="name">'. $this->article_title .'</h2>
                                </div>
                            </a>
                            '. $this->setCategoryLabel() .'
                            '. $this->setPostMetaLinkbox() .'
                        </article>
                        <!-- end:article.linkbox -->';
            } else {
                return $this->substituteArticleStyle1();
            }
        }


        public function formatArticleStyle2( $imgWidth = 265, $imgHeight = 160, $textInt = 170 ) {
            if ( $this->noDummyImage() ) {
                return    '<!-- start:row -->
                        <div class="row bottom-margin">
                            <!-- start:article.thumb -->
                            <article class="thumb thumb-lay-one cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                                <!-- start:col -->
                                <div class="col-sm-6">
                                    <div class="thumb-wrap relative">
                                        <a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->setBoxImage( $imgWidth, $imgHeight ) .'</a>
                                        '. $this->setCategoryLabel() .'
                                    </div>
                                </div>
                                <!-- end:col -->
                                <!-- start:col -->
                                <div class="col-sm-6">
                                    <h3 itemprop="name"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                                    '. $this->setPostMeta( 1 ) .'
                                    <span class="text">'. MipTheme_Util::ShortenText($this->article_content, $textInt) .'</span>
                                </div>
                                <!-- end:col -->
                            </article>
                            <!-- end:article.thumb -->
                        </div>
                        <!-- end:row -->';
            } else {
                return $this->substituteArticleStyle2($textInt);
            }
        }

        public function formatArticleStyle3( $imgWidth = 265, $imgHeight = 160 ) {
            if ( $this->noDummyImage() ) {
                return    '<div class="col-sm-6 clearfix">
                        <!-- start:article.linkbox -->
                        <article class="linkbox cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                            <a itemprop="url" href="'. get_permalink($this->article_link) .'">
                                '. $this->setBoxImage( $imgWidth, $imgHeight ) .'
                                <div class="overlay">
                                    <h3 itemprop="name">'. $this->article_title .'</h3>
                                </div>
                            </a>
                            '. $this->setCategoryLabel() .'
                            '. $this->setPostMetaLinkbox() .'
                        </article>
                        <!-- end:article.linkbox -->
                        </div>';
            } else {
                return '<div class="col-sm-6 clearfix">'. $this->substituteArticleStyle3() .'</div>';
            }
        }



        public function formatArticleStyle4( $imgWidth = 100, $imgHeight = 80, $textInt = 85 ) {
            return    '<!-- start:article -->
                    <article class="clearfix" itemscope itemtype="http://schema.org/Article">
                        <h3 itemprop="name"><a href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                        '. ( ( ( $this->noDummyImage() ) ) ? '<a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->setBoxImage( $imgWidth, $imgHeight, '' ) .'</a>' : '' ) .'
                        <span class="text">'. MipTheme_Util::ShortenText($this->article_content, $textInt) .'</span>
                        '. $this->setPostMeta( 2 ) .'
                    </article>
                    <!-- end:article -->';
        }


        public function formatArticleStyle5( $imgWidth = 334, $imgHeight = 301 ) {
            return    '<div class="col-sm-7">
                    <!-- start:article.linkbox -->
                    <article class="linkbox cat-'. esc_attr($this->cat_ID) .'" parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .' itemscope itemtype="http://schema.org/Article">
                        <a itemprop="url" href="'. get_permalink($this->article_link) .'">
                            '. $this->setBoxImage( $imgWidth, $imgHeight ) .'
                            <div class="overlay">
                                <h2 itemprop="name">'. $this->article_title .'</h2>
                            </div>
                        </a>
                        '. $this->setCategoryLabel() .'
                        '. $this->setPostMetaLinkbox() .'
                    </article>
                    <!-- end:article.linkbox -->
                    </div>';
        }


        public function formatArticleStyle6( $imgWidth = 265, $imgHeight = 160 ) {
            if ( $this->noDummyImage() ) {
                return    '<!-- start:article.linkbox -->
                        <article class="linkbox cat-'. esc_attr($this->cat_ID) .'" parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .' itemscope itemtype="http://schema.org/Article">
                            <a itemprop="url" href="'. get_permalink($this->article_link) .'">
                                '. $this->setBoxImage( $imgWidth, $imgHeight ) .'
                                <div class="overlay">
                                    <h3 itemprop="name">'. $this->article_title .'</h3>
                                </div>
                            </a>
                            '. $this->setCategoryLabel() .'
                            '. $this->setPostMetaLinkbox() .'
                        </article>
                        <!-- end:article.linkbox -->';
            } else {
                return $this->substituteArticleStyle2(280);
            }
        }

        public function formatArticleStyle8( $imgWidth = 819, $imgHeight = 452 ) {
            return    '<!-- start:article.linkbox.large -->
                    <article class="linkbox large cat-'. esc_attr($this->cat_ID) .'" parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .' itemscope itemtype="http://schema.org/Article">
                        <a itemprop="url" href="'. get_permalink($this->article_link) .'">
                            '. $this->setBoxImage( $imgWidth, $imgHeight ) .'
                            <div class="overlay">
                                '. ( ( $this->article_review == 'enable' ) ? MipTheme_Util::ShowRating( $this->getReviewScore(), 'stars-lg stars-dark' ) : '' ) .'
                                <h2 itemprop="name">'. $this->article_title .'</h2>
                                '. ( (  $this->article_show_summary ) ? '<p>'. MipTheme_Util::ShortenText($this->article_content, 100) .'</p>'  : '' ) .'
                            </div>
                        </a>
                        '. $this->setCategoryLabel() .'
                        '. $this->setPostMetaLinkbox() .'
                    </article>
                    <!-- end:article.linkbox.large -->';
        }

        public function formatArticleStyle9( $imgWidth = 190, $imgHeight = 140 ) {
            return    '<!-- start:article -->
                    <article class="linkbox large cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .' text-center">
                        <a href="'. get_permalink($this->article_link) .'">
                            <div class="thumb-wrap">'. $this->setBoxImage( $imgWidth, $imgHeight, ' class="img-responsive"', '' ) .'</div>
                            <h3>'. $this->article_title .'</h3>
                        </a>
                        '. MipTheme_Util::ShowRating( $this->getReviewScore() ) .'
                    </article>
                    <!-- end:article -->';
        }

        public function formatArticleStyle10( $imgWidth = 265, $imgHeight = 160 ) {
            if ( $this->noDummyImage() ) {
                return    '<!-- start:article -->
                        <article class="thumb thumb-lay-two cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                            <div class="thumb-wrap relative">
                                <a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->setBoxImage( $imgWidth, $imgHeight ) .'</a>
                                '. $this->setCategoryLabel() .'
                            </div>
                            '. $this->setPostMeta( 2 ) .'
                            <h3 itemprop="name"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                        </article>
                        <!-- end:article -->';
            } else {
                return $this->substituteArticleStyle3();
            }
        }


        public function formatArticleStyle13_1( $imgWidth = 265, $imgHeight = 160, $textInt = 150 ) {
            return      '<!-- start:article -->
                        <article class="thumb thumb-lay-one thumb-head-13 cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                            '. ( ( ( $this->noDummyImage() ) ) ? '<div class="thumb-wrap relative"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->setBoxImage( $imgWidth, $imgHeight ) .'</a>'. $this->setCategoryLabel() .'</div>' : '' ) .'
                            <h3 itemprop="name"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                            '. $this->setPostMeta( 1 ) .'
                            <span class="text">'. MipTheme_Util::ShortenText($this->article_content, $textInt) .'</span>
                        </article>
                        <!-- end:article -->';
        }


        public function formatArticleStyle13_2( $imgWidth = 100, $imgHeight = 80, $textInt = 0 ) {
            return      '<!-- start:article -->
                        <article class="thumb thumb-lay-13 cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .' clearfix" itemscope itemtype="http://schema.org/Article">
                            '. ( MipTheme_Util::noDummyImage( $this->article_thumb ) ?  '<a href="'. get_permalink($this->article_link) .'">'. $this->setBoxImage( $imgWidth, $imgHeight, '' ) .'</a>' : '' ) .'
                            <h3><a href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                            '. $this->setPostMeta( 2 ) .'
                        </article>
                        <!-- end:article -->';
        }





        public function formatArticleByStyle( $format = 'related-box-3', $imgWidth = 265, $imgHeight = 160 ) {
            switch ($format) {
                case 'related-box-1':
                    return '<article>
                        <h5><a href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h5>
                    </article>';
                break;
                case 'related-box-2':
                    return '<article>
                        <h5>
                            <a href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a>
                            <span class="published">'. $this->article_post_date .'</span>
                        </h5>
                    </article>';
                break;
                case 'related-box-3':
                    if ( $this->noDummyImage() ) {
                        return '<article>
                            <a href="'. get_permalink($this->article_link) .'">
                                <img src="'. esc_url($this->article_thumb) .'" width="'. $imgWidrh .'" height="'. $imgHeight .'" alt="'. esc_attr($this->article_title) .'" class="img-responsive" />
                                <h5 class="text-center">'. $this->article_title .'</h5>
                            </a>
                        </article>';
                    } else {
                        return '<article class="text-center">
                            <h5>
                                <a href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a>
                            </h5>
                        </article>';
                    }
                break;
            }
        }

        public function formatArticleStyle11( $imgWidth = 120, $imgHeight = 105 ) {
            return    '<!-- start:article.linkbox.large -->
                    <article class="text-center" itemscope itemtype="http://schema.org/Article">
                        <a itemprop="url" href="'. get_permalink($this->article_link) .'">
                            '. $this->setBoxImage( $imgWidth, $imgHeight ) .'
                            <h3 itemprop="name">'. $this->article_title .'</h3>
                        </a>
                    </article>
                    <!-- end:article.linkbox.large -->';
        }

        public function formatArticleReview1( $imgWidth = 120, $imgHeight = 105 ) {
            if ( $this->noDummyImage() ) {
                return    '<!-- start:article.linkbox.large -->
                        <article class="text-center" itemscope itemtype="http://schema.org/Article">
                            <a itemprop="url" href="'. get_permalink($this->article_link) .'">
                                '. $this->setBoxImage( $imgWidth, $imgHeight ) .'
                                <h3 itemprop="name">'. $this->article_title .'</h3>
                            </a>
                            <span class="stars"><span style="width:'. $this->getReviewScore() .'%"></span></span>
                        </article>
                        <!-- end:article.linkbox.large -->';
            } else {
                return $this->substituteReviewStyle1();
            }
        }

        public function formatWooArticle1( $imgWidth = 170, $imgHeight = 170 ) {
            return    '<!-- start:article.linkbox.large -->
                    <article class="text-center" itemscope itemtype="http://schema.org/Article">
                        <a itemprop="url" href="'. get_permalink($this->article_link) .'">
                            '. $this->setBoxImage( $imgWidth, $imgHeight ) .'
                            <h3 itemprop="name">'. $this->article_title .'</h3>
                        </a>
                        <span class="price">'. $this->article_price .'</span>
                        '. $this->getWooReviewScore() .'
                        '. $this->addToCart() .'
                    </article>
                    <!-- end:article.linkbox.large -->';
        }

        public function formatWooArticle2( $imgWidth = 265, $imgHeight = 160, $textInt = 170 ) {
            return    '<!-- start:row -->
                    <div class="row bottom-margin">
                        <!-- start:article.thumb -->
                        <article class="thumb thumb-lay-one cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                            <!-- start:col -->
                            <div class="col-sm-6">
                                <div class="thumb-wrap relative">
                                    <a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->setBoxImage( $imgWidth, $imgHeight ) .'</a>
                                    '. $this->setCategoryLabel() .'
                                </div>
                            </div>
                            <!-- end:col -->
                            <!-- start:col -->
                            <div class="col-sm-6">
                                <h3 itemprop="name"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                                '. $this->getWooReviewScore() .'
                                <span class="price">'. $this->article_price .'</span>
                                <span class="text">'. MipTheme_Util::ShortenText($this->article_content, $textInt) .'</span>
                                '. $this->addToCart() .'
                            </div>
                            <!-- end:col -->
                        </article>
                        <!-- end:article.thumb -->
                    </div>
                    <!-- end:row -->';
        }

        public function formatWooArticle3( $imgWidth = 237, $imgHeight = 237 ) {
            return    '<!-- start:article -->
                    <article class="thumb thumb-lay-two cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                        <div class="thumb-wrap relative">
                            <a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->setBoxImage( $imgWidth, $imgHeight ) .'</a>
                            '. $this->setCategoryLabel() .'
                        </div>
                        <h3 itemprop="name"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                        <span class="price">'. $this->article_price .'</span>
                        '. $this->getWooReviewScore() .'
                        '. $this->addToCart() .'
                    </article>
                    <!-- end:article -->';
        }

        public function formatArticleTimeline( $imgWidth = 265, $imgHeight = 160, $textChars = 250 ) {
            return    '<article itemscope itemtype="http://schema.org/Article">
                <span class="published" itemprop="dateCreated">'. $this->article_post_date .'</span>
                '. ( ( ( $this->noDummyImage() ) ) ? '<a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->setBoxImage( $imgWidth, $imgHeight ) .'</a>' : '' ) .'
                <div class="cnt">
                    <i class="bullet bullet-'. $this->cat_ID .'"></i>
                    <span class="category cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'"><a href="'. get_category_link($this->cat_ID) .'">'. $this->cat_name .'</a></span>
                    <h3 itemprop="name"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                    <span class="text">'. MipTheme_Util::ShortenText($this->article_content, $textChars) .'</span>
                </div>
            </article>';
        }


        public function formatArticleStyleBlog( $imgWidth = 770, $imgHeight = 470, $textInt = 350 ) {

            // get categories
            $categories     = get_the_category($this->article_link);
            $separator      = ', ';
            $cat_output     = '';
            if($categories){
                foreach($categories as $category) {
                    $cat_output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
                }
            }

            // get thumb
            $thumb_wrap     = '';
            if ( redux_post_meta(THEMEREDUXNAME, $this->article_link, '_mp_featured_video') ) {
                $featured_video = new MipTheme_Video();
                $thumb_wrap =  '<div class="head-video relative">'. $featured_video->renderVideo( redux_post_meta(THEMEREDUXNAME, $this->article_link, '_mp_featured_video') ) .'</div>';
            } else if ( redux_post_meta(THEMEREDUXNAME, $this->article_link, '_mp_featured_audio_embed') ) {
                $thumb_wrap =  '<div class="head-video relative">'. redux_post_meta(THEMEREDUXNAME, $this->article_link, '_mp_featured_audio_embed') .'</div>';
            } else {
                if ( $this->noDummyImage() ) {
                    $thumb_wrap = '<div class="thumb-wrap relative">
                                <a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->setBoxImage( $imgWidth, $imgHeight ) .'</a>
                                '. $this->setCategoryLabel() .'
                            </div>';
                }
            }

            return    '<!-- start:article -->
                    <article class="thumb-lay-blog cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                        '. $thumb_wrap .'
                        <div class="info relative">
                            <a class="btn-fa-icon" href="#">'. $this->setPostTypeIcon() .'</a>

                            <h2 itemprop="name"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h2>
                            <span class="published">
                                <span itemprop="author">'. __('By') .' <a href="'. $this->article_author_url .'">'. $this->article_author .'</a></span>
                                <span itemprop="dateCreated">'. $this->article_post_date .'</span>
                                '. ( ($cat_output != '') ? '<span itemprop="category">'. __('In') .' '. trim($cat_output, $separator) .'</span>' : '' ) .'
                                <span itemprop="interactionCount"><a href="'. get_comments_link($this->article_link) .'">'. $this->article_comments_count .' '. __('comments') .'</a></span>
                            </span>

                            '. ( ($this->article_more) ? '<span class="text">'. $this->article_content .'</span>' : '<span class="text"><p>'. MipTheme_Util::ShortenText($this->article_content, $textInt) .'</p><a class="more-link" itemprop="url" href="'. get_permalink($this->article_link) .'">'. __('Read more', THEMENAME) .'</a></span>'  ) .'
                        </div>
                    </article>
                    <!-- end:article -->';
        }


        public function formatArticleTextOnly( $layout = 'text-layout-1', $textInt = 150 ) {
            switch ( $layout ) {
                case 'text-layout-1':
                    return  '<!-- start:article.linkbox -->
                            <article class="linkbox linkbox-sub medium cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                                '. $this->setCategoryLabelSpan() .'
                                <h3 itemprop="name"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                            </article>
                            <!-- end:article.linkbox -->';
                break;
                case 'text-layout-2':
                    return  '<!-- start:article.linkbox -->
                            <article class="linkbox linkbox-sub medium cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                                '. $this->setCategoryLabelSpan() .'
                                <h3 itemprop="name"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                                '. $this->setPostMetaLinkbox() .'
                            </article>
                            <!-- end:article.linkbox -->';
                break;
                case 'text-layout-3':
                    return  '<!-- start:article.linkbox -->
                            <article class="linkbox linkbox-sub medium cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                                '. $this->setCategoryLabelSpan() .'
                                <h3 itemprop="name"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                                '. $this->setPostMetaLinkbox() .'
                                <span class="text">'. MipTheme_Util::ShortenText($this->article_content, $textInt) .'</span>
                            </article>
                            <!-- end:article.linkbox -->';
                break;
                case 'text-layout-4':
                    return  '<!-- start:article.linkbox -->
                            <article class="linkbox linkbox-sub medium cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                                '. $this->setCategoryLabelSpan() .'
                                <h3 itemprop="name"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                                <span class="text">'. MipTheme_Util::ShortenText($this->article_content, $textInt) .'</span>
                            </article>
                            <!-- end:article.linkbox -->';
                break;
                case 'text-layout-5':
                    return  '<!-- start:article.linkbox -->
                            <article class="linkbox linkbox-sub medium cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                                <h3 itemprop="name"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                                '. $this->setPostMetaLinkbox() .'
                                <span class="text">'. MipTheme_Util::ShortenText($this->article_content, $textInt) .'</span>
                            </article>
                            <!-- end:article.linkbox -->';
                break;
                case 'text-layout-6':
                    return  '<!-- start:article.linkbox -->
                            <article class="linkbox linkbox-sub medium cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                                <h3 itemprop="name"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                                <span class="text">'. MipTheme_Util::ShortenText($this->article_content, $textInt) .'</span>
                            </article>
                            <!-- end:article.linkbox -->';
                break;
                default:
                    return  '<!-- start:article.linkbox -->
                            <article class="linkbox linkbox-sub medium cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                                '. $this->setCategoryLabelSpan() .'
                                <h3 itemprop="name"><a itemprop="url" href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                                '. $this->setPostMetaLinkbox() .'
                                <span class="text">'. MipTheme_Util::ShortenText($this->article_content, $textInt) .'</span>
                            </article>
                            <!-- end:article.linkbox -->';
                break;
            }

        }


        public function formatArticleOwlLazy( $imgWidth = 819, $imgHeight = 452 ) {
            return    '<!-- start:article.linkbox.large -->
                    <article class="linkbox large cat-'. esc_attr($this->cat_ID) .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'" itemscope itemtype="http://schema.org/Article">
                        <a itemprop="url" href="'. get_permalink($this->article_link) .'">
                            <img itemprop="image" data-echo="'. esc_url($this->article_thumb) .'" width="'. $imgWidth .'" height="'. $imgHeight .'" alt="'. esc_attr($this->article_title) .'" class="lazy img-responsive" />
                            <div class="overlay">
                                '. ( ( $this->article_review == 'enable' ) ? MipTheme_Util::ShowRating( $this->getReviewScore(), 'stars-lg stars-dark' ) : '' ) .'
                                <h2 itemprop="name">'. $this->article_title .'</h2>
                                '. ( (  $this->article_show_summary ) ? '<p>'. MipTheme_Util::ShortenText($this->article_content, 100) .'</p>'  : '' ) .'
                            </div>
                        </a>
                        '. $this->setCategoryLabel() .'
                    </article>
                    <!-- end:article.linkbox.large -->';
        }


        private function getArticleViewsByFilterDate( $post_ID, $views = 'no-views' ) {
            switch ( $views ) {
                case 'all_views':
                    return '<span class="icon fa-eye">'. MipTheme_Post_Views::get_post_views($post_ID) .'</span>';
                break;
                case 'last_24_hours':
                    return '<span class="icon fa-eye">'. MipTheme_Post_Views::get_post_views($post_ID, '_mip_post_views_count_24_hours_total') .'</span>';
                break;
                case 'last_7_days':
                    return '<span class="icon fa-eye">'. MipTheme_Post_Views::get_post_views($post_ID, '_mip_post_views_count_7_day_total') .'</span>';
                break;
                default:
                    return '';
            }
        }


        public function formatArticleForRecentPostWidget( $layout = 'layout_one', $post_counter = 1, $show_date = false, $show_category = false, $show_views = 'no-views', $thumb_big ) {
            switch ( $layout ) {
                case 'layout_one':
                    return  '<!-- start:article -->
                            <article class="clearfix">
                                '. ( MipTheme_Util::noDummyImage( $this->article_thumb ) ?  '<a href="'. get_permalink($this->article_link) .'">'. MipTheme_Util::setImage($this->article_thumb, $this->article_title, 100, 80, '') .'</a>' : '' ) .'
                                '. ( $show_category ? '<span class="category cat-' . $this->cat_ID . ' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'"><a href="' . get_category_link( $this->cat_ID ) . '">'. $this->cat_name .'</a></span>' : '' ) .'
                                <h3><a href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                                <span class="published">
                                    '. ( ( $show_date ) ? '<span class="icon fa-calendar">'. get_the_date( MIPTHEME_DATE_SIDEBAR ) .'</span>' : '' ) .'
                                    '. ( ( $show_views ) ? $this->getArticleViewsByFilterDate($this->article_link, $show_views) : '' ) .'
                                </span>
                            </article>
                            <!-- end:article -->';
                break;
                case 'layout_two':
                    if ( $post_counter == 1 ) {
                        $linkbox_add_class = ( ($show_date == false) && ($show_views == 'no-views') ) ? ' no-postmeta' : ' has-postmeta';
                        return  '<!-- start:article.linkbox -->
                            <article class="linkbox cat-'. esc_attr($this->cat_ID) . $linkbox_add_class .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .' clearfix">
                                <a href="'. get_permalink($this->article_link) .'">
                                    '. ( MipTheme_Util::noDummyImage( $thumb_big ) ?  MipTheme_Util::setImage($thumb_big, $this->article_title, 350, 200) : '' ) .'
                                    <div class="overlay">
                                        <h3>'. $this->article_title .'</h3>
                                    </div>
                                </a>
                                '. $this->setCategoryLabel() .'
                                <span class="postmeta">
                                    '. ( ( $show_date ) ? '<span class="icon fa-calendar">'. get_the_date( MIPTHEME_DATE_SIDEBAR ) .'</span>' : '' ) .'
                                    '. ( ( $show_views ) ? $this->getArticleViewsByFilterDate($this->article_link, $show_views) : '' ) .'
                                </span>
                            </article>
                            <!-- end:article.linkbox -->';
                    } else {
                    return  '<!-- start:article -->
                            <article class="clearfix">
                                '. ( MipTheme_Util::noDummyImage( $this->article_thumb ) ?  '<a href="'. get_permalink($this->article_link) .'">'. MipTheme_Util::setImage($this->article_thumb, $this->article_title, 100, 80, '') .'</a>' : '' ) .'
                                '. ( $show_category ? '<span class="category cat-' . $this->cat_ID . ' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .'"><a href="' . get_category_link( $this->cat_ID ) . '">'. $this->cat_name .'</a></span>' : '' ) .'
                                <h3><a href="'. get_permalink($this->article_link) .'">'. $this->article_title .'</a></h3>
                                <span class="published">
                                    '. ( ( $show_date ) ? '<span class="icon fa-calendar">'. get_the_date( MIPTHEME_DATE_SIDEBAR ) .'</span>' : '' ) .'
                                    '. ( ( $show_views ) ? $this->getArticleViewsByFilterDate($this->article_link, $show_views) : '' ) .'
                                </span>
                            </article>
                            <!-- end:article -->';
                    }
                break;
                case 'layout_three':
                    $linkbox_add_class = ( ($show_date == false) && ($show_views == 'no-views') ) ? ' no-postmeta' : ' has-postmeta';
                    return  '<!-- start:article.linkbox -->
                            <article class="linkbox cat-'. esc_attr($this->cat_ID) . $linkbox_add_class .' parent-cat-'. esc_attr(MipTheme_Util::get_category_top_parent_id($this->cat_ID)) .' clearfix">
                                <a href="'. get_permalink($this->article_link) .'">
                                    '. ( MipTheme_Util::noDummyImage( $thumb_big ) ?  MipTheme_Util::setImage($thumb_big, $this->article_title, 350, 200) : '' ) .'
                                    <div class="overlay">
                                        <h3>'. $this->article_title .'</h3>
                                    </div>
                                </a>
                                '. $this->setCategoryLabel() .'
                                <span class="postmeta">
                                    '. ( ( $show_date ) ? '<span class="icon fa-calendar">'. get_the_date( MIPTHEME_DATE_SIDEBAR ) .'</span>' : '' ) .'
                                    '. ( ( $show_views ) ? $this->getArticleViewsByFilterDate($this->article_link, $show_views) : '' ) .'
                                </span>
                            </article>
                            <!-- end:article.linkbox -->';
                break;
            }

        }


    }

}
