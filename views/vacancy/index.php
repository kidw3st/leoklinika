<?php
use app\helpers\base\BImages;
use app\helpers\base\TextHelper;
use app\models\forms\RequestVacancyForm;
use app\models\SystemSettings;

/* @var $this \yii\web\View */
/* @var $text string */
/* @var $image string */
/* @var $items \app\models\Vacancy[] */
/* @var $pages \app\components\base\Pagination */
/* @var $directs \app\models\VacancyDirect[] */
/* @var $items_all \app\models\Vacancy[] */
?>

<?=$this->render('//components/_breadcrumbs', ['breadcrumbs' => $this->context->breadcrumbs])?>
<div class="container">
    <h2 class="documents__title heading_h1"><?=$this->context->h1title?></h2>
    <section class="vacancies-content">
        <div class="vacancies-content__wrapper">
            <div class="vacancies-content__text">
                <?=$text?>
                <button class="btn btn_primary _open-popup" data-target-id="vacancy_index">Отправить резюме</button>
            </div>
            <div class="vacancies-content__image">
                <img src="<?=TextHelper::ImgUrl((BImages::doProp($image, 700, 2000, 100)))?>" alt="Вакансии">
            </div>
        </div>
    </section>

    <section class="vacancies-form" id="vacancy_block">
        <div class="vacancies-form__header">
            <div class="decor-spots">
                <div class="decor-spots__item"></div>
                <div class="decor-spots__item"></div>
                <div class="decor-spots__item"></div>
            </div>
            <h2 class="vacancies-form__title heading_h4">Список текущих вакансий:</h2>
            <div class="vacancies-form__description">
                <?php if(!empty($directs)) { ?>
                    <div class="dropdown-authors dropdown">
                        <button class="dropdown__btn">
                            <a href="#" class="dropdown__current bodytext_m"><?=$current_direct?$current_direct->title:'Выберите направление'?></a>
                            <svg class="icon icon_close">
                                <use xlink:href="#icon-arrow3"></use>
                            </svg>
                        </button>
                        <ul class="dropdown__list">
                            <?php foreach ($directs as $direct) { ?>
                                <li class="dropdown__item" data-value="<?=$direct->id?>">
                                    <a data-pjax-block="#vacancy_block" href="<?=\yii\helpers\Url::current(['direct' => $direct->id, 'page' => null])?>" class="dropdown__link bodytext_m"><?=$direct->title?></a>
                                </li>
                            <?php } ?>
                        </ul>
                        <input type="text" name="select" value="krsk" class="dropdown__input_hidden">
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="vacancies-form__body">
            <div class="accordion">
                <?php foreach ($items as $item) { ?>
                    <div class="accordion__wrapper _toggle">
                        <div class="accordion__question _toggle__button">
                            <p class="accordion__question__text bodytext_n_strong"><?=$item->title?></p>
                            <button class="accordion__question__btn">
                                <svg class="icon">
                                    <use xlink:href="#icon-arrow"></use>
                                </svg>
                            </button>
                        </div>
                        <div class="accordion__answer _toggle__container">
                            <?php foreach ($item->infos_real as $info) { ?>
                                <div class="content-accordion-inner wysiwyg">
                                    <?=$info->text?>
                                </div>
                            <?php } ?>
                            <div class="btn-wrapper">
                                <button class="btn btn_primary _open-popup" data-target-id="vacancy_detail_<?=$item->id?>">Отправить резюме</button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?=$pages->draw('//components/pager_more_3', 2, ['pjax_block' => '#vacancy_block', 'class' => 'vacancies-form__footer'])?>
    </section>
</div>


<?php $this->beginBlock('modal-vacancy_index')?>
    <?=$this->render('//components/form_modal_common', [
        'modal_id' => 'vacancy_index',
        'pjax_id' => 'vacancy_index',
        'model' => new RequestVacancyForm(),
        'template' => 'vacancy',
        'title' => 'Отправить резюме',
        'button' => 'Отправить резюме',
        'success_text' => SystemSettings::getParam('form_vacancy' , 'success_text', 'Резюме отправлено!'),
        'popup_class' => 'popup_review',
    ])?>
    <?php foreach ($items_all as $item) { ?>
        <?=$this->render('//components/form_modal_common', [
            'modal_id' => 'vacancy_detail_' . $item->id,
            'pjax_id' => 'vacancy_detail_' . $item->id,
            'model' => new RequestVacancyForm(['vacancy_id' => $item->id]),
            'template' => 'vacancy',
            'title' => 'Отправить резюме',
            'button' => 'Отправить резюме',
            'success_text' => SystemSettings::getParam('form_vacancy' , 'success_text', 'Резюме отправлено!'),
            'popup_class' => 'popup_review',
        ])?>
    <?php } ?>
<?php $this->endBlock()?>