<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title><?php echo $title ?> - Панель управления сайтом kodarcenter.ru</title>
        <?php if(isset($login)) : ?>
            <link href="/public/css/login.css" rel="stylesheet" type="text/css">
        <?php else : ?>
            <link href="/public/css/admin.css" rel="stylesheet" type="text/css">
        <?php endif; ?>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    </head>
    <body>
        <?php if(isset($login)) : ?>
            <?=$content ?>
        <?php else : ?>
            <div class="wrapper">
                <div class="dashboard-header">
                    <div class="dashboard-header-text">
                        Панель управления сайтом <a href="http://kodarcenter.ru">kodarcenter.ru</a>
                    </div>
                    <div class="admin-name">
                        Администратор
                        <a title="Выйти из панели управления" href="logout"><img class="show-logout-button" src="/public/img/logout-icon.svg"></a>
                    </div>
                </div>
                <div class="main clearfix">
                    <div class="content" id="content">
                        <div class="dashboard-nav">
                            <ul class="dashboard-nav-list">
                                <li class=<?php echo '"dashboard-nav-list-item '.$sectionsState['news'].'"'?>><a href="news"><div class="list-item-icon news-icon" src=""></div>Новости</a></li>
                                <li class=<?php echo '"dashboard-nav-list-item '.$sectionsState['aboutus'].'"'?>><a href="aboutus"><div class="list-item-icon about-icon" src=""></div>О нас</a></li>
                                <li class=<?php echo '"dashboard-nav-list-item '.$sectionsState['workers'].'"'?>><a href="workers"><div class="list-item-icon workers-icon" src=""></div>Сотрудники</a></li>
                                <li class=<?php echo '"dashboard-nav-list-item '.$sectionsState['price'].'"'?>><a href="price"><div class="list-item-icon price-icon" src=""></div>Прайс</a></li>
                                <li class=<?php echo '"dashboard-nav-list-item '.$sectionsState['articles'].'"'?>><a href="articles"><div class="list-item-icon articles-icon" src=""></div>Статьи</a></li>
                                <li class=<?php echo '"dashboard-nav-list-item '.$sectionsState['graphics'].'"'?>><a href="graphics"><div class="list-item-icon graphics-icon" src=""></div>Графики</a></li>
                                <li class=<?php echo '"dashboard-nav-list-item '.$sectionsState['contacts'].'"'?>><a href="contacts"><div class="list-item-icon contacts-icon" src=""></div>Контакты</a></li>
                                <li class="dashboard-nav-list-item empty-separator"></li>
                                <li class=<?php echo '"dashboard-nav-list-item '.$sectionsState['requests'].'"'?>><a href="requests"><div class="list-item-icon request-icon" src=""></div>Заявки</a></li>
                            </ul>
                        </div>
                        <div class="dashboard-content-area">
                            <div class="location">
                                <div class="dashboard-icon"></div>
                                <div class="section-name">Главная</div>
                                <!-- сюда вставляется местоположение относительно главной страницы -->
                                <?php if(isset($location)): ?>
                                    <?php foreach($location as $locationItem): ?>
                                        <div class="section-separator"></div>
                                        <div class="section-name"><?php echo $locationItem ?></div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <!-- сюда вставляется содержимое в зависимости от раздела -->
                            <?php 
                                    echo $content; 
                            ?>
                        </div>
                    </div>           
                </div>
            </div>
        <?php endif; ?>
        <script src="/public/js/ajax.js"></script>
    </body>
</html>