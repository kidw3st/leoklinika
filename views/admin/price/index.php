<?php

?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body with-border">
                    <a class="btn btn-success" href="/admin/price/a_download">Скачать прайслист</a>
                    <hr/>
                    <form method="post" enctype="multipart/form-data" action="/admin/price/a_upload">
                        <label for="upload">Загрузить прайслист</label>
                        <div class="input-group">
                            <input id="upload" name="file" type="file"/>
                        </div>
                        <br/>
                        <button type="submit">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>