<?php
 $locales =  array(
    'English'=>'en',
    'Arabic'=>'ar',
    'Bulgarian' => 'bg',
    'Catalan' => 'ca',
    'Czech' => 'cs',
    'Danish' => 'da',
    'German' => 'de',
    'Greek' => 'el',
    'Español' => 'es',
    'Persian-Farsi' => 'fa',
    'Faroese translation' => 'fo',
    'French' => 'fr',
    'Hebrew' => 'he',
    'hr' => 'hr',
    'magyar' => 'hu',
    'Indonesian' => 'id',
    'Italiano' => 'it',
    'Japanese' => 'ja',
    'Korean' => 'ko',
    'Dutch' => 'nl',
    'Norwegian' => 'no',
    'Polski' => 'pl',
    'Português' => 'pt_BR',
    'Română' => 'ro',
    'Russian' => 'ru',
    'Slovak' => 'sk',
    'Slovenian' => 'sl',
    'Serbian' => 'sr',
    'Swedish' => 'sv',
    'Türkçe' => 'tr',
    'Uyghur' => 'ug_CN',
    'Ukrainian' => 'uk',
    'Vietnamese' => 'vi',
    'Simplified Chinese' => 'zh_CN',
    'Traditional Chinese' => 'zh_TW',
  );
?>

<select name="fm_locale" id="fm_locale" class="njt-settting-width">
  <?php foreach($locales as $key => $locale) { ?>
  <option value="<?php echo $locale;?>"
    <?php echo (isset($this->options['file_manager_settings']['fm_locale']) && $this->options['file_manager_settings']['fm_locale'] == $locale) ? 'selected="selected"' : '';?>>
    <?php echo $key;?></option>
  <?php } ?>
</select>