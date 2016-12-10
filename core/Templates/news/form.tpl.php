{% extends "layout.tpl.php" %}

{% block js %}
<script src="{{baseUrl}}assets/vendor/ckeditor/ckeditor.js"></script>
<script src="{{baseUrl}}assets/uploadpreview/js/jquery.uploadpreview.min.js"></script>
<script src="{{baseUrl}}assets/vendor/jquery-validation/dist/jquery.validate.js"></script>
<script src="{{baseUrl}}assets/vendor/jquery-validation/dist/additional-methods.js"></script>
<script src="{{baseUrl}}assets/vendor/jquery-validation/dist/localization/messages_ru.js"></script>
<script>
var ck_config = {
    filebrowserBrowseUrl: '{{baseUrl}}ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl: '{{baseUrl}}ckfinder/ckfinder.html?type=Images',
    filebrowserUploadUrl:
            '{{baseUrl}}ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&currentFolder=/archive/',
    filebrowserImageUploadUrl:
            '{{baseUrl}}ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&currentFolder=/cars/'
};
$(document).ready(function () {
    CKEDITOR.replace('body', ck_config);
    $.uploadPreview({
        input_field: "#image-upload",
        preview_box: ".image-preview",
        label_field: ".image-label",
        label_default: "Выбрать", // Default: Choose File
        label_selected: "Изменить"  // Default: Change File
    });
    $("#news-form").validate();
});
</script>

{% endblock %}

{% block css %}
<link rel="stylesheet" href="{{baseUrl}}assets/uploadpreview/css/uploadpreview.css">
{% endblock %}

{% block content %}
<section>
    <header>
        <h1>Добавить новость</h3>
    </header>
    <form method="POST" action="index.php?q=news/add" id="news-form" >
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="date">Дата публикации</label>
                    <input type="date" class="form-control" id="date" name="date" placeholder="Дата публикации"  required>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="form-group">
                    <label for="author">Автор</label>
                    <input type="text" class="form-control" id="author" name="author" placeholder="Автор" required>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="image">Изображение</label>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="img-thumbnail">
                                <div class="image-preview ">
                                    <label for="image-upload" class="image-label">Выбрать</label>
                                    <input type="file" name="image" id="image-upload" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="form-group">
                    <label for="short_text">Краткий текст</label>
                    <div class="row">
                        <div class="col-lg-12">
                            <textarea  class="form-control" rows=12 id="short_text" name="short_text" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="body">Полный текст</label>
            <textarea name="body"></textarea>
        </div>
        <hr/>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="published" checked value="1"><strong>Опубликовано</strong>        
            </label>
        </div>
        <hr/>
        <button type="submit" class="btn btn-primary btn-lg">Сохранить</button>



    </form>
</section>


{% endblock %}

