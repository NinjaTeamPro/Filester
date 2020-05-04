jQuery(document).ready(function () {
  if (jQuery("div").hasClass("njt-file-manager")) {
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
    // Get value to prop checked for input checkbox
    const arrayUserHasApproved = jQuery('#list_user_has_approved').val() ? jQuery('#list_user_has_approved').val().split(",") : []
    for (itemUserHasApproved of arrayUserHasApproved) {
      if (itemUserHasApproved != 'administrator') {
        jQuery('input[name = ' + itemUserHasApproved + ']').prop('checked', true);
      }
    }
    // End- Setting for `Select User Roles to access`

    // Start- Setting for `Select User Roles Restrictions to access`

    //Setting tab
    jQuery("#njt-plugin-tabs a").click(function (event) {
      jQuery("#njt-plugin-tabs a").removeClass("nav-tab-active");
      jQuery(".njt-plugin-setting").hide();
      jQuery(this).addClass("nav-tab-active");
      // Show current pane
      jQuery(".njt-plugin-setting:eq(" + jQuery(this).index() + ")").show();
    });

    jQuery('#njt-form-user-role-restrictionst').on('click', function () {
      const arrayUserRestrictionsAccess = [];
      jQuery('.fm-list-user-restrictions-item').each(function () {
        if (jQuery(this).is(":checked")) {
          arrayUserRestrictionsAccess.push(jQuery(this).val());
        }
      });
      jQuery("#list_user_restrictions_alow_access").val(arrayUserRestrictionsAccess)
    })
    // Get value to prop checked for input checkbox
    const arrayRestrictionsHasApproved = jQuery('#list_restrictions_has_approved').val() ? jQuery('#list_restrictions_has_approved').val().split(",") : []
    for (itemRestrictionsHasApproved of arrayRestrictionsHasApproved) {
      jQuery('input[name = ' + itemRestrictionsHasApproved + ']').prop('checked', true);
    }
    //Ajax change value
    jQuery('select.njt-fm-list-user-restrictions').on('change', function () {
      const valueUserRole = jQuery(this).val()
      const dataUserRole = {
        'action': 'selector_user_role',
        'valueUserRole': valueUserRole,
        'nonce': wpData.nonce,
      }
      jQuery.post(
        wpData.admin_ajax,
        dataUserRole,
        function (response) {
          console.log(response.data)
          const resRestrictionsHasApproved = response.data ? response.data.split(",") : []
          jQuery('input.fm-list-user-restrictions-item').prop('checked', false);
          for (itemRestrictionsHasApproved of resRestrictionsHasApproved) {
            jQuery('input[name = ' + itemRestrictionsHasApproved + ']').prop('checked', true);
          }
        });
    });
    // End- Setting for `Select User Roles Restrictions to access`

  }
});
