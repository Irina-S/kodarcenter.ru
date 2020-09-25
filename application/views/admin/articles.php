<div class="articles">
    <a class="add-button"  href=<?=($sectionsState['articles']!=''?'addarticle':'addnews') ?>><div class="add-button-icon"></div><span>Добавить</span></a>
    <?php if ($articles) : ?>
        <?php foreach ($articles as $article) : ?>
            <article class="article">
                <div class="articles-first-col"><?php if ($article['img_path']!='') : ?><img class="articles-img" src=<?php echo '/'.$article['img_path'] ?>><?php endif; ?></div>                         
                <div class="articles-second-col">
                    <h3 class="articles-header"><a href=<?=($sectionsState['articles']!=''?'editarticle':'editnews')."?id=".$article['article_id'] ?> ><?=$article['header'] ?></a></h3>
                    <div class="articles-date"><?=$article['date'] ?></div>
                    <div class="articles-text">
                        <?=$article['text'] ?>
                        <button type="button" class="del-button" title="Удалить запись" data-id=<?= $article['article_id']?> data-url=<?=($sectionsState['articles']!=''?'delarticle':'delnews') ?>></button>
                        <a href=<?=($sectionsState['articles']!=''?'editarticle':'editnews')."?id=".$article['article_id'] ?> class="edit-button" title="Редактировать запись"></a>
                    </div>
                </div> 
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <?php if (isset($pages) && $pages>1) : ?>
        <ul class="page-numbers">
            <?php if ($curPage==1) : ?>
                <li class="page-number current">1</li>
            <?php else : ?>
                <li class="page-number clickable"><a href=<?='news?page=1'?>>1</a></li>
            <?php endif; ?>

            <?php if ($curPage-1>=4) :?>
                <li class="page-number">...</li>
            <?php endif; ?>

            <?php if ($pages>2) : ?>
                <?php
                    $start = ($curPage-1>=4)?$curPage-1:2;
                    $end = ($pages-$curPage>=4)?$curPage+1:$pages-1;
                ?>
                <?php for ($i=$start; $i<=$end; $i++) : ?>
                    <?php if ($i==$curPage) : ?>
                        <li class="page-number current"><?=$i ?></li>
                    <?php else : ?>
                        <li class="page-number clickable"><a href=<?='news?page='.$i ?>><?=$i ?></a></li>
                    <?php endif; ?> 
                <?php endfor; ?>
            <?php endif; ?>
            
            <?php if ($pages-$curPage>=4) :?>
                <li class="page-number">...</li>
            <?php endif; ?>

            <?php if ($curPage==$pages) : ?>
                <li class="page-number current"><?=$pages ?></li>
            <?php else : ?>
                <li class="page-number clickable"><a href=<?='news?page='.$pages ?>><?=$pages ?></a></li>
            <?php endif; ?>

        </ul>
    <?php endif; ?>
</div>