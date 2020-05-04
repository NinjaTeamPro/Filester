<?php
$listOperations = array(
  'mkdir'=>'mkdir',
  'mkfile'=>'mkfile',
  'rename'=>'rename',
  'duplicate'=>'duplicate',
  'paste'=>'paste',
  'ban'=>'ban',
  'archive'=>'archive',
  'extract'=>'extract',
  'copy'=>'copy',
  'cut'=>'cut',
  'edit'=>'edit',
  'rm'=>'rm',
  'download'=>'download',
  'upload'=>'upload',
  'search'=>'search',
  'info'=>'info'
)
?>

<?php foreach($listOperations as $key => $listOperation) { ?>
<span style="padding-right: 20px;">
  <input type="checkbox" class="fm-list-user-restrictions-item" id="<?php echo $key; ?>" name="<?php echo $key; ?>"
    value="<?php echo $key; ?>">
  <label for="vehicle1"><?php echo $listOperation; ?></label>
</span>
<?php } ?>