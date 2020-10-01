<div class="articles" id="articles">

    <?php if ($articles) :?>
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
    <?php else : ?>
        Здесь пока ничего нет!
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

<aside class="sidebar">
    <!-- <div class="datepicker-here sidebar-elem" data-classes="calendar">
    </div> -->
    <div class="sidebar-elem" id="articles-datepicker" data-classes="calendar">
    </div>
</aside>

<?php if (isset($dates)) : ?>
    <script>
        let section = <?="'$page'" ?>;
        let serverDates = <?=$dates ?>;

        let dates = serverDates.map(function(date){
            return (new Date(date)).toDateString();
        })

        $('#articles-datepicker').datepicker({
                // Передаем функцию, которая добавляет 11 числу каждого месяца класс 'my-class'
                // и делает их невозможными к выбору.
                onRenderCell: function(date, cellType) {
                    // console.dir(date);

                    if (cellType == 'day' && dates.indexOf(date.toDateString())!=-1) {
                        return {
                            html: `<a href="${section}?date=${serverDates[dates.indexOf(date.toDateString())]}">`+date.getDate() + `</a>`,
                            classes: 'date-link'
                        }
                    }
                }
            })

    </script>
<?php endif; ?>
