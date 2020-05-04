<?php
defined('ABSPATH') || exit;
$viewListOperations = BN_PLUGIN_PATH . 'views/pages/html-filemanager-list-operations.php';
$listUserApproved = !empty($this->options['file_manager_settings']['list_user_alow_access']) ? $this->options['file_manager_settings']['list_user_alow_access'] : array();

if( isset( $_POST ) && !empty( $_POST ) && !empty($_POST['njt-form-user-role-restrictionst'])){
 if( ! wp_verify_nonce( $_POST['njt-fm-user-restrictions-security-token'] ,'njt-fm-user-restrictions-security-token')) wp_die();
  if (empty($this->options['file_manager_settings']['list_user_role_restrictions'])) {
    $this->options['file_manager_settings']['list_user_role_restrictions'] = array();
  }

  $this->options['file_manager_settings']['list_user_role_restrictions'][$_POST['njt-fm-list-user-restrictions']]['list_user_restrictions_alow_access'] = 
    filter_var($_POST['list_user_restrictions_alow_access'], FILTER_SANITIZE_STRING) ?
    explode(',',$_POST['list_user_restrictions_alow_access']) : array();
}

$arrRestrictions = !empty($this->options['file_manager_settings']['list_user_role_restrictions']) ? $this->options['file_manager_settings']['list_user_role_restrictions'] : array();
$firstKeyRestrictions =  array_keys($arrRestrictions)[0];
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
            <option value="<?php echo $key; ?>"><?php echo $value['name']; ?></option>
            <?php 
                }
              endforeach;}
              else {
             ?>
            <option value="">Nothing to choose</option>
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
          <textarea name="" id="" cols="80"></textarea>
        </div>
      </td>
    </tr>
    <tr>
      <th>Enter Folder or File Paths That You want to Hide</th>
      <td>
        <div>
          <textarea name="" id="" cols="80"></textarea>
        </div>
      </td>
    </tr>
    <tr>
      <th>Enter file extensions which you want to Lock</th>
      <td>
        <div>
          <textarea name="" id="" cols="80"></textarea>
        </div>
      </td>
    </tr>

    <!-- button submit -->
    <tr>
      <td></td>
      <td>
        <p class="submit">
          <input type="submit" name="njt-form-user-role-restrictionst" id="njt-form-user-role-restrictionst"
            class="button button-primary njt-settings-form-submit" value="Save Changes">
        </p>
      </td>
    </tr>
  </table>
</form>