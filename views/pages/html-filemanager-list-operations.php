<?php
$listOperations = array(
  'mkdir'=>'mkdir',
  'mkfile'=>'mkfile',
  'rename'=>'rename',
)
?>

<?php foreach($listOperations as $key => $listOperation) { ?>
<span style="padding-right: 20px">
  <input type="checkbox" class="fm-list-user-item" id="<?php echo $key; ?>" name="<?php echo $key; ?>"
    value="<?php echo $key; ?>">
  <label for="vehicle1"><?php echo $listOperation; ?></label>
</span>
<?php } ?>