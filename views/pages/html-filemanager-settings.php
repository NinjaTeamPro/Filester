<?php
defined('ABSPATH') || exit;
if( isset( $_POST ) && !empty( $_POST ) ){
  if( ! wp_verify_nonce( $_POST['njt-fm-settings-security-token'] ,'njt-fm-settings-security-token') || !current_user_can( 'manage_options' ) ) wp_die();
 
  $this->options['file_manager_settings']['root_folder_path']  = filter_var($_POST['root_folder_path'], FILTER_SANITIZE_STRING) ? str_replace("\\\\", "/", $_POST['root_folder_path']) : '';
  $this->options['file_manager_settings']['enable_htaccess'] =  isset($_POST['enable_htaccess']) ? sanitize_text_field($_POST['enable_htaccess']) : 0;
  $this->options['file_manager_settings']['upload_max_size'] =  filter_var($_POST['upload_max_size'], FILTER_SANITIZE_STRING)  ? sanitize_text_field($_POST['upload_max_size']) : 0;	
}

?>
<div class="njt-fm-settings">
  <div class="njt-fm-settings-content">
    <div class="settings-title">
      <h1> Settings </h1>
    </div>
    <form action="" class="settings-form" method="POST">
      <!-- creat token -->
      <input type='hidden' name='njt-fm-settings-security-token'
        value='<?php echo wp_create_nonce('njt-fm-settings-security-token'); ?>'>

      <table class="form-table">
        <!-- URL and Path -->
        <tr>
          <th>URL and Path</th>
          <td>
            <label for="root_folder_path"> Root Folder Path </label>
            <input type='text' name='root_folder_path' id='root_folder_path' style="width: 20%"
              value='<?php  if( isset( $this->options['file_manager_settings']['root_folder_path'] ) && !empty( $this->options['file_manager_settings']['root_folder_path'] ) ) echo esc_attr($this->options['file_manager_settings']['root_folder_path']); ?>' />
            <div class="des-path">
              <small>File Manager Pro Root Path, you can change according to your choice</small>
            </div>
            <small>
              <?php _e("Default Path:", 'file-manager'); ?>
              <b><?php echo (str_replace("\\", "/", ABSPATH));?></b>
            </small>
          </td>
        </tr>
        <!-- Maximum Upload Size -->
        <tr>
          <th>Maximum Upload Size</th>
          <td>
            <input type="text" name="upload_max_size" id="upload_max_size"
              value="<?php  if( isset( $this->options['file_manager_settings']['upload_max_size'] ) && !empty( $this->options['file_manager_settings']['upload_max_size'] )) echo esc_attr($this->options['file_manager_settings']['upload_max_size']); ?>">
            <strong>MB</strong>
            <div class="des-path">
              <small>
                <?php _e("Default:", 'file-manager'); ?>
                <b>0 means unlimited upload.</b>
              </small>
            </div>
          </td>
        </tr>
        <!-- .htaccess -->
        <tr>
          <th>Display .htaccess?</th>
          <td>
            <input name="enable_htaccess" type="checkbox" id="enable_htaccess" value="1"
              <?php echo isset($this->options['file_manager_settings']['enable_htaccess']) && ($this->options['file_manager_settings']['enable_htaccess'] == '1') ? 'checked="checked"' : '';?>>
            <p class="description">Will Display .htaccess file (if exists) in file manager.</p>
            <p>Default: <code>Not Enabled</code></p>
          </td>
        </tr>
        <!-- button submit -->
        <tr>
          <td></td>
          <td>
            <p class="submit">
              <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
            </p>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>