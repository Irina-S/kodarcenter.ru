<div class="articles" id="articles">

<?php if (isset($workers) && count($workers)>0) : ?>
        <h3 class="search-res-category">Сотрудники <span class="search-res-amount"><?=count($workers) ?></span></h3>
    <?php endif; ?>

    <?php foreach ($workers as $worker) : ?>
        <article class="article">
            <div class="articles-first-col"><?php if ($worker['photo_path']!='') : ?><img class="articles-img" src=<?php echo '/'.$worker['photo_path'] ?>><?php endif; ?></div>                         
            <div class="articles-second-col">
                <h2 class="articles-header"><a href=<?='worker?id='.$worker['worker_id'] ?>><?=$worker['name'] ?></a></h2>
                <div class="articles-date"><?=$worker['position'] ?></div>
                <div class="articles-text">
                    <?=$worker['details'] ?>
                    <a href=<?='worker?id='.$worker['worker_id'] ?> class="read-more-btn">Подробнее</a>
                </div>
            </div> 
        </article>
    <?php endforeach; ?>




    <?php if (isset($news) && count($news)>0) : ?>
        <h3 class="search-res-category">Новости <span class="search-res-amount"><?=count($news) ?></span></h3>
    <?php endif; ?>

    <?php foreach ($news as $article) : ?>
        <article class="article">
            <div class="articles-first-col"><?php if ($article['img_path']!='') : ?><img class="articles-img" src=<?php echo '/'.$article['img_path'] ?>><?php endif; ?></div>                         
            <div class="articles-second-col">
                <h3 class="articles-header"><a href=<?='article?id='.$article['article_id'] ?>><?=$article['header'] ?></a></h3>
                <div class="articles-date"><?=$article['date'] ?></div>
                <div class="articles-text">
                    <?=$article['text'] ?>
                    <a href=<?='article?id='.$article['article_id'] ?> class="read-more-btn">Подробнее</a>
                </div>
            </div> 
        </article>
    <?php endforeach; ?>


    <?php if (isset($articles) && count($articles)>0) : ?>
        <h3 class="search-res-category">Статьи <span class="search-res-amount"><?=count($articles) ?></span></h3>
    <?php endif; ?>

    <?php foreach ($articles as $article) : ?>
        <article class="article">
            <div class="articles-first-col"><?php if ($article['img_path']!='') : ?><img class="articles-img" src=<?php echo '/'.$article['img_path'] ?>><?php endif; ?></div>                         
            <div class="articles-second-col">
                <h3 class="articles-header"><a href=<?='article?id='.$article['article_id'] ?>><?=$article['header'] ?></a></h3>
                <div class="articles-date"><?=$article['date'] ?></div>
                <div class="articles-text">
                    <?=$article['text'] ?>
                    <a href=<?='article?id='.$article['article_id'] ?> class="read-more-btn">Подробнее</a>
                </div>
            </div> 
        </article>
    <?php endforeach; ?>
    
</div>
<aside class="sidebar">

</aside>