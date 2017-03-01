<?php
/**
 * Plugin Name: LearnDash Quiz Hooks Generator
 * Plugin URI: https://wooninjas.com
 * Description: Enables developers to create the missing hooks to extend the capabilities of deafult LearnDash Quiz
 * Version: 1.0.0
 * Author: WooNinjas
 * Author URI: https://wooninjas.com
 * Text Domain: LDHG
 * License: GPLv2 or later
 */


namespace LDHG;
if (!defined("ABSPATH")) exit;

// Directory
define('LDHG\DIR', plugin_dir_path(__FILE__));
define('LDHG\DIR_FILE', DIR . basename(__FILE__));
define('LDHG\OVERRIDE_DIR', trailingslashit(DIR . 'lib'));

// URLS
define('LDHG\URL', trailingslashit(plugins_url('', __FILE__)));

/**
 * Main Plugin Class
 *
 * @since 1.0
 */
if(!class_exists('LearnDash_Quiz_Hooks_Generator')) {
    
    class LearnDash_Quiz_Hooks_Generator {
        private $required_plugins = array('sfwd-lms/sfwd_lms.php');
        private static $version = '1.0.0';
        private $wp_plugin_dir;
        private $wp_pro_quiz_dir;


        // Main instance
        protected static $_instance = null;


        public function __construct() {
            if (!$this->have_required_plugins()){
                return;
            }

            $this->wp_plugin_dir = plugin_dir_path(__FILE__);
            $this->wp_pro_quiz_dir = dirname($this->wp_plugin_dir) . DIRECTORY_SEPARATOR . "sfwd-lms". DIRECTORY_SEPARATOR . "includes". DIRECTORY_SEPARATOR . "vendor". DIRECTORY_SEPARATOR . "wp-pro-quiz";

            register_activation_hook(__FILE__, array($this, 'activation'));
            register_deactivation_hook(__FILE__, array($this, 'deactivation'));
            add_action('plugins_loaded', array($this,'init'));
        }
        
        /**
         * Plugin load function
         * Removes WP Pro Quiz autoload and instantiate our own autoload
         * @return void
        */
        public function init() {
            spl_autoload_unregister('wpProQuiz_autoload');
            spl_autoload_register(array($this,'wp_pro_quiz_autoload_custom'));
        }

        /**
         * Check if Dependency loaded
         *
         * @return bool
        */
        public function have_required_plugins() {
            if (empty($this->required_plugins))
                return true;

            $active_plugins = (array) get_option('active_plugins', array());
            
            if (is_multisite()) {
                $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
            }

            foreach ($this->required_plugins as $key => $required) {
                $required = "sfwd-lms/sfwd_lms.php";
                if (!in_array($required, $active_plugins) && !array_key_exists($required, $active_plugins))
                    return false;
            }
            return true;
        }

        /**
         * @return $version
        */
        public static function get_version() {
            return self::$version;
        }

        /**
         * @return $this
        */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * Activation function hook
         *
         * @return void
        */
        public static function activation() {
            if (!current_user_can('activate_plugins'))
                return;

            update_option('LDHG_version', self::get_version());
        }

        /**
         * Deactivation function hook
         * No used in this plugin
         *
         * @return void
        */
        public static function deactivation() {}

        /**
         * Check if Class overrided 
         * @return boolean
        */
        public function checkClassOverride($load_class) {
            $class_list = [];
            $dirs = array_filter(glob(OVERRIDE_DIR . DIRECTORY_SEPARATOR . "*"), 'is_dir');
            foreach($dirs as $dir) {
                $dh  = opendir($dir);
                if (is_dir($dir)) {
                    while (false !== ($filename = readdir($dh))) {
                        $pos = strpos($filename, ".php");
                        if($pos !== false) {
                            $class_list[] = str_replace(".php", "", $filename);
                        }
                    }
                }
                closedir($dh);
            }

            if(in_array($load_class, $class_list)) {
                return true;
            } else {
                return false;
            }
        }

        private function wp_pro_quiz_autoload_custom($class) {
            $c = explode('_', $class);

            if($c === false || count($c) != 3 || $c[0] !== 'WpProQuiz')
                return;

            $dir = '';

            switch ($c[1]) {
                case 'View':
                    $dir = 'view';
                    break;
                case 'Model':
                    $dir = 'model';
                    break;
                case 'Helper':
                    $dir = 'helper';
                    break;
                case 'Controller':
                    $dir = 'controller';
                    break;
                case 'Plugin':
                    $dir = 'plugin';
                    break;
                default:
                    return;
            }

            $overriden = $this->checkClassOverride($class);
            
            if($overriden) {
                $dyn_dir = $this->wp_plugin_dir; //Override class with current plugin
            } else {
                $dyn_dir = $this->wp_pro_quiz_dir;
            }

            if(file_exists($dyn_dir.'/lib/'.$dir.'/'.$class.'.php')) {
                include_once $dyn_dir.'/lib/'.$dir.'/'.$class.'.php';
            }
        }

    }
}

$LearnDash_Quiz_Hooks_Generator = new LearnDash_Quiz_Hooks_Generator;

