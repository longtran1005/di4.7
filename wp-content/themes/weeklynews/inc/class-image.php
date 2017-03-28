<?php
/**
 * Theme by: MipThemes
 * http://themes.mipdesign.com
 *
 * Our portfolio: http://themeforest.net/user/mip/portfolio
 * Thanks for using our theme!
 */

if ( ! class_exists( 'MipTheme_Image' ) ) {

    class MipTheme_Image {

        public $theme_layout    = '';
        public $page_layout     = '';
        private $image_arr;
        private $image_dims;


        public function __construct() {
            global $mp_weeklynews;
            $this->theme_layout     = ( isset($mp_weeklynews['_mp_theme_layout']) && ($mp_weeklynews['_mp_theme_layout'] == 'theme-unboxed')) ? 'unboxed' : 'boxed';

            if ( $this->theme_layout == 'boxed' ) {
                $this->image_dims       = array
                (
                    'post-thumb-1'  => array( 'post-thumb-1', 770, 470, 0 ),
                    'post-thumb-2'  => array( 'post-thumb-2', 560, 390, 0 ),
                    'post-thumb-3'  => array( 'post-thumb-3', 265, 160, 170 ),
                    'post-thumb-7'  => array( 'post-thumb-7', 100, 80, 0 ),
                    'post-thumb-9'  => array( 'post-thumb-9', 370, 223, 340 ),
                    '1120_bfi_684'  => array( '1120_bfi_684', 1120, 684, 0 ),
                    '545_bfi_328'   => array( '545_bfi_328', 545, 328, 650 ),
                    '357_bfi_301'   => array( '357_bfi_301', 357, 301, 0 ),
                    '252_bfi_150'   => array( '252_bfi_150', 252, 150, 0 ),
                    '479_bfi_405'   => array( '479_bfi_405', 479, 405, 0 ),
                    '339_bfi_202'   => array( '339_bfi_202', 339, 202, 0 ),
                    '118_bfi_104'   => array( '118_bfi_104', 118, 104, 0 ),
                    '258_bfi_227'   => array( '258_bfi_227', 258, 227, 0 ),
                    '170_bfi_150'   => array( '170_bfi_150', 170, 150, 0 ),
                    '167_bfi_120'   => array( '167_bfi_120', 167, 120, 0 ),
                    '353_bfi_213'   => array( '353_bfi_213', 353, 213, 0 ),
                    '237_bfi_143'   => array( '237_bfi_143', 237, 143, 0 ),
                );
            } else {
                $this->image_dims       = array
                (
                    'post-thumb-1'  => array( '795_bfi_485', 795, 485, 0 ),
                    'post-thumb-2'  => array( '610_bfi_425', 610, 425, 0 ),
                    'post-thumb-3'  => array( '290_bfi_176', 290, 176, 170 ),
                    'post-thumb-7'  => array( 'post-thumb-7', 100, 80, 0 ),
                    'post-thumb-9'  => array( '383_bfi_231', 383, 231, 340 ),
                    '1120_bfi_684'  => array( '1120_bfi_684', 1120, 684, 0 ),
                    '545_bfi_328'   => array( '545_bfi_328', 545, 328, 650 ),
                    '357_bfi_301'   => array( '357_bfi_301', 357, 301, 0 ),
                    '252_bfi_150'   => array( '252_bfi_150', 252, 150, 0 ),
                    '479_bfi_405'   => array( '465_bfi_405', 465, 405, 0 ),
                    '339_bfi_202'   => array( '329_bfi_202', 329, 202, 0 ),
                    '118_bfi_104'   => array( '118_bfi_104', 118, 104, 0 ),
                    '258_bfi_227'   => array( '258_bfi_227', 258, 227, 0 ),
                    '170_bfi_150'   => array( '170_bfi_150', 170, 150, 0 ),
                    '167_bfi_120'   => array( '183_bfi_132', 183, 132, 0 ),
                    '353_bfi_213'   => array( '353_bfi_213', 353, 213, 0 ),
                    '237_bfi_143'   => array( '245_bfi_148', 245, 148, 0 ),
                );
            }

        }


        public function get_image_attr( $block_id ) {
            return $this->image_arr[$block_id];
        }

        // for blocks 01 and 03
        public function get_image_attr_block01($block_id) {
            $this->image_arr        = array
            (
                'multi-sidebar-1'       => $this->image_dims['post-thumb-2'],
                'multi-sidebar-2'       => $this->image_dims['post-thumb-3'],
                'sidebar-1'             => $this->image_dims['post-thumb-1'],
                'sidebar-2'             => $this->image_dims['post-thumb-9'],
                'hide-sidebar-1'        => $this->image_dims['1120_bfi_684'],
                'hide-sidebar-2'        => $this->image_dims['545_bfi_328'],
            );
            return $this->image_arr[$block_id];
        }


        // for blocks 02 and 04
        public function get_image_attr_block02($block_id) {
            $this->image_arr        = array
            (
                'multi-sidebar-1'       => $this->image_dims['post-thumb-3'],
                'sidebar-1'             => $this->image_dims['post-thumb-9'],
                'hide-sidebar-1'        => $this->image_dims['545_bfi_328'],
            );
            return $this->image_arr[$block_id];
        }

        // for blocks 07
        public function get_image_attr_block07($block_id) {
            $this->image_arr        = array
            (
                'multi-sidebar-1'       => $this->image_dims['357_bfi_301'],
                'multi-sidebar-2'       => $this->image_dims['252_bfi_150'],
                'sidebar-1'             => $this->image_dims['479_bfi_405'],
                'sidebar-2'             => $this->image_dims['339_bfi_202'],
                'hide-sidebar-1'        => $this->image_dims['479_bfi_405'],
                'hide-sidebar-2'        => $this->image_dims['339_bfi_202'],
            );
            return $this->image_arr[$block_id];
        }

        // for blocks 08
        public function get_image_attr_block08($block_id) {
            $this->image_arr        = array
            (
                'multi-sidebar-1'       => $this->image_dims['167_bfi_120'],
                'sidebar-1'             => $this->image_dims['237_bfi_143'],
                'hide-sidebar-1'        => $this->image_dims['353_bfi_213'],
            );
            return $this->image_arr[$block_id];
        }

        // for blocks 09
        public function get_image_attr_block09($block_id) {
            $this->image_arr        = array
            (
                'multi-sidebar-1'       => $this->image_dims['post-thumb-2'],
                'multi-sidebar-2'       => $this->image_dims['167_bfi_120'],
                'sidebar-1'             => $this->image_dims['post-thumb-1'],
                'sidebar-2'             => $this->image_dims['237_bfi_143'],
                'hide-sidebar-1'        => $this->image_dims['1120_bfi_684'],
                'hide-sidebar-2'        => $this->image_dims['353_bfi_213'],
            );
            return $this->image_arr[$block_id];
        }

        // for blocks 11 and review
        public function get_image_attr_block11($block_id) {
            $this->image_arr        = array
            (
                'multi-sidebar-1'   => $this->image_dims['118_bfi_104'],
                'sidebar-1'         => $this->image_dims['170_bfi_150'],
                'hide-sidebar-1'    => $this->image_dims['258_bfi_227'],
            );
            return $this->image_arr[$block_id];
        }

        // for blocks 13
        public function get_image_attr_block13($block_id) {
            $this->image_arr        = array
            (
                'multi-sidebar-1'       => $this->image_dims['post-thumb-3'],
                'multi-sidebar-2'       => $this->image_dims['post-thumb-7'],
                'sidebar-1'             => $this->image_dims['post-thumb-9'],
                'sidebar-2'             => $this->image_dims['post-thumb-7'],
                'hide-sidebar-1'        => $this->image_dims['545_bfi_328'],
                'hide-sidebar-2'        => $this->image_dims['post-thumb-7'],
            );
            return $this->image_arr[$block_id];
        }

        // for carousel
        public function get_image_attr_carousel($block_id) {
            $this->image_arr        = array
            (
                'multi-sidebar-1'       => $this->image_dims['post-thumb-2'],
                'sidebar-1'             => $this->image_dims['post-thumb-1'],
                'hide-sidebar-1'        => $this->image_dims['1120_bfi_684'],
            );
            return $this->image_arr[$block_id];
        }


        // get image for loop-page-1 and loop-page-2
        public function get_image_loop_page_1($block_id, $image_full_height = false) {
            if ( $image_full_height ) {
                $this->image_arr        = array
                (
                    'left-sidebar'              => array( array(770, 1000), 770, '', 0 ),
                    'right-sidebar'             => array( array(770, 1000), 770, '', 0 ),
                    'multi-sidebar'             => array( array(560, 1000), 560, '', 0 ),
                    'multi-sidebar mid-left'    => array( array(560, 1000), 560, '', 0 ),
                    'hide-sidebar'              => array( array(1120, 1000), 1120, '', 0 ),
                );
            } else {
                $this->image_arr        = array
                (
                    'left-sidebar'              => $this->image_dims['post-thumb-1'],
                    'right-sidebar'             => $this->image_dims['post-thumb-1'],
                    'multi-sidebar'             => $this->image_dims['post-thumb-2'],
                    'multi-sidebar mid-left'    => $this->image_dims['post-thumb-2'],
                    'hide-sidebar'              => array( array(1120, 684), 1120, 684, 0 ),
                );
            }
            return $this->image_arr[$block_id];
        }


        // get image for loop-page-3 and loop-page-4
        public function get_image_loop_page_3($block_id, $image_full_height = false) {
            if ( $image_full_height ) {
                return array( array(1170, 2000), 1170, '', 0 );
            } else {
                return array( array(1170, 480), 1170, 480, 0 );
            }
        }


    }

}


if ( ! class_exists( 'MipTheme_ImageCat' ) ) {

    class MipTheme_ImageCat extends MipTheme_Image {

        public function __construct() {
            global $mp_weeklynews;
            $this->theme_layout     = ( isset($mp_weeklynews['_mp_theme_layout']) && ($mp_weeklynews['_mp_theme_layout'] == 'theme-unboxed')) ? 'unboxed' : 'boxed';

            if ( $this->theme_layout == 'boxed' ) {
                $this->image_dims       = array
                (
                    'post-thumb-1'  => array( 'post-thumb-1', 770, 470, 0 ),
                    'post-thumb-2'  => array( 'post-thumb-2', 560, 390, 0 ),
                    'post-thumb-3'  => array( 'post-thumb-3', 265, 160, 170 ),
                    'post-thumb-9'  => array( 'post-thumb-9', 370, 223, 340 ),
                    '1120_bfi_684'  => array( array(1120,684), 1120, 684, 0 ),
                    '545_bfi_328'   => array( array(545,328), 545, 328, 650 ),
                    '167_bfi_120'   => array( array(167,120), 167, 120, 0 ),
                    '353_bfi_213'   => array( array(353,213), 353, 213, 0 ),
                    '237_bfi_143'   => array( array(237,143), 237, 143, 0 ),
                );
            } else {
                $this->image_dims       = array
                (
                    'post-thumb-1'  => array( array(795,485), 795, 485, 0 ),
                    'post-thumb-2'  => array( array(610,425), 610, 425, 0 ),
                    'post-thumb-3'  => array( array(290,176), 290, 176, 170 ),
                    'post-thumb-9'  => array( array(383,231), 383, 231, 340 ),
                    '1120_bfi_684'  => array( array(1120,684), 1120, 684, 0 ),
                    '545_bfi_328'   => array( array(545,328), 545, 328, 650 ),
                    '167_bfi_120'   => array( array(183,132), 183, 132, 0 ),
                    '353_bfi_213'   => array( array(370,247), 370, 247, 0 ),
                    '237_bfi_143'   => array( array(245,148), 245, 148, 0 ),
                );
            }

        }


        // for cat 01 and 03
        public function get_image_attr_cat01($block_id) {
            $this->image_arr        = array
            (
                'multi-sidebar-1'       => $this->image_dims['post-thumb-2'],
                'multi-sidebar-2'       => $this->image_dims['post-thumb-3'],
                'sidebar-1'             => $this->image_dims['post-thumb-1'],
                'sidebar-2'             => $this->image_dims['post-thumb-9'],
                'hide-sidebar-1'        => $this->image_dims['1120_bfi_684'],
                'hide-sidebar-2'        => $this->image_dims['545_bfi_328'],
            );
            return $this->image_arr[$block_id];
        }


        // for cat 02 and 04
        public function get_image_attr_cat02($block_id) {
            $this->image_arr        = array
            (
                'multi-sidebar-1'       => $this->image_dims['post-thumb-3'],
                'sidebar-1'             => $this->image_dims['post-thumb-9'],
                'hide-sidebar-1'        => $this->image_dims['545_bfi_328'],
            );
            return $this->image_arr[$block_id];
        }


        // for cat 05
        public function get_image_attr_cat05($block_id) {
            $this->image_arr        = array
            (
                'multi-sidebar-1'       => $this->image_dims['post-thumb-2'],
                'multi-sidebar-2'       => $this->image_dims['167_bfi_120'],
                'sidebar-1'             => $this->image_dims['post-thumb-1'],
                'sidebar-2'             => $this->image_dims['237_bfi_143'],
                'hide-sidebar-1'        => $this->image_dims['1120_bfi_684'],
                'hide-sidebar-2'        => $this->image_dims['353_bfi_213'],
            );
            return $this->image_arr[$block_id];
        }

        // for cat 06
        public function get_image_attr_cat06($block_id) {
            $this->image_arr        = array
            (
                'multi-sidebar-1'       => $this->image_dims['167_bfi_120'],
                'sidebar-1'             => $this->image_dims['237_bfi_143'],
                'hide-sidebar-1'        => $this->image_dims['353_bfi_213'],
            );
            return $this->image_arr[$block_id];
        }

        // for cat 07
        public function get_image_attr_cat07($block_id) {
            $this->image_arr        = array
            (
                'multi-sidebar-1'       => $this->image_dims['post-thumb-2'],
                'sidebar-1'             => $this->image_dims['post-thumb-1'],
                'hide-sidebar-1'        => $this->image_dims['1120_bfi_684'],
            );
            return $this->image_arr[$block_id];
        }

        // for carousel
        public function get_image_attr_carousel($block_id) {
            $this->image_arr        = array
            (
                'multi-sidebar-1'       => $this->image_dims['post-thumb-2'],
                'sidebar-1'             => $this->image_dims['post-thumb-1'],
                'hide-sidebar-1'        => $this->image_dims['1120_bfi_684'],
            );
            return $this->image_arr[$block_id];
        }


    }

}
