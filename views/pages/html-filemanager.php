<?php
defined('ABSPATH') || exit;
$lang = !empty( $this->options['file_manager_settings']['fm_locale']) ? $this->options['file_manager_settings']['fm_locale'] : ''; 
?>
<div class="njt-file-manager">
  <div class="njt-fm-select-theme">
    <div>
      <h1><?php _e("File Manager Pro", 'njt-file-manager'); ?></h1>
    </div>
    <div class="select-theme-content">
      <?php    
      $selectedTheme = get_option('njt_fm_selector_themes') && get_option('njt_fm_selector_themes')[$this->userRole]['themesValue'] ? get_option('njt_fm_selector_themes')[$this->userRole]['themesValue'] : null;
    ?>

      <h3 class="select-theme-title"><?php _e("Select theme:", 'njt-file-manager'); ?></h3>
      <select name="selector-themes" id="selector-themes">
        <option value="Default">Default Elfinder</option>
        <option value="dark-slim">Dark Slim</option>
        <option value="Material">Material</option>
        <option value="Material-Gray">Material Gray</option>
        <option value="Material-Light">Material Light</option>
        <option value="Windows-10">Windows 10</option>
      </select>
      <input type="hidden" name="selected-theme" value="<?php echo ($selectedTheme) ?>">

    </div>
  </div>

  <div class="clear"></div>
  <div id="wp_file_manager">
  </div>
</div>


<script>
PLUGINS_URL = '<?php echo plugins_url(); ?>';

jQuery(document).ready(function() {
  console.log(ajaxurl)
  jQuery('#wp_file_manager').elfinder({
    url: ajaxurl,
    contextmenu: {
      // current directory file menu
      files: ['getfile', '|', 'open', 'opennew', 'download', 'opendir', 'quicklook', 'email', '|', 'upload',
        'mkdir', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', 'empty', '|', 'rename', 'edit',
        'resize', '|', 'archive', 'extract', '|', 'selectall', 'selectinvert', '|', 'places', 'info', 'chmod',
        'netunmount'
      ],
      // navbarfolder menu
      navbar: ['open', 'opennew', 'download', '|', 'upload', 'mkdir', '|', 'copy', 'cut', 'paste', 'duplicate',
        '|', 'rm', 'empty', '|', 'rename', '|', 'archive', '|', 'places', 'info', 'chmod', 'netunmount'
      ],
      // current directory menu
      cwd: ['undo', 'redo', '|', 'back', 'up', 'reload', '|', 'upload', 'mkdir', 'mkfile', 'paste', '|',
        'empty', '|', 'view', 'sort', 'selectall', 'colwidth', '|', 'places', 'info', 'chmod', 'netunmount',
        '|', 'fullscreen', '|'
      ],
    },
    uiOptions: {
      // toolbar configuration
      toolbar: [
        ['home', 'back', 'forward', 'up', 'reload'],
        ['netmount'],
        ['mkdir', 'mkfile', 'upload'],
        ['open', 'download', 'getfile'],
        ['undo', 'redo'],
        ['copy', 'cut', 'paste', 'rm', 'empty'],
        ['duplicate', 'rename', 'edit', 'resize', 'chmod'],
        ['selectall', 'selectnone', 'selectinvert'],
        ['quicklook', 'info'],
        ['extract', 'archive'],
        ['search'],
        ['view', 'sort'],
        ['help'],
        ['fullscreen']
      ],
    },
    ui: ['toolbar', 'tree', 'path', 'stat'],
    customData: {
      action: 'connector',
      nonce: '<?php echo wp_create_nonce( "file-manager-security-token" ); ?>'
    },
    lang: '<?php echo ($lang)?>',
    requestType: 'post',
    width: 'auto',
    height: '600',
  });
});
</script>