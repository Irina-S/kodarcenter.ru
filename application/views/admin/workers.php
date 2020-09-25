<div class="articles">
    <a class="add-button" href="addworker"><div class="add-button-icon"></div><span>Добавить сотрудника</span></a>
    <?php if ($workers) : ?>
        <?php foreach ($workers as $worker) : ?>
            <article class="article">
                <div class="articles-first-col">
                    <?php if ($worker['photo_path']!='') : ?>
                        <img class="articles-img photo-img" src=<?='/'.$worker['photo_path'] ?>>
                    <?php else : ?>
                        <img class="articles-img photo-img" src=<?='/public/img/no-photo.svg' ?>>
                    <?php endif; ?>
                </div>                         
                <div class="articles-second-col">
                    <h3 class="articles-header"><a href=<?='editworker?worker_id='.$worker['worker_id']?>><?=$worker['name'] ?></a></h3>
                    <div class="articles-text">
                         <?=$worker['position'] ?>
                        <button type="button" class="del-button" title="Удалить сотрудника" data-url="delworker" data-id=<?=$worker['worker_id'] ?>></button>
                        <a href=<?='editworker?worker_id='.$worker['worker_id']?> class="edit-button" title="Редактировать информацию о сотруднике"></a>
                    </div>
                </div> 
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</div>