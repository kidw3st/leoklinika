<?php
use app\models\SystemSettings;

global $politika_counter;

if (empty($politika_counter)) $politika_counter = 0;
$politika_counter++;
?>

<label class="form__label form__label_checkbox" for="personality_<?=$politika_counter?>">
    <input type="checkbox" name="titles" class="checkbox_real" id="personality_<?=$politika_counter?>" name="politika"<?=Yii::$app->request->post('politika')?' checked':''?> required>
    <span class="checkbox_custom"></span>
    <span class="form__label__name bodytext_m">Нажимая на кнопку, вы соглашаетесь с <a target="_blank" href="<?=SystemSettings::getParam('adminbase', 'politika_link', '/')?>" class="form__link">политикой обработки персональных данных</a></span>
</label>