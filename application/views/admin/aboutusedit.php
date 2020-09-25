<form class="article-edit-form" method="POST" action=<?=$formAction ?>>
    <h3><?=$section['about_us_section_name'] ?></h3>

    <label for="section-text-input">Текст</label>
    <textarea name="section-text" id="section-text-input" rows="10" wrap="soft"><?php if(isset($section['about_us_section_contents'])) echo $section['about_us_section_contents']?></textarea>

    <input type="hidden" name="section-id" value=<?=$section['about_us_section_id']?>>
    <input name="section-submit" type="submit" value="Отправить">
</form>