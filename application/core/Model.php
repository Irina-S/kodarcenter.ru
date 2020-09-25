<?php

namespace application\core;

use application\lib\Db;

class Model{

    public $db;

    function __construct(){
        $this->db = new Db;
    }


    public function convertDate($dateStr){
        $dateParts = explode('-', $dateStr);
        $day = intval($dateParts[2]);
        $month = intval($dateParts[1]);
        $year = intval($dateParts[0]);
        $monthAsWord = '';
        switch($month){
            case 1: $monthAsWord = 'Января';
                break;
            case 2: $monthAsWord = 'Февраля';
                break;
            case 3: $monthAsWord = 'Марта';
                break;
            case 4: $monthAsWord = 'Апреля';
                break;
            case 5: $monthAsWord = 'Мая';
                break;
            case 6: $monthAsWord = 'Июня';
                break;
            case 7: $monthAsWord = 'Июля';
                break;
            case 8: $monthAsWord = 'Августа';
                break;
            case 9: $monthAsWord = 'Сентября';
                break;
            case 10: $monthAsWord = 'Октября';
                break;
            case 11: $monthAsWord = 'Ноября';
                break;
            case 12: $monthAsWord = 'Декабря';
                break;
        }
        $newDateStr = $day.' '.$monthAsWord.' '.$year;
        return $newDateStr;
    }

    public function countPages($section, $itemsPerPage){
        $sql = '';
        switch ($section){
            case 'news': $sql='SELECT count(*) FROM article WHERE section_type = \'news\'';
                        break;
            case 'articles':$sql='SELECT count(*) FROM article WHERE section_type = \'article\'';
                        break;
            case 'workers': $sql = 'SELECT count(*) FROM worker';
                        break;
        }
        // debug($sql);
        if ($sql){
            $items = $this->db->getSingleValue($sql);
            if ($items){
                $pages = floor($items/$itemsPerPage);
                if ($items%$itemsPerPage!=0)
                    $pages++;
                return $pages;
            }
        }
        return false;      
    }

    
    public function getArticlesArray($sectionType, $offset, $limit){
        $sql = 'SELECT * FROM article WHERE section_type = :section_type 
                ORDER BY date DESC, article_id DESC LIMIT '.$offset.', '.$limit;
        $params = [
            'section_type' => $sectionType,
        ];

        $articleArray = $this->db->rows($sql, $params);
        // debug($params);
        if ($articleArray){
            foreach ($articleArray as &$article){
                $article['date'] = $this->convertDate($article['date']);
                $article['text'] = nl2br(mb_substr($article['text'], 0, 300, 'utf-8').'...');
            }
            // debug($articleArray);
            return $articleArray;
        }
        else 
            return false; 
    }

    public function getArticleById($id, $editable=FALSE){
        $sql = 'SELECT * FROM article WHERE article_id=:article_id';
        $params = [
            'article_id' => $id
        ];
        $result = $this->db->row($sql, $params);
        if ($result){
            $result['date'] = $this->convertDate($result['date']);
            if (!$editable  && isset($result['text']))
                $result['text'] = nl2br($result['text']);
            return $result;
        }
            
        else 
            return false;
    }

    public function getWorkerById($id, $editable=FALSE){
        $sql = 'SELECT * FROM worker WHERE worker_id=:worker_id';
        $params = [
            'worker_id' => $id
        ];
        $result = $this->db->row($sql, $params);
        if ($result){
            if (!$editable && isset($result['text']))
                $result['text'] = nl2br($result['text']);
        }
        return $result;
    }

    public function getGalleryImgs(){
        $destination = 'public/userimg/gallery';
        $imgs = array_diff(scandir($destination), [".", ".."]);
        return $imgs;
    }

    public function getSections(){
        $sql = 'SELECT * FROM about_us_section';
        $articleArray = $this->db->rows($sql);
        if ($articleArray )
            return $articleArray ;
        else 
            return false;
    }

    public function getPrice(){
        $sql = 'SELECT * FROM price ORDER BY service_id';
        $res = $this->db->rows($sql);
        if ($res)
            return $res;
        else
            return false;
    }

    public function getPriceSections(){
        $sql = 'SELECT category FROM price GROUP BY category ORDER BY service_id';
        $res = $this->db->rows($sql);
        if ($res)
            return $res;
        else
            return false;
    }

    public function getWorkersArray(){
        $sql = 'SELECT * FROM worker ORDER BY worker_id ASC';
        $workers = $this->db->rows($sql);
        if ($workers)
            return $workers;
        else 
            return false;
    }

    public function getGraphics(){
        $sql = 'SELECT * FROM graphic ORDER BY graphic_id';
        $res = $this->db->rows($sql);
        if ($res)
            return $res;
        else
            return false;
    }

    public function getGraphicsSections(){
        $sql = 'SELECT group_name FROM graphic GROUP BY group_name ORDER BY graphic_id';
        $res = $this->db->rows($sql);
        if ($res)
            return $res;
        else
            return false;
    }

    public function getContacts(){
        $sql = 'SELECT * FROM contact';
        $contacts = $this->db->rows($sql);
        return $contacts;
    }
}