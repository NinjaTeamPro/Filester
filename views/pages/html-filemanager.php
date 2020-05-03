<?php
defined('ABSPATH') || exit;
$lang = !empty( $this->options['file_manager_settings']['fm_locale']) ? $this->options['file_manager_settings']['fm_locale'] : ''; 
?>
<div class="njt-file-manager">
  <div class="njt-fm-select-theme">
    <div>
      <h1> File Manager Pro </h1>
    </div>
    <div class="select-theme-content">
      <?php    
      $selectedTheme = get_option('selector_themes') ? get_option('selector_themes') : null;
    ?>

      <h3 class="select-theme-title">Select theme:</h3>
      <select name="selector-themes" id="selector-themes">
        <option value="Default">Default Elfinder</option>
        <option value="bootstrap">Bootstrap</option>
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
        'mkdir', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', 'empty', 'hide', '|', 'rename', 'edit',
        'resize', '|', 'archive', 'extract', '|', 'selectall', 'selectinvert', '|', 'places', 'info', 'chmod',
        'netunmount'
      ]
    },
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