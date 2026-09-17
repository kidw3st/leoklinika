<?php
?>

<div class="page-error">
    <div class="page-error__wrapper">
        <div class="page-error-decor">
            <div class="decor-spots">
                <div class="decor-spots__item"></div>
                <div class="decor-spots__item"></div>
                <div class="decor-spots__item"></div>
            </div>
            <div class="decor-block">
                <picture>
                    <source media="(max-width: 940px)" srcset="img/content/404-user-mobile.png" type="image/png">
                    <img src="/assets/front/img/content/404-user.png" class="decor-block-user" alt="">
                </picture>
                <div class="decor-block-cloud-entry">
                    <div class="decor-block-cloud">
                        <img src="/assets/front/img/decor/404-cloud.svg" alt="">
                        <p class="decor-block-cloud__text"><?=$error_text?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-error-content">
            <img src="/assets/front/img/decor/404.svg" alt="" class="page-error-img">
            <p class="page-error-text">Перейдите на нашу главную страницу</p>
            <div class="button-block">
                <a class="btn btn_primary btn_primary_small bodytext_l_strong" href="/">
                    <span>Перейти на главную страницу</span>
                </a>
            </div>
        </div>
    </div>
</div>