<?php
defined('ABSPATH') || exit;
$viewPathLanguage = NJT_FS_BN_PLUGIN_PATH . 'views/pages/html-filemanager-language.php';
$viewUserRoleRestrictions = NJT_FS_BN_PLUGIN_PATH . 'views/pages/html-filemanager-user-role-restrictions.php';
global $wp_roles;
if( isset( $_POST ) && !empty( $_POST ) && !empty($_POST['njt-settings-form-submit'])){
  if( ! wp_verify_nonce( $_POST['njt-fs-settings-security-token'] ,'njt-fs-settings-security-token')) wp_die();

  $this->options['njt_fs_file_manager_settings']['root_folder_path']  = filter_var($_POST['root_folder_path'], FILTER_SANITIZE_STRING) ? str_replace("\\\\", "/", trim($_POST['root_folder_path'])) : '';
  $this->options['njt_fs_file_manager_settings']['enable_htaccess'] =  isset($_POST['enable_htaccess']) ? sanitize_text_field($_POST['enable_htaccess']) : 0;
  $this->options['njt_fs_file_manager_settings']['enable_trash'] =  isset($_POST['enable_trash']) ? sanitize_text_field($_POST['enable_trash']) : 0;
  $this->options['njt_fs_file_manager_settings']['upload_max_size'] =  filter_var($_POST['upload_max_size'], FILTER_SANITIZE_STRING) ? sanitize_text_field(trim($_POST['upload_max_size'])) : 0;
  $this->options['njt_fs_file_manager_settings']['fm_locale'] = filter_var($_POST['fm_locale'], FILTER_SANITIZE_STRING) ? sanitize_text_field($_POST['fm_locale']) : 'en';
  $this->options['njt_fs_file_manager_settings']['list_user_alow_access'] = filter_var($_POST['list_user_alow_access'], FILTER_SANITIZE_STRING) ? explode(',',$_POST['list_user_alow_access']) : array();
}

?>
<div class="njt-fs-settings njt-fs-file-manager">
  <h1 id="njt-plugin-tabs" class="nav-tab-wrapper hide-if-no-js">
    <a href="javascript:void(0)" class="nav-tab nav-tab-active"><?php _e("Settings", 'njt-fs-file-manager'); ?></a>
    <a href="javascript:void(0)" class="nav-tab"><?php _e("User Role Restrictions", 'njt-fs-file-manager'); ?></a>
  </h1>
  <div class="njt-fs-settings-content">
    <form action="" class="njt-plugin-setting settings-form" method="POST">
      <!-- creat token -->
      <input type='hidden' name='njt-fs-settings-security-token'
        value='<?php echo wp_create_nonce('njt-fs-settings-security-token'); ?>'>

      <table class="form-table">
        <tr>
          <th><?php _e("Select User Roles to access", 'njt-fs-file-manager'); ?></th>
          <td>
            <div class="njt-fs-list-user njt-settting-width" style="line-height:2">
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
                value="<?php echo implode(",", !empty($this->options['njt_fs_file_manager_settings']['list_user_alow_access']) ? $this->options['njt_fs_file_manager_settings']['list_user_alow_access'] : array());?>">
            </div>
          </td>
        </tr>
        <!-- root Path -->
        <tr>
          <th><?php _e("Root Path", 'njt-fs-file-manager'); ?></th>
          <td>
            <input type='text' name='root_folder_path' id='root_folder_path' class="njt-settting-width"
              placeholder="ex: <?php echo (str_replace("\\", "/", ABSPATH)."wp-content");?>"
              value='<?php  if( isset( $this->options['njt_fs_file_manager_settings']['root_folder_path'] ) && !empty( $this->options['njt_fs_file_manager_settings']['root_folder_path'] ) ) echo str_replace("\\", "/",esc_attr($this->options['njt_fs_file_manager_settings']['root_folder_path'])); ?>' />
            <div class="des-path njt-settting-width">
              <small><?php _e("File Manager Pro Root Path, you can change according to your choice", 'njt-fs-file-manager'); ?></small>
            </div>
            <small>
              <?php _e("Default Path:", 'njt-fs-file-manager'); ?>
              <b><?php echo (str_replace("\\", "/", ABSPATH));?></b>
            </small>
          </td>
        </tr>
        <!-- Maximum Upload Size -->
        <tr>
          <th><?php _e("Maximum Upload Size", 'njt-fs-file-manager'); ?></th>
          <td>
            <input type="number" name="upload_max_size" id="upload_max_size" class="njt-fs-settting-width-half"
              value="<?php  if( isset( $this->options['njt_fs_file_manager_settings']['upload_max_size'] ) && !empty( $this->options['njt_fs_file_manager_settings']['upload_max_size'] )) echo esc_attr($this->options['njt_fs_file_manager_settings']['upload_max_size']); ?>">
            <strong><?php _e("MB", 'njt-fs-file-manager'); ?></strong>
            <div class="des-path njt-settting-width">
              <small>
                <?php _e("Default:", 'njt-fs-file-manager'); ?>
                <b><?php _e("0 means unlimited upload.", 'njt-fs-file-manager'); ?></b>
              </small>
            </div>
          </td>
        </tr>
        <!-- Select language -->
        <tr>
          <th><?php _e("Select language", 'njt-fs-file-manager'); ?></th>
          <td>
            <?php include_once $viewPathLanguage; ?>
          </td>
        </tr>
        <!-- .htaccess -->
        <tr>
          <th><?php _e("Hide .htaccess?", 'njt-fs-file-manager'); ?></th>
          <td>
            <label class="shortcode-switch" for="enable_htaccess">
              <input name="enable_htaccess" type="checkbox" id="enable_htaccess" value="1"
                <?php echo isset($this->options['njt_fs_file_manager_settings']['enable_htaccess']) && ($this->options['njt_fs_file_manager_settings']['enable_htaccess'] == '1') ? 'checked="checked"' : '';?>>

              <div class="slider round"></div>
            </label>


            <p class="description njt-settting-width">
              <?php _e("Will Hide .htaccess file (if exists) in file manager.", 'njt-fs-file-manager'); ?>
            </p>
            <p>
              <?php _e("Default: ", 'njt-fs-file-manager'); ?><code><?php _e("Not Enabled", 'njt-fs-file-manager'); ?></code>
            </p>
          </td>
        </tr>
        <!-- Enable Trash? -->
        <tr>
          <th><?php _e("Enable Trash?", 'njt-fs-file-manager'); ?></th>
          <td>
            <label class="shortcode-switch" for="enable_trash">
              <input name="enable_trash" type="checkbox" id="enable_trash" value="1"
                <?php echo isset($this->options['njt_fs_file_manager_settings']['enable_trash']) && ($this->options['njt_fs_file_manager_settings']['enable_trash'] == '1') ? 'checked="checked"' : '';?>>
              <div class="slider round"></div>
            </label>

            <p class="description njt-settting-width">
              <?php _e("After enable trash, your files will go to trash folder.", 'njt-fs-file-manager'); ?></p>
            <p>
              <?php _e("Default: ", 'njt-fs-file-manager'); ?><code><?php _e("Not Enabled", 'njt-fs-file-manager'); ?></code>
            </p>
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