jQuery(document).ready(function () {
  if (jQuery("div").hasClass("nit-file-manager")) {
    //set select value
    if (jQuery('input[name = "selected-theme"]')) {
      const selectedTheme = jQuery('input[name = "selected-theme"]').val()
      console.log(selectedTheme)
      jQuery('#selector-themes').val(selectedTheme);
    }

    jQuery('select#selector-themes').on('change', function () {
      let themesValue = jQuery(this).val()
      const dataThemes = {
        'action': 'selector_themes',
        'themesValue': themesValue,
        'nonce': wpData.nonce,
      }
      jQuery.post(
        wpData.admin_ajax,
        dataThemes,
        function (response) {
          console.log(response)
          jQuery('link#themes-selector-css').attr('href', response.data)
        });
    });

    // Start- Setting for `Select User Roles to access`
    jQuery('.njt-settings-form-submit').on('click', function () {
      const arraylistUserAccess = [];
      jQuery('.fm-list-user-item').each(function () {
        if (jQuery(this).is(":checked")) {
          arraylistUserAccess.push(jQuery(this).val());
        }
      });
      arraylistUserAccess.push('administrator')
      jQuery("#list_user_alow_access").val(arraylistUserAccess)
    })
    // Get valua to prop checked for input checkbox
    const arrayUserHasApproved = jQuery('#list_user_has_approved').val() ? jQuery('#list_user_has_approved').val().split(",") : []
    for (itemUserHasApproved of arrayUserHasApproved) {
      if (itemUserHasApproved != 'administrator') {
        jQuery('input[name = ' + itemUserHasApproved + ']').prop('checked', true);
      }
    }
    // End- Setting for `Select User Roles to access`
  }
});
