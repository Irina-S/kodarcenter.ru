<article class="article">
    <div class="articles-first-col"></div>                         
    <div class="articles-second-col">
        <h3 class="articles-header"><a href="gallery">Галерея</a></h3>
        <div class="articles-text">
            <a href="gallery" class="edit-button" title="Редактировать"></a>
        </div>
    </div> 
</article>
<?php if (!empty($sections)) : ?>
    <?php foreach ($sections as $section) : ?>
        <article class="article">
            <div class="articles-first-col"></div>                         
            <div class="articles-second-col">
                <h3 class="articles-header"><a href=<?='aboutusedit?section_id='.$section['about_us_section_id'] ?>><?=$section['about_us_section_name'] ?></a></h3>
                <div class="articles-text">                                       
                    <a href=<?='aboutusedit?section_id='.$section['about_us_section_id'] ?> class="edit-button" title="Редактировать запись"></a>
                </div>
            </div> 
        </article>
    <?php endforeach; ?>
<?php endif; ?>