<?php
defined('ABSPATH') || exit;
if( isset( $_POST ) && !empty( $_POST ) ){
  if( ! wp_verify_nonce( $_POST['njt-fm-settings-security-token'] ,'njt-fm-settings-security-token') || !current_user_can( 'manage_options' ) ) wp_die();
  echo (sanitize_text_field($_POST['root_folder_path']));
  $this->options['file_manager_settings']['root_folder_path']  = filter_var($_POST['root_folder_path'], FILTER_SANITIZE_STRING) ? str_replace("\\\\", "/", $_POST['root_folder_path']) : '';
	$this->options['file_manager_settings']['root_folder_url']  = filter_var($_POST['root_folder_url'], FILTER_SANITIZE_STRING) ? $_POST['root_folder_url'] : '';
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
        <tr>
          <th>URL and Path</th>
          <td>
            <label for="root_folder_path"> Root Folder Path </label>
            <input type='text' name='root_folder_path' id='root_folder_path'
              value='<?php  if( isset( $this->options['file_manager_settings']['root_folder_path'] ) && !empty( $this->options['file_manager_settings']['root_folder_path'] ) ) echo esc_attr($this->options['file_manager_settings']['root_folder_path']); ?>' />


            <label for="root_folder_url"> Root Folder URL </label>
            <input type='text' name='root_folder_url' id='root_folder_url'
              value='<?php  if( isset( $this->options['file_manager_settings']['root_folder_url'] ) && !empty( $this->options['file_manager_settings']['root_folder_url'] ) ) echo esc_attr($this->options['file_manager_settings']['root_folder_url']); ?>' />
          </td>
        </tr>
        <tr>
          <th class="njt-fm-pd-0"></th>
          <td class="njt-fm-pd-0">
            <small><?php _e("Default Path:", 'file-manager'); ?> <b><?php echo ABSPATH;?></b></small>
          </td>
        </tr>
        <tr>
          <th class="njt-fm-pd-0"></th>
          <td class="njt-fm-pd-0">
            <small><?php _e("Default URL:", 'file-manager'); ?> <b><?php echo site_url();?></b></small>
          </td>
        </tr>
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