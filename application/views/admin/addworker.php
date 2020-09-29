<form class="article-edit-form" method="POST" action=<?=$formAction?> enctype="multipart/form-data">
    <h3><?=$title ?></h3>

        <label for="worker-name-input">ФИО<span class="asteriks">*</span></label>
        <input name="worker-name" id="worker-name-input" type="text" <?php if (isset($worker['name'])) echo 'value="'.$worker['name'].'"'?>>

        <label for="worker-position-input">Должность(и) (через запятую) <span class="asteriks">*</span></label>
        <input name="worker-position" id="worker-position-input" type="text" <?php if (isset($worker['position'])) echo 'value="'.$worker['position'].'"'?>>

        <label for="worker-vk-input">Ссылка на страницу ВК</label>
        <input name="worker-vk" id="worker-vk-input" type="text" <?php if (isset($worker['vk_link'])) echo 'value="'.$worker['vk_link'].'"'?>>

        <label for="worker-information-input">Дополнительная информация</label>
        <textarea name="worker-details" id="worker-information-input" rows="10" wrap="soft"><?php if (isset($worker['details'])) echo $worker['details']?></textarea>

        <label for="worker-photo-input">Фото</label>

        <?php if (isset($worker['photo_path']) && $worker['photo_path']!='') : ?>     
            <div class="worker-photo-container" data-photo-path=<?=$worker['photo_path']?> data-worker-id=<?=$worker['worker_id']?>>
                <img class="worker-photo" src=<?='/'.$worker['photo_path'] ?>>
                <div class="worker-photo-del-button" title="Удалить изображение"></div>
            </div>
        <?php endif; ?>

        <input type="hidden" name="photo-img-path" <?php if (isset($worker['photo_path'])) echo 'value="'.$worker['photo_path'].'"'?>>
        <input type="hidden" name="worker-id" <?php if (isset($worker['worker_id'])) echo 'value="'.$worker['worker_id'].'"'?>>

        <input name="worker-photo" id="worker-photo-input" type="file" accept="image/jpeg,image/png,image/gif">

    <p><span class="asteriks">*</span> - обязательно для заполнения</p>

    <input name="worker-submit" type="submit" value="Отправить">
</form>