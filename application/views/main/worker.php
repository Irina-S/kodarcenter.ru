<div class="articles" id="articles">
    <article class="article"> 
        <div class="articles-first-col"><?php if ($worker['photo_path']!='') : ?><img class="articles-img" src=<?php echo '/'.$worker['photo_path'] ?>><?php endif; ?></div>                         
        <div class="articles-second-col">
            <h3 class="articles-header"><?=$worker['name'] ?></h3>
            <div class="articles-date"><?=$worker['position'] ?></div>
            <div class="articles-text">
                <?=$worker['details'] ?>
            </div>
    </article>
</div>