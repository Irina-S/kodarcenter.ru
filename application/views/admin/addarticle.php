<form class="article-edit-form" method="POST" action=<?=$formAction ?> enctype="multipart/form-data">
    <h3><?=$title ?></h3>
        <label for="article-header-input">Заголовок <span class="asteriks">*</span></label>
        <input name="article-header" id="article-header-input" type="text" <?php if(isset($articleInfo['header'])) echo 'value="'.$articleInfo['header'].'"'?>>

        <label for="article-text-input">Текст <span class="asteriks">*</span></label>
        <textarea name="article-text" id="article-text-input" rows="10" wrap="soft"><?php if(isset($articleInfo['text'])) echo $articleInfo['text']?></textarea>

        <label for="article-img-input">Изображение</label>

        <?php if (isset($articleInfo) && $articleInfo['img_path']!='') : ?>
            <div class="article-img-container" data-img-path=<?=$articleInfo['img_path']?> data-article-id=<?=$articleInfo['article_id']?>>
                <img class="article-img" src=<?='/'.$articleInfo['img_path'] ?>>
                <div class="article-img-del-button" title="Удалить изображение"></div>
            </div>
        <?php endif; ?>
        
        <input name="article-img" id="article-img-input" type="file" accept="image/jpeg,image/png,image/gif">

        <p><span class="asteriks">*</span> - обязательно для заполнения</p>
        
        <input type="hidden" name="article-img-path" value=<?php if(isset($articleInfo) && $articleInfo['img_path']!='') echo $articleInfo['img_path']?>>
        <input type="hidden" name="article-date" value=<?php if(isset($articleInfo) && isset($articleInfo['date'])) echo $articleInfo['date']?>>
        <input type="hidden" name="article-id" value=<?php if(isset($articleInfo) && isset($articleInfo['article_id'])) echo $articleInfo['article_id']?>>
        <input name="article-submit" type="submit" value="Отправить">
</form>