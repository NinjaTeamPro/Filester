<?php
defined('ABSPATH') || exit;
$viewListOperations = BN_PLUGIN_PATH . 'views/pages/html-filemanager-list-operations.php';
$listUserApproved = !empty($this->options['file_manager_settings']['list_user_alow_access']) ? $this->options['file_manager_settings']['list_user_alow_access'] : array();

if (isset($_POST) && !empty($_POST) && !empty($_POST['njt-form-user-role-restrictionst'])) {
    if (!wp_verify_nonce($_POST['njt-fm-user-restrictions-security-token'], 'njt-fm-user-restrictions-security-token')) {
        wp_die();
    }

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

$arrRestrictions = !empty($this->options['file_manager_settings']['list_user_role_restrictions']) ? $this->options['file_manager_settings']['list_user_role_restrictions'] : array();
$firstKeyRestrictions = !empty($userRoleRestrictedSubmited) ? $userRoleRestrictedSubmited : array_keys($arrRestrictions)[0];
?>

<form action="" class="njt-plugin-setting form-user-role-restrictions" method="POST">
  <!-- creat token -->
  <input type='hidden' name='njt-fm-user-restrictions-security-token'
    value='<?php echo wp_create_nonce('njt-fm-user-restrictions-security-token'); ?>'>
  <table class="form-table">
    <tr>
      <th>If User role is</th>
      <td>
        <div>
          <select class="njt-fm-list-user-restrictions" name="njt-fm-list-user-restrictions">
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
            <option selected disabled hidden>Nothing to choose</option>
            <?php }?>
          </select>
        </div>
      </td>
    </tr>
    <tr>
      <th>Disable Operations</th>
      <td>
        <div style="line-height: 2">
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
      <th>Seperate or private folder access</th>
      <td>
        <div>
          <textarea name="private_folder_access" id="private_folder_access"
            cols="100"><?php echo (!empty($arrRestrictions[$firstKeyRestrictions]['private_folder_access']) ? $arrRestrictions[$firstKeyRestrictions]['private_folder_access'] : '');?></textarea>
        </div>
      </td>
    </tr>
    <tr>
      <th>Enter Folder or File Paths That You want to Hide</th>
      <td>
        <div>
          <textarea name="hide_paths" id="hide_paths"
            cols="100"><?php echo implode(" | ", !empty($arrRestrictions[$firstKeyRestrictions]['hide_paths']) ? $arrRestrictions[$firstKeyRestrictions]['hide_paths'] : array());?></textarea>
          <p class="description">
            e.g: wp-content/themes | wp-content/upload. Note: Mutiple separated by Vertical Bar ( <strong>|</strong> )
          </p>
        </div>
      </td>
    </tr>
    <tr>
      <th>Enter file extensions which you want to Lock</th>
      <td>
        <div>
          <textarea name="lock_files" id="lock_files"
            cols="100"><?php echo implode(" | ", !empty($arrRestrictions[$firstKeyRestrictions]['lock_files']) ? $arrRestrictions[$firstKeyRestrictions]['lock_files'] : array());?></textarea>
          <p class="description">
            e.g: .php | .png | .css. Note: Mutiple separated by Vertical Bar ( <strong>|</strong> )
          </p>
        </div>
      </td>
    </tr>
    <tr>
      <th>Enter file extensions which user can be uploaded</th>
      <td>
        <div>
          <div>
            <div class="njt-btn-group" style="width:100%">
              <button type="button" class="njt-mime-type" value="application">application</button>
              <button type="button" class="njt-mime-type" value="audio">audio</button>
              <button type="button" class="njt-mime-type" value="image">image</button>
              <button type="button" class="njt-mime-type" value="video">video</button>
              <button type="button" class="njt-mime-type" value="text">text</button>
              <button type="button" class="njt-mime-type" value="clearall">clear all</button>
            </div>
          </div>
          <textarea name="can_upload_mime" id="can_upload_mime"
            cols="100"><?php echo implode(",", !empty($arrRestrictions[$firstKeyRestrictions]['can_upload_mime']) ? $arrRestrictions[$firstKeyRestrictions]['can_upload_mime'] : array());?></textarea>
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