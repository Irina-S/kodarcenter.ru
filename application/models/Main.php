<?php

namespace application\models;

use application\core\Model;
use DateTime;

class Main extends Model{

    public function putRequest($name, $phone, $comment=''){
        $sql = 'INSERT INTO request (name, phone_number, status, date, comment) VALUES (:name, :phone_number, :status, :date, :comment)';
        $date = new DateTime;
        $params = [
            'name' => $name,
            'phone_number'=>$phone,
            'status'=>0,
            'date'=>$date->format('Y-m-d'),
            'comment'=>$comment
        ];
        if ($this->db->query($sql, $params))
            return true;
        else
            return false;
    }

    public function searchNews($searchStr){
        $sql = "SELECT * FROM article 
                WHERE ((header LIKE :str) OR
                (text LIKE :str))
                AND section_type=:section_type";
        $params = [
            'str'=>"%$searchStr%",
            'section_type' => 'news'
        ];
        $news = $this->db->rows($sql, $params);  
        foreach($news as &$article){
            $article['date'] = $this->convertDate($article['date']);
            $article['text'] = nl2br(mb_substr($article['text'], 0, 200, 'utf-8').'...');
        }
        return $news;     
    }

    public function searchArticles($searchStr){
        $sql = "SELECT * FROM article 
        WHERE ((header LIKE :str) OR
        (text LIKE :str))
        AND section_type=:section_type";
        $params = [
            'str'=>"%$searchStr%",
            'section_type' => 'article'
        ];
        $articles = $this->db->rows($sql, $params);
        foreach($articles as &$article){
            $article['text'] = nl2br(mb_substr($article['text'], 0, 200, 'utf-8').'...');
        }
        return $articles;
    }

    public function searchWorkers($searchStr){ 
        $sql = "SELECT * FROM worker 
                WHERE (name LIKE :str) OR
                (position LIKE :str) OR
                (details) LIKE :str";
        $params = [
            'str'=>"%$searchStr%"
        ];
        $workers = $this->db->rows($sql,$params);
        foreach($workers as &$worker){
            $article['details'] = nl2br(mb_substr($worker['details'], 0, 200, 'utf-8').'...');
        }
        return $workers;
    }

    public function getAllDates($section){
        $sql = 'SELECT date FROM article WHERE section_type=:section_type';
        $params = [
            'section_type'=>$section
        ];
        $res = $this->db->rows($sql, $params);
        if ($res){
            return array_column($res, 'date');
        }
        return false;
    }

    public function getArticlesByDate($section, $date){
        $sql = 'SELECT * FROM article 
        WHERE section_type=:section_type AND 
        date=:date';
        $params = [
            'section_type'=>$section,
            'date'=>$date
        ];

        $articleArray = $this->db->rows($sql, $params);

        if ($articleArray){
            foreach ($articleArray as &$article){
                if (isset($article['date']))
                    $article['date'] = $this->convertDate($article['date']);
                $article['text'] = nl2br(mb_substr($article['text'], 0, 200, 'utf-8').'...');
            }
            return $articleArray;
        }

        return false;
    }

}