<div class="articles" id="articles">
    <?php if ($galleryImgs && count($galleryImgs)>0) : ?>
        <article class="article">
            <div class="articles-second-col">
                <h3 class="articles-header">Галерея</h3>
                <div class="sim-slider">
                    <ul class="sim-slider-list">
                        <li><img src="http://pvbk.spb.ru/inc/slider/imgs/no-image.gif" alt="screen"></li> <!-- это экран -->
                        <?php foreach($galleryImgs as $galleryImg) : ?>
                            <li class="sim-slider-element"><img src=<?="/public/userimg/gallery/".$galleryImg?>></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="sim-slider-arrow-left"></div>
                    <div class="sim-slider-arrow-right"></div>
                    <div class="sim-slider-dots"></div>
                </div>
            </div>
        </article>
    <?php endif; ?>

    <?php if($sections) : ?>
        <?php foreach ($sections as $section) : ?>
            <article class="article">
                <div class="articles-second-col">
                    <h3 class="articles-header"><?=$section['about_us_section_name'] ?></h3>
                    <div class="articles-text">
                        <?=$section['about_us_section_contents'] ?>
                        <?php if ($section['about_us_section_name']=='Фильм "Кодар открывает тебя"') :?>
                            <iframe class="film" width="560" height="315" src="https://www.youtube.com/embed/5b1jHFziIkQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <?php endif ?>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<aside class="sidebar"></aside>

<script src="/public/js/slider.js"></script>
<script src="/public/js/aboutus.js"></script>