<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=$title ?> - Центр психотерапии "Кодар"</title>
        <link href="/public/css/datepicker.css" rel="stylesheet" type="text/css">
        <link href="/public/css/global.css" rel="stylesheet" type="text/css">
        <link href="/public/css/index.css" rel="stylesheet" type="text/css">

        <?php if (isset($page) && $page=='aboutus') : ?>
            <link href="/public/css/aboutus.css" rel="stylesheet" type="text/css">
        <?php endif; ?>
        
        <?php if (isset($page) && ($page=='price' || $page='graphics')) : ?>
            <link href="/public/css/price.css" rel="stylesheet" type="text/css">
        <?php endif; ?>

        <link href="/public/css/workers.css" rel="stylesheet" type="text/css">
          
        <link href="/public/css/contacts.css" rel="stylesheet" type="text/css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="/public/js/datepicker.js"></script>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    </head>
    <body>
        <div class="wrapper">
            <div class="up-button" id="up-button"></div>
            <header class="header">
                <a href="http://kodarcenter.ru" class="logo-link">
                    <div class="logo"></div>
                    <div class="logo-text">центр психотерапии</div>
                </a>
                <div class="contacts">
                    <div class="phone">
                        <div class="phone-icon"></div>
                        <div class="tel">
                            8 (3022) <strong>31-87-59</strong>
                        </div>
                    </div>
                    <div class="shedule">
                        Пн.- Пт. 10:00 - 21:00<br>
                        Сб.- Вс. 10:00 - 18:00
                    </div>
                </div>
            </header>
            <nav class="nav" id="nav">
                <form action="search" method="GET">
                    <div class="search-wrapper">
                    
                        <button class="search-button icon-search" type="submit"></button>
                        <input class="search-field" name="str" type="text">
                    
                    </div> 
                </form>
                <!-- гамбургер меню -->
                <div class="menu icon-menu" id="menu"></div>
                <ul class="nav-list" id="nav-list">
                    <li class=<?php echo '"nav-item '.$navState['news'].'"' ?>><a href="news">Новости</a></li>
                    <li class=<?php echo '"nav-item '.$navState['aboutus'].'"' ?>><a href="aboutus">О нас</a></li>
                    <li class=<?php echo '"nav-item '.$navState['price'].'"' ?>><a href="price">Прайс</a></li>
                    <li class=<?php echo '"nav-item '.$navState['workers'].'"' ?>><a href="workers">Сотрудники</a></li>
                    <li class=<?php echo '"nav-item '.$navState['articles'].'"' ?>><a href="articles">Статьи</a></li>
                    <li class=<?php echo '"nav-item '.$navState['graphics'].'"' ?>><a href="graphics">Графики</a></li>
                    <li class=<?php echo '"nav-item '.$navState['contacts'].'"' ?>><a href="contacts">Контакты</a></li>
                </ul>
            </nav>
            <div class="main clearfix">
                <div class="content" id="content">
                    <?php 
                        echo $content; 
                    ?>
                </div>            
            </div>
        </div>
        <footer class="footer ">
                <div class="footer-section-one">
                    <h3 class="footer-section-header">Контакты</h3>
                    <ul class="footer-contacts">
                        <li>8-30-22-31-87-59</li>
                        <li>672000, г. Чита,  ул. Анохина д.52 </li>
                        <li><a href="mailto:pc-kodar@mail.ru">pc-kodar@mail.ru</a></li>
                        <li><a href="https://vk.com/chitakodar">В Контакте</a></li>
                        <li><a href="https://instagram.com/kodar_chita_official">Instagram</a></li>
                    </ul>
                </div>
                <div class="footer-section-two">
                    <h3 class="footer-section-header">Мы на карте</h3>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2454.7908772839937!2d113.50499531532991!3d52.02890728025969!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5dcbcacb3c3b0b51%3A0x418ed4fff7a84199!2z0JrQvtC00LDRgCwg0L_RgdC40YXQvtGC0LXRgNCw0L_QtdCy0YLQuNGH0LXRgdC60LjQuSDRhtC10L3RgtGA!5e0!3m2!1sru!2sru!4v1574346261249!5m2!1sru!2sru"  frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                </div>
                <div class="footer-section-three">
                    <h3 class="footer-section-header">Заказать звонок</h3>
                    <form action="request" method="POST">
                        <input type="text" name="request-name" class="name" placeholder="Ваше имя"><br>
                        <input type="text" name="request-phone" class="number" placeholder="Ваш телефон"><br>
                        <textarea class="comment" name="request-comment" rows="4" placeholder="Комментарий"></textarea><br>
                        <input class="send-req-btn" type="submit" id="request-submit" value="Заказать">
                    </form>
                </div>
        </footer>
        <script src="/public/js/global.js"></script>
        <script src="/public/js/request.js"></script>
        <script src="/public/js/hamburger-menu.js"></script>
    </body>
</html>