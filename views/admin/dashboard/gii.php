<?php if ($createdTables) { ?>
    <section class="content">
        <h2>Модели</h2>
        <?php foreach ($createdTables as $ct) { if (!empty($ct['post'])) { ?>
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <form action="/gii/andCrud" method="POST">
                        <?=generateInputs($ct['post'], 'Generator'); ?>
                        <button type="submit" name="preview" value=""><?=$ct['label']?></button>
                    </form>
                </div>
            </div>
        <?php } } ?>
    </section>
<?php } ?>
<?php if ($controllers) { ?>
    <section class="content">
        <h2>Контроллеры</h2>
        <?php foreach ($controllers as $ct) { if (!empty($ct['post'])) { ?>
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <form action="/gii/andController" method="POST">
                        <?=generateInputs($ct['post'], 'Generator'); ?>
                        <button type="submit" name="preview" value=""><?=$ct['post']['controllerLabel']?> (<?=$ct['post']['controllerName']?>)</button>
                    </form>
                </div>
            </div>
        <?php } } ?>
    </section>
<?php } ?>
<?php if ($settings) { ?>
    <section class="content">
        <h2>Настройки</h2>
        <?php foreach ($settings as $ct) { if (!empty($ct['post'])) { ?>
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <form action="/gii/andSettings" method="POST">
                        <?=generateInputs($ct['post'], 'Generator'); ?>
                        <button type="submit" name="preview" value=""><?=$ct['post']['moduleName']?></button>
                    </form>
                </div>
            </div>
        <?php } } ?>
    </section>
<?php } ?>

<?php
function generateInputs($post, $prevVar = '') {
    $res = '';
    foreach($post as $pKey => $pVal) {
        if (is_array($pVal)) {
            if ($prevVar == '') {
                $res .= generateInputs($pVal, $pKey);
            } else {
                $res .= generateInputs($pVal, $prevVar . '[' . $pKey . ']');
            }
        } else {
            if ($prevVar == '') {
                $res .= '<input type="hidden" name="' . $pKey . '" value="' . $pVal . '" />';
            } else {
                $res .= '<input type="hidden" name="' . $prevVar . '[' . $pKey . ']" value="' . $pVal . '" />';
            }
        }
    }
    return $res;
}