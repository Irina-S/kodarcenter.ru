<?php if ($workers && count($workers)>0) : ?>
    <div class="workers-cards" id="workers-cards">
        <?php foreach($workers as $worker) : ?>    
            <div class="js-workers-card">
                <div class="workers-card-wrapper">
                    <div class="workers-card">

                        <?php if ($worker['photo_path']!='') : ?>
                            <img class="workers-photo" src=<?='/'.$worker['photo_path'] ?>>
                        <?php else : ?>
                            <img class="workers-photo" src=<?='/public/img/no-photo.svg' ?>>
                        <?php endif; ?>

                        <h3 class="workers-name"><?=$worker['name'] ?></h3>

                        <?php if ($worker['position']!='') : ?>
                            <?php $workersPositions = explode(',', $worker['position']); ?>
                            <?php foreach($workersPositions as $workerPosition) : ?>
                                <span class="workers-position"><?=trim($workerPosition) ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <span class="more-about-worker">подробнее</span>
                        <?php if ($worker['vk_link']!='') : ?>
                            <a class="workers-vk" href=<?=$worker['vk_link'] ?> title="Cвязаться в Контакте"></a>
                        <?php endif; ?>
                    </div>

                    <div class="about-worker">
                        <?=$worker['details'] ?>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
        
    </div>                                  
<?php endif; ?>
                                  

<script src="/public/js/workers.js"></script>