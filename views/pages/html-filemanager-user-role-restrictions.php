<?php
defined('ABSPATH') || exit;
$viewListOperations = NJT_FM_BN_PLUGIN_PATH . 'views/pages/html-filemanager-list-operations.php';
$listUserApproved = !empty($this->options['file_manager_settings']['list_user_alow_access']) ? $this->options['file_manager_settings']['list_user_alow_access'] : array();

if (isset($_POST) && !empty($_POST) && !empty($_POST['njt-form-user-role-restrictionst'])) {
  if (!wp_verify_nonce($_POST['njt-fm-user-restrictions-security-token'], 'njt-fm-user-restrictions-security-token')) {
      wp_die();
  }
  if(!empty($_POST['njt-fm-list-user-restrictions'])) {

    $userRoleRestrictedSubmited = filter_var($_POST['njt-fm-list-user-restrictions'], FILTER_SANITIZE_STRING) ? sanitize_text_field($_POST['njt-fm-list-user-restrictions']) : '';
    
    if (empty($this->options['file_manager_settings']['list_user_role_restrictions'])) {
      $this->options['file_manager_settings']['list_user_role_restrictions'] = array();
    }

    //Save data list User Restrictions alow access
    $this->options['file_manager_settings']['list_user_role_restrictions'][$_POST['njt-fm-list-user-restrictions']]['list_user_restrictions_alow_access'] = 
      filter_var($_POST['list_user_restrictions_alow_access'], FILTER_SANITIZE_STRING) ?
      explode(',', $_POST['list_user_restrictions_alow_access']) : array();
    //Seperate or private folder access
    $this->options['file_manager_settings']['list_user_role_restrictions'][$_POST['njt-fm-list-user-restrictions']]['private_folder_access'] =
      filter_var($_POST['private_folder_access'], FILTER_SANITIZE_STRING) ?
      str_replace("\\\\", "/", trim($_POST['private_folder_access'])) : '';
    //Save data Enter Folder or File Paths That You want to Hide
    $this->options['file_manager_settings']['list_user_role_restrictions'][$_POST['njt-fm-list-user-restrictions']]['hide_paths'] = 
      filter_var($_POST['hide_paths'], FILTER_SANITIZE_STRING) ?
      explode('|', preg_replace('/\s+/', '', $_POST['hide_paths'])) : array();
    //Save data Enter file extensions which you want to Lock
    $this->options['file_manager_settings']['list_user_role_restrictions'][$_POST['njt-fm-list-user-restrictions']]['lock_files'] =
      filter_var($_POST['lock_files'], FILTER_SANITIZE_STRING) ?
      explode('|', preg_replace('/\s+/', '', $_POST['lock_files'])) : array();
    //Enter file extensions which can be uploaded
    $this->options['file_manager_settings']['list_user_role_restrictions'][$_POST['njt-fm-list-user-restrictions']]['can_upload_mime'] =
      filter_var($_POST['can_upload_mime'], FILTER_SANITIZE_STRING) ?
      explode(',', preg_replace('/\s+/', '', $_POST['can_upload_mime'])) : array();
  }
}

$arrRestrictions = !empty($this->options['file_manager_settings']['list_user_role_restrictions']) ? $this->options['file_manager_settings']['list_user_role_restrictions'] : array();
if (count($arrRestrictions) > 0) {
  $firstKeyRestrictions = !empty($userRoleRestrictedSubmited) ? $userRoleRestrictedSubmited : array_keys($arrRestrictions)[0];
} else {
  $firstKeyRestrictions = '';
}
?>

<form action="" class="njt-plugin-setting form-user-role-restrictions" method="POST">
  <!-- creat token -->
  <input type='hidden' name='njt-fm-user-restrictions-security-token'
    value='<?php echo wp_create_nonce('njt-fm-user-restrictions-security-token'); ?>'>
  <table class="form-table">
    <tr>
      <th><?php _e("If User role is", 'njt-file-manager'); ?></th>
      <td>
        <div>
          <select class="njt-fm-list-user-restrictions njt-settting-width-select" name="njt-fm-list-user-restrictions">
            <?php
              if ($listUserApproved && count($listUserApproved) != 1 && $listUserApproved[0] != 'administrator') {
              foreach ( $wp_roles->roles as $key=>$value ):
                if ($key != 'administrator' && in_array($key,$listUserApproved) ) {?>
            <option value="<?php echo $key; ?>"
              <?php echo(!empty($firstKeyRestrictions) && $firstKeyRestrictions == $key ) ? 'selected="selected"' : '';?>>
              <?php echo $value['name']; ?>
            </option>
            <?php 
                }
              endforeach;}
              else {
             ?>
            <option selected disabled hidden><?php _e("Nothing to choose", 'njt-file-manager'); ?></option>
            <?php }?>
          </select>
          <?php 
            if(empty($listUserApproved) || $listUserApproved && count($listUserApproved) == 1 && $listUserApproved[0] == 'administrator') {
              ?>
          <p class="description njt-text-error njt-settting-width">
            <?php _e("Please choose (Select User Roles to access) in Settings tab", 'njt-file-manager'); ?>
          </p>
          <?php
            }
          ?>
        </div>
      </td>
    </tr>
    <tr>
      <th><?php _e("Disable Operations", 'njt-file-manager'); ?></th>
      <td>
        <div style="line-height: 2" class="njt-settting-width">
          <?php include_once $viewListOperations; ?>
          <!-- Value to submit data -->
          <input type="hidden" name="list_user_restrictions_alow_access" id="list_user_restrictions_alow_access">
          <!-- Data saved after submit -->
          <input type="hidden" name="list_restrictions_has_approved" id="list_restrictions_has_approved"
            value="<?php echo implode(",", !empty($arrRestrictions[$firstKeyRestrictions]['list_user_restrictions_alow_access']) ? $arrRestrictions[$firstKeyRestrictions]['list_user_restrictions_alow_access'] : array());?>">
        </div>
      </td>
    </tr>
    <tr>
      <th><?php _e("URL and Path", 'njt-file-manager'); ?></th>
      <td>
        <div>
          <div class="njt-settting-width">
            <button type="button"
              class="njt-fm-button js-creat-root-path"><?php _e("creat root", 'njt-file-manager'); ?></button>
          </div>
          <textarea name="private_folder_access" id="private_folder_access"
            class="njt-settting-width"><?php echo (!empty($arrRestrictions[$firstKeyRestrictions]['private_folder_access']) ? $arrRestrictions[$firstKeyRestrictions]['private_folder_access'] : '');?></textarea>
          <div>
            <p class="description njt-settting-width">
              <?php _e("ex: ". str_replace("\\", "/", ABSPATH)."wp-content.", 'njt-file-manager'); ?>
            </p>
            <small>
              <?php _e("Default Path:", 'njt-file-manager'); ?>
              <b class="njt-fm-root-path"><?php echo (str_replace("\\", "/", ABSPATH));?></b>
            </small>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <th> <?php _e("Enter Folder or File Paths That You want to Hide", 'njt-file-manager'); ?></th>
      <td>
        <div>
          <textarea name="hide_paths" id="hide_paths"
            class="njt-settting-width"><?php echo implode(" | ", !empty($arrRestrictions[$firstKeyRestrictions]['hide_paths']) ? $arrRestrictions[$firstKeyRestrictions]['hide_paths'] : array());?></textarea>
          <p class="description njt-settting-width">
            <?php _e("ex: themes/storefront | themes/twentyseventeen. Note: Mutiple separated by Vertical Bar", 'njt-file-manager'); ?>
            ( <strong>|</strong> )
          </p>
        </div>
      </td>
    </tr>
    <tr>
      <th><?php _e("Enter file extensions which you want to Lock", 'njt-file-manager'); ?></th>
      <td>
        <div>
          <textarea name="lock_files" id="lock_files"
            class="njt-settting-width"><?php echo implode(" | ", !empty($arrRestrictions[$firstKeyRestrictions]['lock_files']) ? $arrRestrictions[$firstKeyRestrictions]['lock_files'] : array());?></textarea>
          <p class="description njt-settting-width">
            <?php _e("ex: .php | .png | .css. Note: Mutiple separated by Vertical Bar", 'njt-file-manager'); ?> (
            <strong>|</strong> )
          </p>
        </div>
      </td>
    </tr>
    <tr>
      <th><?php _e("Enter file extensions which user can be uploaded", 'njt-file-manager'); ?></th>
      <td>
        <div>
          <div>
            <div class="njt-btn-group njt-settting-width">
              <button type="button" class="njt-mime-type njt-fm-button" value="application">application</button>
              <button type="button" class="njt-mime-type njt-fm-button" value="audio">audio</button>
              <button type="button" class="njt-mime-type njt-fm-button" value="image">image</button>
              <button type="button" class="njt-mime-type njt-fm-button" value="video">video</button>
              <button type="button" class="njt-mime-type njt-fm-button" value="text">text</button>
              <button type="button" class="njt-mime-type njt-fm-button" value="clearall">clear all</button>
            </div>
          </div>
          <textarea name="can_upload_mime" id="can_upload_mime"
            class="njt-settting-width"><?php echo implode(",", !empty($arrRestrictions[$firstKeyRestrictions]['can_upload_mime']) ? $arrRestrictions[$firstKeyRestrictions]['can_upload_mime'] : array());?></textarea>
        </div>
      </td>
    </tr>

    <!-- button submit -->
    <tr>
      <td></td>
      <td>
        <p class="submit">
          <input type="submit" name="njt-form-user-role-restrictionst" id="njt-form-user-role-restrictionst"
            class="button button-primary" value="Save Changes">
        </p>
      </td>
    </tr>
  </table>
</form>