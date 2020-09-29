<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\lib\Db;
use DateTime;

class AdminController extends Controller{

    
    
    private $articlesPerPage = 5;

    // ЛОГИН И ВЫХОД

    public function loginAction(){
        if (isset($_SESSION['admin']['id'])){
            $this->view->redirect('news');
        }
        else{
            $errorMsg = '';
            if (isset($_POST['login-submit'])){
                $id = $this->model->checkLoginAndPassword($_POST['login'], $_POST['password']);
                if ($id){
                    $_SESSION['admin']['id'] = $id;
                    $this->view->redirect('news');
                }
                else{
                    $errorMsg = 'Неверный логин или пароль!';
                }
            }
            $vars = [
                'login' => TRUE,
                'errorMsg' => $errorMsg
            ];
            $this->view->render('Вход в панель управления', 'admin', $vars);
        }
        
    }

    public function logoutAction(){
        // Очистить данные сессии для текущего сценария
        $_SESSION = [];
        // Удалить cookie, соответствующую SID
        $sid = session_name();
        unset($_COOKIE[$sid]);
        // Уничтожить хранилище сессии
        session_destroy(); 


        $this->view->redirect('login');
    }

    // ***************************************************************************************

    // ДЕЙСВИЯ В РАЗДЕЛЕ "НОВОСТИ"

    public function newsAction(){
        if (isset($_GET['page']) && is_numeric($_GET['page']))
            $offset = ($_GET['page'] - 1)*$this->articlesPerPage;
        else 
            $offset = 0;
        $articles = $this->model->getArticlesArray('news', $offset, $this->articlesPerPage);
        $pages = $this->model->countPages('news', $this->articlesPerPage);
        // debug($articles);
        $vars= [
            'location' => ['Новости'],
            'sectionsState' => [
                'news'=>'opened-section',
                'aboutus'=>'',
                'workers'=>'',
                'price'=>'',
                'articles'=>'',
                'graphics'=>'',
                'contacts'=>'',
                'empty'=>'',
                'requests'=>''
            ],
            'articles' => $articles,
            'pages'=>$pages,
            'curPage'=>$offset?$_GET['page']:1
        ];
        // debug($vars);
        $this->view->setView('articles');
        $this->view->render('Новости', 'admin', $vars);
    }

    public function addnewsAction(){
        if (isset($_POST['article-submit'])){
            $imgPath = '';
            $date = new DateTime;
            if ($_FILES['article-img']['tmp_name']!=''){
                $id = intval($this->model->getLastArticleId())+1;
                // echo $id;
                $imgPath = $this->model->saveImg($_FILES['article-img'], $id, 'pictures');
            }
            if ($this->model->saveArticle($_POST['article-header'], 'news', $date->format('Y-m-d'), $_POST['article-text'], $imgPath))
                $this->view->redirect('news');
            else 
                View::errorCode(500);
        }
        $vars= [
            'location' => ['Новости', 'Добавление новости'],
            'sectionsState' => [
                'news'=>'opened-section',
                'aboutus'=>'',
                'workers'=>'',
                'price'=>'',
                'articles'=>'',
                'graphics'=>'',
                'contacts'=>'',
                'empty'=>'',
                'requests'=>''
            ],
            'formAction' => 'addnews'
        ];
        $this->view->setView('addarticle');
        $this->view->render('Добавление новости', 'admin', $vars);
    }

    public function editnewsAction(){
        if (isset($_POST['article-submit'])){
            $imgPath = $_POST['article-img-path'];
            // debug($_POST['article-img-path']);
            if ($_FILES['article-img']['tmp_name']!=''){
                $this->model->delImg('/kodarcenter-final/'.$imgPath);
                $imgPath = $this->model->saveImg($_FILES['article-img'], $_POST['article-id'], 'pictures');
            }
            if ($this->model->updateArticle($_POST['article-id'], $_POST['article-header'], $_POST['article-text'], $imgPath))
                $this->view->redirect('news');
            else
                View::errorCode(500);
        }
        else if(isset($_GET['id'])){
            $article = $this->model->getArticleById($_GET['id'], TRUE);
            // debug($article);
            $vars = [
                'articleInfo' =>$article,
                'location' => ['Новости', 'Редактирование новости'],
                'sectionsState' => [
                    'news'=>'opened-section',
                    'aboutus'=>'',
                    'workers'=>'',
                    'price'=>'',
                    'articles'=>'',
                    'graphics'=>'',
                    'contacts'=>'',
                    'empty'=>'',
                    'requests'=>''
                ],
                'formAction' => 'editnews'
            ];
            $this->view->setView('addarticle');
            $this->view->render('Редактирование новости', 'admin', $vars);
        }
    }

    // Ajax-запросы

    public function delnewsAction(){
        // debug($_POST['id']);
        $this->model->deleteArticle($_POST['id']);
    }



    // ***************************************************************************************

    // ДЕЙСВИЯ В РАЗДЕЛЕ "О НАС"

    public function aboutusAction(){
        $sections = $this->model->getSections();
        // debug($sections);
        $vars= [
            'location' => ['О нас'],
            'sectionsState' => [
                'news'=>'',
                'aboutus'=>'opened-section',
                'workers'=>'',
                'price'=>'',
                'articles'=>'',
                'graphics'=>'',
                'contacts'=>'',
                'empty'=>'',
                'requests'=>''
            ],
            'sections' => $sections
        ];
        $this->view->render('О нас', 'admin', $vars);
    }

    public function aboutuseditAction(){
        if (isset($_POST['section-submit'])){
            if ($this->model->updateAboutUsSection($_POST['section-id'], $_POST['section-text']))
                $this->view->redirect('aboutus');
            else
                View::errorCode(500);
        }
        else if(isset($_GET['section_id'])){
            $section = $this->model->getSectionById($_GET['section_id']);
            $vars = [
                'section' => $section,
                'location' => ['О нас', 'Редактирование раздела'],
                'sectionsState' => [
                    'news'=>'',
                    'aboutus'=>'opened-section',
                    'workers'=>'',
                    'price'=>'',
                    'articles'=>'',
                    'graphics'=>'',
                    'contacts'=>'',
                    'empty'=>'',
                    'requests'=>''
                ],
                'formAction' => 'aboutusedit'
            ];
            // $this->view->setView('addnews');
            $this->view->render('Редактирование раздела', 'admin', $vars);
        }
    }

    public function galleryAction(){
        if (isset($_POST['gallery-submit'])){
            // debug($_FILES);
            // $imgPath = $_POST['article-img-path'];
            // debug($_POST['article-img-path']);
            
            if ($_FILES['img']['tmp_name'][0]!=''){
                for ($i=0; $i<count($_FILES['img']['tmp_name']); $i++){
                    $imgName = $this->model->maxFileName('public/userimg/gallery')+1;
                    $imgPath = $this->model->moveImg($_FILES['img']['tmp_name'][$i], $imgName, $_FILES['img']['type'][$i], 'gallery');
                }
                
            }
            $this->view->redirect('gallery');
        }
        else{
            $imgs = $this->model->getGalleryImgs();
            $vars = [
                'imgs' => $imgs,
                'location' => ['Новости', 'О нас', 'Галерея'],
                'sectionsState' => [
                    'news'=>'',
                    'aboutus'=>'opened-section',
                    'workers'=>'',
                    'price'=>'',
                    'articles'=>'',
                    'graphics'=>'',
                    'contacts'=>'',
                    'empty'=>'',
                    'requests'=>''
                ],
                'formAction' => 'gallery'
            ];
            $this->view->render('Галерея', 'admin', $vars);
        }
    }

    // Ajax-запросы

    public function delimgAction(){
        // debug($_POST);
        $path = 'public/userimg/'.$_POST['destination'].'/'.$_POST['id'];
        $this->model->delImg($path);
        echo "Success";
    }

    // ***************************************************************************************

    // ДЕЙСВИЯ В РАЗДЕЛЕ "СОТРУДНИКИ"

    public function workersAction(){
        $workers = $this->model->getWorkersArray();
        $vars= [
            'location' => ['Сотрудники'],
            'sectionsState' => [
                'news'=>'',
                'aboutus'=>'',
                'workers'=>'opened-section',
                'price'=>'',
                'articles'=>'',
                'graphics'=>'',
                'contacts'=>'',
                'empty'=>'',
                'requests'=>''
            ],
            'workers' => $workers
        ];
        $this->view->render('Сотрудники', 'admin', $vars);
    }

    public function addworkerAction(){
        if (isset($_POST['worker-submit'])){
            $photoPath = '';
            if ($_FILES['worker-photo']['tmp_name']!=''){
                $id = intval($this->model->getLastWorkerId())+1;
                $photoPath = $this->model->saveImg($_FILES['worker-photo'], $id, 'photos');
            }
            if ($this->model->saveWorker($_POST['worker-name'], $_POST['worker-position'], $_POST['worker-vk'], $_POST['worker-details'], $photoPath))
                $this->view->redirect('workers');
            else
                View::errorCode(500);
        }
        $vars= [
            'location' => ['Сотрудники', 'Добавление сотрудника'],
            'sectionsState' => [
                'news'=>'',
                'aboutus'=>'',
                'workers'=>'opened-section',
                'price'=>'',
                'articles'=>'',
                'graphics'=>'',
                'contacts'=>'',
                'empty'=>'',
                'requests'=>''
            ],
            'formAction' => 'addworker'
        ];
        $this->view->render('Добавление сотрудника', 'admin', $vars);
    }

    public function editworkerAction(){
        if (isset($_POST['worker-submit'])){
            $photoPath = $_POST['photo-img-path'];
            if ($_FILES['worker-photo']['tmp_name']!=''){
                // $id = intval($this->model->getLastWorkerId())+1;
                $this->model->delImg('/kodarcenter-final/'.$photoPath);
                // $imgPath = $this->model->saveImg($_FILES['article-img'], $_POST['article-id'], 'pictures');
                $photoPath = $this->model->saveImg($_FILES['worker-photo'], $_POST['worker-id'], 'photos');
            }
            if ($this->model->updateWorker($_POST['worker-id'], $_POST['worker-name'], $_POST['worker-position'], $_POST['worker-vk'], $_POST['worker-details'], $photoPath))
                $this->view->redirect('workers');
            else
                View::errorCode(500);
        }
        else if (isset($_GET['worker_id'])){
            $worker = $this->model->getWorkerById($_GET['worker_id'], TRUE);
            $vars= [
                'worker' => $worker,
                'location' => ['Сотрудники', 'Редактирование информации о сотруднике'],
                'sectionsState' => [
                    'news'=>'',
                    'aboutus'=>'',
                    'workers'=>'opened-section',
                    'price'=>'',
                    'articles'=>'',
                    'graphics'=>'',
                    'contacts'=>'',
                    'empty'=>'',
                    'requests'=>''
                ],
                'formAction' => 'editworker'
            ];
            $this->view->setView('addworker'); 
            $this->view->render('Редактирование информации о сотруднике', 'admin', $vars);
        }
        
    }

    // Ajax-запросы

    public function delworkerAction(){
        // debug($_POST['id']);
        $this->model->deleteWorker($_POST['id']);
        
    }

    // ***************************************************************************************

    public function priceAction(){
        $price = $this->model->getPrice();
        $priceSections = $this->model->getPriceSections();
        $vars= [
            'price'=>$price,
            'priceSections'=>$priceSections,
            'location' => ['Редактирование прайса'],
            'sectionsState' => [
                'news'=>'',
                'aboutus'=>'',
                'workers'=>'',
                'price'=>'opened-section',
                'articles'=>'',
                'graphics'=>'',
                'contacts'=>'',
                'empty'=>'',
                'requests'=>''
            ],
        ];
        $this->view->render('Редактирование прайса', 'admin', $vars);
    }

    // Ajax-запросы

    public function editpriceAction(){
        // debug($_POST);
        $sections = $_POST['sections'];
        $services = $_POST['services'];
        if ($this->model->savePrice($sections, $services))
            exit("Success");
        else
            exit("Error");
    }

    // ***************************************************************************************

    public function articlesAction(){
        if (isset($_GET['page']) && is_numeric($_GET['page']))
            $offset = $_GET['page'] - 1;
        else 
            $offset = 0;
        $articles = $this->model->getArticlesArray('article', $offset, $this->articlesPerPage);
        $pages = $this->model->countPages('article', $this->articlesPerPage);
        // debug($articles);
        $vars= [
            'location' => ['Статьи'],
            'sectionsState' => [
                'news'=>'',
                'aboutus'=>'',
                'workers'=>'',
                'price'=>'',
                'articles'=>'opened-section',
                'graphics'=>'',
                'contacts'=>'',
                'empty'=>'',
                'requests'=>''
            ],
            'articles' => $articles,
            'pages'=>$pages,
            'curPage'=>$offset+1
        ];
        $this->view->render('Статьи', 'admin', $vars);
    }

    public function addarticleAction(){
        if (isset($_POST['article-submit'])){
            $imgPath = '';
            $date = new DateTime;
            if ($_FILES['article-img']['tmp_name']!=''){
                $id = intval($this->model->getLastArticleId())+1;
                // echo $id;
                $imgPath = $this->model->saveImg($_FILES['article-img'], $id, 'pictures');
            }
            if ($this->model->saveArticle($_POST['article-header'], 'article', $date->format('Y-m-d'), $_POST['article-text'], $imgPath))
                $this->view->redirect('articles');
            else 
                View::errorCode(500);
        }
        $vars= [
            'location' => ['Статьи', 'Добавление статьи'],
            'sectionsState' => [
                'news'=>'',
                'aboutus'=>'',
                'workers'=>'',
                'price'=>'',
                'articles'=>'opened-section',
                'graphics'=>'',
                'contacts'=>'',
                'empty'=>'',
                'requests'=>''
            ],
            'formAction' => 'addarticle'
        ];
        $this->view->render('Добавление статьи', 'admin', $vars);
    }

    public function editarticleAction(){
        // debug($_GET);
        if (isset($_POST['article-submit'])){
            $imgPath = $_POST['article-img-path'];
            // debug($_POST['article-img-path']);
            if ($_FILES['article-img']['tmp_name']!=''){
                $this->model->delImg('/kodarcenter-final/'.$imgPath);
                $imgPath = $this->model->saveImg($_FILES['article-img'], $_POST['article-id'], 'pictures');
            }
            if ($this->model->updateArticle($_POST['article-id'], $_POST['article-header'], $_POST['article-text'], $imgPath))
                $this->view->redirect('articles');
            else
                View::errorCode(500);
        }
        else if(isset($_GET['id'])){
            $article = $this->model->getArticleById($_GET['id'], TRUE);
            // debug($article);
            $vars = [
                'articleInfo' =>$article,
                'location' => ['Статьи', 'Редактирование статьи'],
                'sectionsState' => [
                    'news'=>'opened-section',
                    'aboutus'=>'',
                    'workers'=>'',
                    'price'=>'',
                    'articles'=>'opened-section',
                    'graphics'=>'',
                    'contacts'=>'',
                    'empty'=>'',
                    'requests'=>''
                ],
                'formAction' => 'editarticle'
            ];
            $this->view->setView('addarticle');
            $this->view->render('Редактирование статьи', 'admin', $vars);
        }
    }

    // Ajax-запросы

    public function delarticleAction(){
        $this->model->deleteArticle($_POST['id']);
    }

    // ***************************************************************************************

    public function graphicsAction(){
        $graphics = $this->model->getGraphics();
        $graphicsSections = $this->model->getGraphicsSections();
        $vars= [
            'graphics'=>$graphics,
            'graphicsSections'=>$graphicsSections,
            'location' => ['Редактирование графиков'],
            'sectionsState' => [
                'news'=>'',
                'aboutus'=>'',
                'workers'=>'',
                'price'=>'',
                'articles'=>'',
                'graphics'=>'opened-section',
                'contacts'=>'',
                'empty'=>'',
                'requests'=>''
            ],
        ];
        $this->view->render('Редактирование графиков', 'admin', $vars);
    }

    public function editgraphicsAction(){
        // debug($_POST);
        $sections = $_POST['sections'];
        $groups = $_POST['groups'];
        if ($this->model->saveGraphics($sections, $groups))
            exit("Success");
        else
            exit("Error");
    }

    // ***************************************************************************************

    public function contactsAction(){
        // $contacts = $this->model->getContacts();
        if (isset($_POST['contacts-submit']))
        // ЧТО ЭТО???????????????????????????????????????????????
            debug($_POST);
        else {
            $contacts = $this->model->getContacts();
            $vars= [
                'contacts' => $contacts,
                'location' => ['Редактирование контактов'],
                'sectionsState' => [
                    'news'=>'',
                    'aboutus'=>'',
                    'workers'=>'',
                    'price'=>'',
                    'articles'=>'',
                    'graphics'=>'',
                    'contacts'=>'opened-section',
                    'empty'=>'',
                    'requests'=>''
                ],
            ];
            $this->view->render('Редактирование контактов', 'admin', $vars);
        }
        
    }

    // Ajax-запросы

    public function editcontactsAction(){
        // debug($_POST['contacts']['id']);
        if ($this->model->updateContacts($_POST['contacts']))
            exit("Success");
        else
            exit("Error");
    }

    // ***************************************************************************************

    public function requestsAction(){
        $requests = $this->model->getRequests();
        // debug($requests);
        $vars= [
            'location' => ['Заявки'],
            'sectionsState' => [
                'news'=>'',
                'aboutus'=>'',
                'workers'=>'',
                'price'=>'',
                'articles'=>'',
                'graphics'=>'',
                'contacts'=>'',
                'empty'=>'',
                'requests'=>'opened-section'
            ],
            'requests' => $requests
        ];
        // $this->view->setView('articles');
        $this->view->render('Заявки', 'admin', $vars);
    }

    public function procrequestAction(){
        if ($this->model->setRequestProccesed($_POST['id']))
            exit("Success");
        else
            exit("Error");
    }

    // ***************************************************************************************

    public function delarticleimgAction(){
        $result = false;
        if (isset($_POST['article-id'])){
            if ($this->model->delImgPathFromDb('article', $_POST['article-id']))
                $result = true;
            if ($result)
                $result = $this->model->delImg($_POST['img-path']);    
        }
        else if (isset($_POST['worker-id'])){
            if ($this->model->delImgPathFromDb('worker', $_POST['worker-id']))
                $result = true;
            if ($result)
                $result = $this->model->delImg($_POST['photo-path']); 
        } 
        if ($result)
            echo "Success";
        else
            echo "Error";
    } 


}