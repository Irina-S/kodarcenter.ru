<form class="gallery-edit-form" action=<?=$formAction ?> method="POST" enctype="multipart/form-data">
    <h3>Галерея</h3>
    <div class="gallery-imgs">
        <?php if (count($imgs)!=0) : ?>
            <?php foreach($imgs as $img) : ?>
                <div class="gallery-img-container" data-img-name=<?=$img?>>
                    <img class="gallery-img" src=<?='/public/userimg/gallery/'.$img ?>>
                    <div class="gallery-img-del-button" title="Удалить изображение"></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        
    </div>
    
    <label for="img-input">Добавить изображения</label>
    <input name="img[]" id="img-input" type="file" accept="image/jpeg,image/png,image/gif">

    <button class="add-button" id="more-files-button" type="button"><div class="add-button-icon"></div>Еще файл</button>

    <input name="gallery-submit" type="submit" value="Загрузить">
</form>
<script src="/public/js/gallery-edit.js"></script>