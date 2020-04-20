<?php
defined('ABSPATH') || exit;
?>

<div id="wp_file_manager" class="wrap" style="margin: 20px 0;">
</div>

<script>

PLUGINS_URL = '<?php echo plugins_url();?>';

jQuery(document).ready(function(){
  console.log(ajaxurl)
	jQuery('#wp_file_manager').elfinder({
		url: ajaxurl,
		contextmenu : {
            // current directory file menu
            files  : ['getfile', '|' ,'open', 'opennew', 'download', 'opendir', 'quicklook', 'email', '|', 'upload', 'mkdir', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', 'empty', 'hide', '|', 'rename', 'edit', 'resize', '|', 'archive', 'extract', '|', 'selectall', 'selectinvert', '|', 'places', 'info', 'chmod', 'netunmount'
            ]
        },
		customData:{action: 'connector'},
		lang: '',
		requestType: 'post',
		width: 'auto',
		height: '600',
	});
});

</script>
