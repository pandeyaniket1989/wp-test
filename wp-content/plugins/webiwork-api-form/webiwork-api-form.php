<?php
/**

 * Plugin Name: Profile Management

 * Description: Enables the WordPress to company form

 * Version:     1.0
  
 * Text Domain: webiwork-api-form

 * Domain Path: /languages

 */
if ( ! defined( 'ABSPATH' ) ) {

	die( 'Invalid request.' );
}
  

add_action( 'plugins_loaded', 'webiwork_api_company_form_init' );
function webiwork_api_company_form_init() {
    //load plugin textdomain
    load_plugin_textdomain( 'webiwork-api-form', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
 
    if ( ! class_exists( 'Company_Profile_Management' ) ) :

        define( 'CCPC_CUSTOM_MAIN_FILE', __FILE__ );

        define( 'CCPC_CUSTOM_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );

        define( 'CCPC_CUSTOM_PLUGIN_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

        class Company_Profile_Management {
            /**
             * @var Company_Profile_Management The reference the *Company_Profile_Management* instance of this class
             */
            private static $instance;

            /**
             * Returns the *Company_Profile_Management* instance of this class.
             *
             * @return Company_Profile_Management The *Company_Profile_Management* instance.
             */
            public static function get_instance() {
                if ( null === self::$instance ) {
                    self::$instance = new self();
                }
                return self::$instance;
            } 

            /**
             * Protected constructor to prevent creating a new instance of the
             * *Company_Profile_Management* via the `new` operator from outside of this class.
             */

            private function __construct()
            {
                add_action( 'init', array( $this, 'init_hooks' ) );
            }

            /**
             * Init the plugin after plugins_loaded so environment variables are set.
             *
             * @since 1.0.0
             * @version 1.0.0
             */
            public function init_hooks(){
                if(is_admin()) {
                    //admin
                    require_once dirname( __FILE__ ) . '/includes/admin/class-ccpc-admin.php';
                }
                //helpers
                require_once dirname( __FILE__ ) . '/includes/class-ccpc-helper.php';
                
                //ccpc base classes 
                require_once dirname( __FILE__ ) . '/includes/class-ccpc-base.php'; 

                //Ajax class
                require_once dirname( __FILE__ ) . '/includes/class-ccpc-ajax.php';
            }

        }
        Company_Profile_Management::get_instance();
    endif;
} 