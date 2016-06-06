<?php
/**
 * Plugin Name: Cooked - Extra Taxonomies
 * Plugin URI: http://cookedforwp.com
 * Description: Adds additional taxonomies to manage your recipes.
 * Author: danieliser
 * Version: 1.0.0
 * Author URI: http://danieliser.com
 * Text Domain: cooked-extra-taxonomies
 * @package     CKD
 * @author      Daniel Iser
 * @copyright   Copyright (c) 2016, Daniel Iser
 * @since       1.0.0
 */

// Create a helper function for easy SDK access.
function ckd_extax_fs() {
	global $ckd_extax_fs;

	if ( ! isset( $ckd_extax_fs ) ) {
		// Include Freemius SDK.
		require_once dirname( __FILE__ ) . '/includes/libraries/freemius/start.php';

		$ckd_extax_fs = fs_dynamic_init( array(
			'id'             => '300',
			'slug'           => 'cooked-extra-taxonomies',
			'public_key'     => 'pk_720bb6bba901ca1f3665a0b73f394',
			'is_premium'     => false,
			'has_addons'     => false,
			'has_paid_plans' => false,
			'menu'           => array(
				'slug'    => 'edit.php?post_type=recipe',
				'account' => true,
			),
		) );
	}

	return $ckd_extax_fs;
}

// Init Freemius.
/* Setup freemius */
//ckd_extax_fs();

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CKD_ExTax' ) ) {

	/**
	 * Main class
	 *
	 * @since       1.0.0
	 */
	class CKD_ExTax {

		/**
		 * @var         CKD_ExTax $instance The one true CKD_ExTax
		 * @since       1.0.0
		 */
		private static $instance;

		public $post_types;


		/**
		 * @var string $text_domain for I10n
		 */
		public $td = 'cooked-extra-taxonomies';

		/**
		 * Get active instance
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      object self::$instance The one true CKD_ExTax
		 */
		public static function instance() {
			if ( ! self::$instance ) {
				self::$instance = new CKD_ExTax();
				self::$instance->setup_constants();

				add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
				add_filter( 'ckd_template_paths', array( self::$instance, 'template_paths' ) );

				self::$instance->includes();
			}

			return self::$instance;
		}

		public static $VER = '1.0.0';
		public static $DIR = '';
		public static $URL = '';
		public static $FILE = '';


		/**
		 * Setup plugin constants
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function setup_constants() {
			self::$DIR  = $this->plugin_path();
			self::$URL  = $this->plugin_url();
			self::$FILE = __FILE__;
		}

		/**
		 * Include necessary files
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function includes() {
			require_once self::$DIR . 'includes/ckd-extax-template-functions.php';
			require_once self::$DIR . 'includes/class-ckd-extax-taxonomies.php';
		}

		/**
		 * Internationalization
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      void
		 */
		public function load_textdomain() {
			// Set filter for language directory
			$lang_dir = CKD_PLUGIN_DIR . '/languages/';
			$lang_dir = apply_filters( 'ckd_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), 'cooked-extra-taxonomies' );
			$mofile = sprintf( '%1$s_%2$s.mo', 'cooked-extra-taxonomies', $locale );

			// Setup paths to current locale file
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/cooked/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				load_textdomain( 'cooked-extra-taxonomies', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				load_textdomain( 'cooked-extra-taxonomies', $mofile_local );
			} else {
				load_plugin_textdomain( 'cooked', false, $lang_dir );
			}
		}

		/**
		 * Get the plugin url.
		 * @return string
		 */
		public function plugin_url() {
			return plugins_url( '/', __FILE__ );
		}

		/**
		 * Get the plugin path.
		 * @return string
		 */
		public function plugin_path() {
			return plugin_dir_path( __FILE__ );
		}

		/**
		 * Get Ajax URL.
		 * @return string
		 */
		public function ajax_url() {
			return admin_url( 'admin-ajax.php', 'relative' );
		}

		public function template_path() {
			return self::$DIR . 'templates';
		}
		
		public function template_paths( $file_paths = array() ) {
			$key                = max( array_keys( $file_paths ) ) + 1;
			$file_paths[ $key ] = $this->template_path();

			return $file_paths;
		}

	}
} // End if class_exists check

/**
 * The main function responsible for returning the one true CKD
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * @return object The one true CKD_ExTax Instance
 */
function CKD_ExTax() {
	return CKD_ExTax::instance();
}

// Get It Running
CKD_ExTax();

function ckd_extax_activation( $network_wide = false ) {

}

register_activation_hook( __FILE__, 'ckd_extax_activation' );