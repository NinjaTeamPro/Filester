<?php
namespace NinjaFileManager\File_manager;

defined('ABSPATH') || exit;

/**
 * Settings Page
 */

class FileManager {
  protected static $instance = null;

  public static function getInstance() {
    if (null == self::$instance) {
      self::$instance = new self;
    }

    return self::$instance;
  }

  private function __construct() {
    add_action('admin_menu', array($this, 'FileManager'));
    add_action('admin_enqueue_scripts', array($this, 'enqueueAdminScripts'));
    add_action('wp_ajax_connector', array($this, 'connector'));
    add_action('wp_ajax_nopriv_connector', array($this, 'connector'));
  }

  public function FileManager() {
    add_menu_page(
      __('Custom Menu Title', 'textdomain'),
      'File Manager',
      'manage_options',
      'custompage',
      array($this, 'ffm_settings_callback'),
      '',
      9
    );
  }

  public function ffm_settings_callback() {
    $viewPath = BN_PLUGIN_PATH . 'views/pages/html-filemanager.php';
    include_once $viewPath;
  }

  public function enqueueAdminScripts() {
    //elfinder css
    wp_enqueue_style('elfinder.jq.css', plugins_url('/lib/jquery/jquery-ui-1.12.0.css', __FILE__));
    wp_enqueue_style('elfinder.full.css', plugins_url('/lib/css/elfinder.full.css', __FILE__));
    wp_enqueue_style('elfinder.min.css', plugins_url('/lib/css/elfinder.min.css', __FILE__));
    wp_enqueue_style('themesda', plugins_url('/lib/css/theme.css', __FILE__));
    //elfinder core
    wp_enqueue_script('jquery_min', plugins_url('/lib/jquery/jquery-ui.min.js', __FILE__));
    wp_enqueue_script('elFinderd', plugins_url('/lib/js/elfinder.full.js', __FILE__));
    wp_enqueue_script('elfinder_editor', plugins_url('/lib/js/extras/editors.default.js', __FILE__));

    //elfinder js
    wp_enqueue_script('file_manager_admin', BN_PLUGIN_URL . 'assets/js/file_manager_admin.js', array('jquery'), BN_VERSION);
  }


	//File manager connector function

	public function connector(){

		// Allowed mime types
		$wp_upload_dir = wp_upload_dir();
	
		$opts = array(
      'bind' => array(
				'put.pre' => array(new \FMPHPSyntaxChecker, 'checkSyntax'), // Syntax Checking.
			),
      'roots'  => array(
          array(
              'driver' => 'LocalFileSystem',
              'path'   => ABSPATH,
              'URL'    => site_url(),
          )
      )
  );

		$connector = new \elFinderConnector(new \elFinder($opts));
    $connector->run();
		wp_die();
	}
}