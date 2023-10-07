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

    // create slug for WC_Product_Short_Title
    private $slug = 'wc-product-short-title';

    // execute all the default methods
    public function __construct(){

        // settings link
        add_filter( 'plugin_action_links', [ $this, 'settings_page'], 10, 2 );

        // documentation
        add_filter( 'plugin_row_meta', [ $this, 'documentation' ], 10, 2 );

        // create admin menu page
        add_action( 'admin_menu', [ $this, 'admin_menu_page' ] );

        // create product shortcode
        add_shortcode( 'product_info', [ $this, 'get_product_details'] );

        // enqueu the stylesheet
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_stylesheet' ] );
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
     * create settings page
     *
     * @param [type] $links
     * @param [type] $file
     * @return void
     */
    public function settings_page( $links, $file ){
        if( plugin_basename( __FILE__ ) === $file ){
            $url = esc_url( admin_url( "admin.php?page={$this->slug}" ) );
            $download_url = 'https://github.com/vxlrubel/wc-product-with-short-title/archive/refs/heads/main.zip';
            $settings = "<a href=\"{$url}\">Settings</a> | ";
            $settings .= "<a href=\"{$download_url}\">Download</a>";
            array_unshift( $links, $settings );
        }
        return $links;
    }

    /**
     * create a admin menu page
     *
     * @return void
     */
    public function admin_menu_page(){
        add_submenu_page(
            'woocommerce',                        // parent slug
            'WC Product Short Title',             // page title
            'WC Product Short Title',             // menu title
            'edit_posts',                         // capability
            $this->slug,                          // menu slug
            [ $this, '_ch_product_short_title'],  // callback
            110                                   // position
        );
    }

    /**
     * admin menu page callback
     *
     * @return void
     */
    public function _ch_product_short_title(){
        require_once dirname(__FILE__) . '/inc/admin-menu-page.php';
    }

    /**
     * get the product
     *
     * @param [type] $atts
     * @return void
     */
    public function get_product_details( $atts ){

        ob_start();

        $atts = shortcode_atts(
            [
                'count'  => 4,
                'letter' => 30
            ],
            $atts
        );

        $args = [
            'post_type'      => 'product',
            'posts_per_page' => $atts['count']
        ];

        $qry = new WP_Query( $args );

        if( $qry->have_posts() ):
            require_once dirname(__FILE__) . '/inc/get-product-info.php';
        else:
            echo 'No Product Found';
        endif;

        
        return ob_get_clean();
    }

    /**
     * enqueue stylesheet
     *
     * @return void
     */
    public function enqueue_stylesheet(){
        // enqueue stylesheet
        wp_enqueue_style( 'wc-product-short-title', plugins_url( 'assets/css/main.css', __FILE__ ) );

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