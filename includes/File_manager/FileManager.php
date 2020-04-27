<?php
namespace NinjaFileManager\File_manager;

defined('ABSPATH') || exit;

/**
 * Settings Page
 */

class FileManager
{
    protected static $instance = null;
    
    /**
     *
     * @var object $options The object of the options class
     *
     * */
    public $options;
    
    public static function getInstance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    private function __construct()
    {
        // Loading Options
        // Options
		$this->options = get_option('njt-fm-settings');
        if(empty($this->options)) {
            $this->options = array( // Setting up default values
                'file_manager_settings' => array(
                    'root_folder_path' =>  ABSPATH,
                    'root_folder_url' => site_url()
                ),
            );
        }
        register_shutdown_function(array($this, 'save_options'));


        add_action('admin_menu', array($this, 'FileManager'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueAdminScripts'));
        add_action('wp_ajax_connector', array($this, 'connector'));
        add_action('wp_ajax_selector_themes', array($this, 'selector_themes'));
    }

    public function FileManager()
    {
        add_menu_page(
            __('Custom Menu Title', 'textdomain'),
            'File Manager',
            'manage_options',
            'custompage',
            array($this, 'ffmViewFileCallback'),
            '',
            9
        );
        add_submenu_page ('custompage',
          'Settings',
          'Settings', 
          'manage_options', 
          'plugin-options-general-settings',
          array($this, 'ffmSettingsPage') );
       
    }

    public function ffmViewFileCallback()
    {
        $viewPath = BN_PLUGIN_PATH . 'views/pages/html-filemanager.php';
        include_once $viewPath;
    }

    public function ffmSettingsPage()
    {
        $viewPath = BN_PLUGIN_PATH . 'views/pages/html-filemanager-settings.php';
        include_once $viewPath;
    }

    public function enqueueAdminScripts()
    {
        if (empty(get_option('selector_themes'))) {
            update_option('selector_themes', 'Default');
        }
        $selectedTheme = get_option('selector_themes');

        //elfinder css
        wp_enqueue_style('elfinder.jq.css', plugins_url('/lib/jquery/jquery-ui-1.12.0.css', __FILE__));
        wp_enqueue_style('elfinder.full.css', plugins_url('/lib/css/elfinder.full.css', __FILE__));
        wp_enqueue_style('elfinder.min.css', plugins_url('/lib/css/elfinder.min.css', __FILE__));
        wp_enqueue_style('themes-selector', plugins_url('/lib/themes/' . $selectedTheme . '/css/theme.css', __FILE__));
        wp_enqueue_style('themesda', plugins_url('/lib/css/theme.css', __FILE__));
       
        //elfinder core
        wp_enqueue_script('jquery_min', plugins_url('/lib/jquery/jquery-ui.min.js', __FILE__));
        wp_enqueue_script('elFinderd', plugins_url('/lib/js/elfinder.full.js', __FILE__));
        wp_enqueue_script('elfinder_editor', plugins_url('/lib/js/extras/editors.default.js', __FILE__));

        //elfinder js, css custom
        wp_register_style('file_manager_admin_css',BN_PLUGIN_URL . 'assets/css/file_manager_admin.css');
        wp_enqueue_style('file_manager_admin_css');
        wp_enqueue_script('file_manager_admin', BN_PLUGIN_URL . 'assets/js/file_manager_admin.js', array('jquery'), BN_VERSION);
        wp_localize_script('file_manager_admin', 'wpData', array(
            'admin_ajax' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce("njt-file-manager-admin"),
        ));
    }

    //File manager connector function

    public function connector()
    {
        $uploadMaxSize = isset($this->options['file_manager_settings']['upload_max_size']) && !empty($this->options['file_manager_settings']['upload_max_size']) ? $this->options['file_manager_settings']['upload_max_size'] : 0;

        $opts = array(
            'bind' => array(
                'put.pre' => array(new \FMPHPSyntaxChecker, 'checkSyntax'), // Syntax Checking.
                'archive.pre back.pre chmod.pre colwidth.pre copy.pre cut.pre duplicate.pre editor.pre put.pre extract.pre forward.pre fullscreen.pre getfile.pre help.pre home.pre info.pre mkdir.pre mkfile.pre netmount.pre netunmount.pre open.pre opendir.pre paste.pre places.pre quicklook.pre reload.pre rename.pre resize.pre restore.pre rm.pre search.pre sort.pre up.pre upload.pre view.pre zipdl.pre' => array(&$this, 'security_check'),
            ),
            'roots' => array(
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => isset($this->options['file_manager_settings']['root_folder_path']) && !empty($this->options['file_manager_settings']['root_folder_path']) ? $this->options['file_manager_settings']['root_folder_path'] : ABSPATH,
                    'URL' => isset($this->options['file_manager_settings']['root_folder_url']) && !empty($this->options['file_manager_settings']['root_folder_url']) ? $this->options['file_manager_settings']['root_folder_url'] :site_url(),
                    'trashHash'     => '', // default is empty, when not enable trash
                    'uploadMaxSize' =>  $uploadMaxSize .'M',
                    'winHashFix'    => DIRECTORY_SEPARATOR !== '/', 
                    'uploadDeny'    => array(''), 
                    'uploadAllow'   => array('all'),
                    'uploadOrder'   => array('deny', 'allow'),
                    'accessControl' => 'access'
                ),
            ),
        );
        // .htaccess
        if(isset($this->options['file_manager_settings']['enable_htaccess']) && ($this->options['file_manager_settings']['enable_htaccess'] == '1')) {
            $attributes =  array(
                array( 
                    'pattern' => '/.htaccess/',
                    'read' => false,
                    'write' => false,
                    'hidden' => true,
                    'locked' => false
                )
            );
            $opts['roots'][0]['attributes'] = $attributes;
        }

        //Enable Trash
        if(isset($this->options['file_manager_settings']['enable_trash']) && ($this->options['file_manager_settings']['enable_trash'] == '1')) {
            $trash = array(
                'id'            => '1',
                'driver'        => 'Trash',
                'path'          => BN_PLUGIN_PATH.'includes/File_manager/lib/files/.trash/',
                'tmbURL'        => site_url() . '/includes/File_manager/lib/files/.trash/.tmb',
                'winHashFix'    => DIRECTORY_SEPARATOR !== '/', 
                'uploadDeny'    => array(''), 
                'uploadAllow'   => array('all'),
                'uploadOrder'   => array('deny', 'allow'),
                'accessControl' => 'access',
                'attributes' => array(
                    array(
                              'pattern' => '/.tmb/',
                              'read' => false,
                              'write' => false,
                              'hidden' => true,
                              'locked' => false
                             ),
                    array(
                        'pattern' => '/.gitkeep/',
                        'read' => false,
                        'write' => false,
                        'hidden' => true,
                        'locked' => false
                  )
                 )
            );
            $opts['roots'][0]['trashHash'] = 't1_Lw';
            $opts['roots'][1] = $trash;
        }

        $connector = new \elFinderConnector(new \elFinder($opts));
        $connector->run();
        wp_die();
    }

    public function security_check(){
		if( ! wp_verify_nonce( $_POST['nonce'] ,'file-manager-security-token') || !current_user_can( 'manage_options' ) ) wp_die();
		check_ajax_referer('file-manager-security-token', 'nonce');
    }
    
    public function selector_themes()
    {
        if( ! wp_verify_nonce( $_POST['nonce'] ,'njt-file-manager-admin') || !current_user_can( 'manage_options')) wp_die();
        check_ajax_referer('njt-file-manager-admin', 'nonce', true);
        $themesValue = sanitize_text_field ($_POST['themesValue']);
        $selector_themes = get_option('selector_themes');
        if (empty($selector_themes) || $selector_themes != $themesValue) {
            update_option('selector_themes', $themesValue);
        }
        $selected_themes = get_option('selector_themes');
        $linkThemes = plugins_url('/lib/themes/' . $themesValue . '/css/theme.css', __FILE__);
        wp_send_json_success($linkThemes);
        wp_die();
    }

    /**
	 *
	 * @function save_options
	 *
	 * */
	public function save_options(){
		update_option('njt-fm-settings', $this->options);
	}

}