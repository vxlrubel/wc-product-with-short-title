<?php
/*
Plugin Name: WC Product Short Title
Description: The WC Product Short Title plugin is your ultimate solution for enhancing the product presentation on your WooCommerce-powered WordPress website. With this intuitive and lightweight plugin, you can effortlessly retrieve and display concise product titles, providing your customers with a clearer and more efficient shopping experience.
Version: 1.0
Author: Rubel Mahmud
Author URi: https://www.linkedin.com/in/vxlrubel
*/


// directly access deniyed
defined('ABSPATH') || exit;

class WC_Product_Short_Title{
    // create singletone instance
    private static $instance;

    // execute all the default methods
    public function __construct(){

        // documentation
        add_filter( 'plugin_row_meta', [ $this, 'documentation' ], 10, 2 );
    }

    /**
     * create documentation page
     *
     * @param [type] $meta
     * @param [type] $file
     * @return void
     */
    public function documentation( $meta, $file ){
        if( plugin_basename( __FILE__) === $file ){
            $url = 'https://github.com/vxlrubel/wc-product-with-short-title';
            $meta[] = "<a href=\"{$url}\" target=\"_blank\">Documentation</a>";
        }
        return $meta;
    }


    /**
     * create single tone instace
     *
     * @return void
     */
    public static function init(){
        if( is_null(self::$instance) )
            self::$instance = new self();
        return self::$instance;
    }
}

if( ! function_exists('wc_product_short_title') ){
    function wc_product_short_title(){
        return WC_Product_Short_Title::init();
    }
}
wc_product_short_title();