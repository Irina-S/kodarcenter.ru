<div class="articles" id="articles">
    <article class="article"> 
        <div class="articles-first-col"><?php if ($article['img_path']!='') : ?><img class="articles-img" src=<?php echo '/'.$article['img_path'] ?>><?php endif; ?></div>                         
        <div class="articles-second-col">
            <h3 class="articles-header"><?=$article['header'] ?></h3>
            <div class="articles-date"><?=$article['date'] ?></div>
            <div class="articles-text">
                <?=$article['text'] ?>
                <!-- <a class="comments-amount" title="5 комментариев"><div class="comments-icon"></div>5</a> -->
            </div>
    </article>
</div>