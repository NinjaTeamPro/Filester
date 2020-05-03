<?php
defined('ABSPATH') || exit;
$viewPathLanguage = BN_PLUGIN_PATH . 'views/pages/html-filemanager-language.php';
$viewUserRoleRestrictions = BN_PLUGIN_PATH . 'views/pages/html-filemanager-user-role-restrictions.php';
global $wp_roles;
if( isset( $_POST ) && !empty( $_POST ) && !empty($_POST['njt-settings-form-submit'])){
  if( ! wp_verify_nonce( $_POST['njt-fm-settings-security-token'] ,'njt-fm-settings-security-token')) wp_die();

  $this->options['file_manager_settings']['root_folder_path']  = filter_var($_POST['root_folder_path'], FILTER_SANITIZE_STRING) ? str_replace("\\\\", "/", $_POST['root_folder_path']) : '';
  $this->options['file_manager_settings']['enable_htaccess'] =  isset($_POST['enable_htaccess']) ? sanitize_text_field($_POST['enable_htaccess']) : 0;
  $this->options['file_manager_settings']['enable_trash'] =  isset($_POST['enable_trash']) ? sanitize_text_field($_POST['enable_trash']) : 0;
  $this->options['file_manager_settings']['upload_max_size'] =  filter_var($_POST['upload_max_size'], FILTER_SANITIZE_STRING) ? sanitize_text_field($_POST['upload_max_size']) : 0;
  $this->options['file_manager_settings']['fm_locale'] = filter_var($_POST['fm_locale'], FILTER_SANITIZE_STRING) ? sanitize_text_field($_POST['fm_locale']) : 'en';
  $this->options['file_manager_settings']['list_user_alow_access'] = filter_var($_POST['list_user_alow_access'], FILTER_SANITIZE_STRING) ? explode(',',$_POST['list_user_alow_access']) : array();
}

?>
<div class="njt-fm-settings njt-file-manager">
  <h1 id="njt-plugin-tabs" class="nav-tab-wrapper hide-if-no-js">
    <a href="javascript:void(0)" class="nav-tab nav-tab-active">Settings</a>
    <a href="javascript:void(0)" class="nav-tab">User Role Restrictions</a>
  </h1>
  <div class="njt-fm-settings-content">
    <form action="" class="njt-plugin-setting settings-form" method="POST">
      <!-- creat token -->
      <input type='hidden' name='njt-fm-settings-security-token'
        value='<?php echo wp_create_nonce('njt-fm-settings-security-token'); ?>'>

      <table class="form-table">
        <tr>
          <th>Select User Roles to access</th>
          <td>
            <div class="njt-fm-list-user">
              <?php foreach ( $wp_roles->roles as $key=>$value ): ?>
              <?php if ($key != 'administrator') {?>
              <span style="padding-right: 20px">
                <input type="checkbox" class="fm-list-user-item" id="<?php echo $key; ?>" name="<?php echo $key; ?>"
                  data-name="<?php echo $value['name'];?>" value="<?php echo $key; ?>">
                <label for="<?php echo $key; ?>"><?php echo $value['name']; ?></label>
              </span>
              <?php }?>
              <?php endforeach; ?>
              <!-- Value to submit data -->
              <input type="hidden" name="list_user_alow_access" id="list_user_alow_access">
              <!-- Data saved after submit -->
              <input type="hidden" name="list_user_has_approved" id="list_user_has_approved"
                value="<?php echo implode(",", !empty($this->options['file_manager_settings']['list_user_alow_access']) ? $this->options['file_manager_settings']['list_user_alow_access'] : array());?>">
            </div>
          </td>
        </tr>
        <!-- URL and Path -->
        <tr>
          <th>URL and Path</th>
          <td>
            <input type='text' name='root_folder_path' id='root_folder_path' style="width: 40%"
              placeholder="ex: C:/wamp64/www/wp_wc/wp-admin/"
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
        <!-- Select language -->
        <tr>
          <th>Select language</th>
          <td>
            <?php include_once $viewPathLanguage; ?>
          </td>
        </tr>
        <!-- .htaccess -->
        <tr>
          <th>Display .htaccess?</th>
          <td>
            <label class="shortcode-switch" for="enable_htaccess">
              <input name="enable_htaccess" type="checkbox" id="enable_htaccess" value="1"
                <?php echo isset($this->options['file_manager_settings']['enable_htaccess']) && ($this->options['file_manager_settings']['enable_htaccess'] == '1') ? 'checked="checked"' : '';?>>

              <div class="slider round"></div>
            </label>


            <p class="description">Will Display .htaccess file (if exists) in file manager.</p>
            <p>Default: <code>Not Enabled</code></p>
          </td>
        </tr>
        <!-- Enable Trash? -->
        <tr>
          <th>Enable Trash?</th>
          <td>
            <label class="shortcode-switch" for="enable_trash">
              <input name="enable_trash" type="checkbox" id="enable_trash" value="1"
                <?php echo isset($this->options['file_manager_settings']['enable_trash']) && ($this->options['file_manager_settings']['enable_trash'] == '1') ? 'checked="checked"' : '';?>>
              <div class="slider round"></div>
            </label>

            <p class="description">After enable trash, your files will go to trash folder.</p>
            <p>Default: <code>Not Enabled</code></p>
          </td>
        </tr>
        <!-- button submit -->
        <tr>
          <td></td>
          <td>
            <p class="submit">
              <input type="submit" name="njt-settings-form-submit" id="submit"
                class="button button-primary njt-settings-form-submit" value="Save changes">
            </p>
          </td>
        </tr>
      </table>
    </form>
    <!-- include html User Role Restrictions -->
    <?php include_once $viewUserRoleRestrictions; ?>
  </div>
</div>