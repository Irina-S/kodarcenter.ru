<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\lib\Db;

class MainController extends Controller{

    private $articlesPerPage = 5;

    public function indexAction(){
        $this->view->redirect('main/news');
    }

    public function newsAction(){

        if (isset($_GET['date'])){
            $articles = $this->model->getArticlesByDate('news', $_GET['date']);
        }
        else {
            if (isset($_GET['page']) && is_numeric($_GET['page']))
                $offset = ($_GET['page'] - 1)*$this->articlesPerPage;
            else 
                $offset = 0;
            $articles = $this->model->getArticlesArray('news', $offset, $this->articlesPerPage);
            $pages = $this->model->countPages('news', $this->articlesPerPage);
            $curPage=$offset?$_GET['page']:1;
        }
        
        $dates = $this->model->getAllDates('news');

        $vars = [
            'navState' => [
                'news'=>'selected',
                'aboutus' => '',
                'price' => '',
                'workers'=>'',
                'articles'=>'',
                'graphics'=>'',
                'contacts'=>''
            ],
            'page' => 'news',
            'articles' => $articles,
            'pages'=>isset($pages)?$pages:NULL,
            'curPage'=>isset($curPage)?$curPage:NULL,
            'dates'=>json_encode($dates)
        ];
        $this->view->setView('articles');
        $this->view->render('Новости', 'default', $vars);
    }

    public function articleAction(){
        if (isset($_GET['id'])){
            $article = $this->model->getArticleById($_GET['id']);
            $vars = [
                'navState' => [
                    'news'=>$article['section_type']=='news'?'selected':'',
                    'aboutus' => '',
                    'price' => '',
                    'workers'=>'',
                    'articles'=>$article['section_type']=='article'?'selected':'',
                    'graphics'=>'',
                    'contacts'=>''
                ],
                'page' => 'article',
                'article' => $article
            ];
            $this->view->render($article['header'], 'default', $vars);
        }
        else{
            View::errorCode(404);
        }
    }

    public function aboutusAction(){
        $galleryImgs = $this->model->getGalleryImgs();
        $sections = $this->model->getSections();
        $vars = [
            'navState' => [
                'news'=>'',
                'aboutus' => 'selected',
                'price' => '',
                'workers'=>'',
                'articles'=>'',
                'graphics'=>'',
                'contacts'=>''
            ],
            'page' => 'aboutus',
            'galleryImgs' => $galleryImgs,
            'sections'=> $sections
        ];
        $this->view->render('О нас', 'default', $vars);
    }

    public function priceAction(){
        $price = $this->model->getPrice();
        $priceSections = $this->model->getPriceSections();
        $vars = [
            'navState' => [
                'news'=>'',
                'aboutus' => '',
                'price' => 'selected',
                'workers'=>'',
                'articles'=>'',
                'graphics'=>'',
                'contacts'=>''
            ],
            'page' => 'price',
            'price' => $price,
            'priceSections'=> $priceSections
        ];
        // debug($priceSections);
        $this->view->render('Прайс', 'default', $vars);
    }

    public function workersAction(){
        $workers = $this->model->getWorkersArray();
        // debug($workers);
        $vars = [
            'navState' => [
                'news'=>'',
                'aboutus' => '',
                'price' => '',
                'workers'=>'selected',
                'articles'=>'',
                'graphics'=>'',
                'contacts'=>''
            ],
            'page' => 'workers',
            'workers' => $workers
        ];
        // debug(explode(', ', $workers[0]['position']));
        $this->view->render('Сотрудники', 'default', $vars);
    }

    public function articlesAction(){
        if (isset($_GET['date'])){
            $articles = $this->model->getArticlesByDate('articles', $_GET['date']);
        }
        else {
            if (isset($_GET['page']) && is_numeric($_GET['page']))
                $offset = ($_GET['page'] - 1)*$this->articlesPerPage;
            else 
                $offset = 0;
            $articles = $this->model->getArticlesArray('article', $offset, $this->articlesPerPage);
            $pages = $this->model->countPages('article', $this->articlesPerPage);
            $curPage=$offset?$_GET['page']:1;

        }
        
        $dates = $this->model->getAllDates('article');
        // debug($dates);

        $vars = [
            'navState' => [
                'news'=>'',
                'aboutus' => '',
                'price' => '',
                'workers'=>'',
                'articles'=>'selected',
                'graphics'=>'',
                'contacts'=>''
            ],
            'page' => 'articles',
            'articles' => $articles,
            'pages'=>isset($pages)?$pages:NULL,
            'curPage'=>isset($curPage)?$curPage:NULL,
            'dates'=>json_encode($dates)
            
        ];
        $this->view->render('Статьи', 'default', $vars);
    }

    public function graphicsAction(){
        $graphics = $this->model->getGraphics();
        $graphicsSections = $this->model->getGraphicsSections();
        $vars = [
            'navState' => [
                'news'=>'',
                'aboutus' => '',
                'price' => '',
                'workers'=>'',
                'articles'=>'',
                'graphics'=>'selected',
                'contacts'=>''
            ],
            'page' => 'graphics',
            'graphics'=>$graphics,
            'graphicsSections'=>$graphicsSections
        ];
        // debug($priceSections);
        $this->view->render('Графики', 'default', $vars);
    }

    public function contactsAction(){
        $contacts = $this->model->getContacts();
        // debug($contacts);
        $vars = [
            'navState' => [
                'news'=>'',
                'aboutus' => '',
                'price' => '',
                'workers'=>'',
                'articles'=>'',
                'graphics'=>'',
                'contacts'=>'selected'
            ],
            'page' => 'contacts',
            'contacts'=>$contacts,
            'contactsIds'=> array_column($contacts, 'input_id')
        ];

        $this->view->render('Контакты', 'default', $vars);
    }

    public function requestAction(){
        // debug($_POST);
        $res = $this->model->putRequest($_POST['request-name'], $_POST['request-phone'], $_POST['request-comment']);
        if ($res)
            exit("Success");
        else 
            exit("Error");
    }

    public function searchAction(){
        if (isset($_GET['str']) && $_GET['str']!=''){
            $news = $this->model->searchNews($_GET['str']);
            $articles = $this->model->searchArticles($_GET['str']);
            // debug($articles);
            $workers = $this->model->searchWorkers($_GET['str']);
            $vars = [
                'navState' => [
                    'news'=>'',
                    'aboutus' => '',
                    'price' => '',
                    'workers'=>'',
                    'articles'=>'',
                    'graphics'=>'',
                    'contacts'=>''
                ],
                'page' => 'search',
                'news'=>$news,
                'articles'=>$articles,
                'workers'=>$workers
            ];
            $this->view->render('Результаты поиска', 'default', $vars);
        }
        else{
            $this->view->redirect('news');
            // echo "бла";
        }
    }

    public function workerAction(){
        if (isset($_GET['id'])){
            $worker = $this->model->getWorkerById($_GET['id']);
            $vars = [
                'navState' => [
                    'news'=>'',
                    'aboutus' => '',
                    'price' => '',
                    'workers'=>'selected',
                    'articles'=>'',
                    'graphics'=>'',
                    'contacts'=>''
                ],
                'page' => 'worker',
                'worker' => $worker
            ];
            $this->view->render($worker['name'], 'default', $vars);
        }
        else{
            $this->view->redirect('workers');
        }
    }

}