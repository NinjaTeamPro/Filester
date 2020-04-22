jQuery(document).ready(function () {
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
});
