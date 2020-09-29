<?php

namespace application\models;

use application\core\Model;

class Admin extends Model{

    // ЭТА ФУНКЦИЯ БЫЛА ДОБАВЛЕНА ТОЛЬКО ДЛЯ ТОГО, ЧТО БЫ ДОБАВИТЬ ДАННЫЕ В БД, КОТОРЫЕ НПРАВИЛЬНО ОТОБРАЖАЮТСЯ ИЗ-ЗА ПРОБЛЕМ С КОДИРОВКОЙ!!!
    // public function db(){
    //     $sql = "INSERT INTO `about_us_section` (`about_us_section_id`, `about_us_section_name`, `about_us_section_contents`) VALUES
    //     (1, 'Юридическая информация', ''),
    //     (2, 'Наша история', ''),
    //     (3, 'Фильм \"Кодар открывает тебя\"', '');";
    //     $result = $this->db->query($sql);
    //     $sql = "INSERT INTO `contact` (`contact_id`, `name`, `value`, `input_id`) VALUES
    //     (1, 'Адрес', 'г. Чита, ул. Анохина д.52', 'address'),
    //     (2, 'Телефон', '8-30-22-31-87-59', 'phone'),
    //     (3, 'E-mail', 'pc-kodar@mail.ru', 'email'),
    //     (4, 'График работы', '', 'shedule'),
    //     (5, 'В контакте', 'https://vk.com/chitakodar', 'vk'),
    //     (6, 'Instagram', 'https://instagram.com/kodar_chita_official', 'instagram');";
    //     $result = $this->db->query($sql);
    // }

    public function checkLoginAndPassword($login, $password){
        $sql = 'SELECT * FROM admin WHERE login = :login AND password = :password';
        $params = [
            'login' => $login,
            'password' => $password
        ];
        
        $res = $this->db->row($sql, $params);
        if ($res)
            return $res['admin_id'];
        else
            return false;
    }

    public function saveImg(&$imgFileArray, $articleId, $destination){
        $ext = [];
        preg_match('{image/(.*)}is', $imgFileArray['type'], $ext);
        $imgPath = 'public/userimg/'.$destination.'/'.$articleId.'.'.$ext[1];
        copy($imgFileArray['tmp_name'], $imgPath);
        return $imgPath;
    }

    public function delImg($path){
        return unlink($path);
    }

    public function delImgPathFromDb($table, $id){
        $sql = '';
        $parms = [];
        switch ($table){
            case 'article': 
                $sql = "UPDATE $table SET img_path = :img_path WHERE (article_id = :article_id)";
                $params = [
                    'img_path'=>'',
                    'article_id'=>$id
                ];
                break;
            case 'worker':
                $sql = "UPDATE $table SET photo_path = :photo_path WHERE (worker_id = :worker_id)";
                $params = [
                    'photo_path'=>'',
                    'worker_id'=>$id
                ];
                break;
        }
        
        return $this->db->query($sql, $params);
    }

    public function maxFileName($destination){
        $fileNames = array_diff(scandir($destination), [".", ".."]);
        foreach ($fileNames as &$value) {
            $value= intval($value);
        }
        if (count($fileNames)==0)
            return 0;
        else
            return max($fileNames);
    }

    public function moveImg($tmpName, $newName, $type, $destination){
        $ext = [];
        preg_match('{image/(.*)}is', $type, $ext);
        $imgPath = 'public/userimg/'.$destination.'/'.$newName.'.'.$ext[1];
        copy($tmpName, $imgPath);
        return $imgPath;
    }

    public function saveArticle($header, $type, $date, $text, $imgPath=''){
        $params = [
            'header' => $header,
            'date' => $date,
            'text' => $text,
            'section_type' =>$type,
            'img_path'=> $imgPath
        ];
        // debug($params);
        $sql = "INSERT INTO article (header, date, text, section_type, img_path) 
                                            VALUES (:header, :date, :text, :section_type, :img_path)";
        $result = $this->db->query($sql, $params);
        return $result;       
    }

    public function getLastArticleId(){
        $sql = "SELECT max(article_id) FROM article";
        $result = $this->db->getSingleValue($sql);
        if ($result)
            return $result;
        else 
            return false;
    }

    public function deleteArticle($id){
        $article = $this->getArticleById($id);
        $imgPath = $article['img_path'];
        if ($imgPath!=''){
            $this->delImg($imgPath);
        }
        $sql = 'DELETE FROM article WHERE article_id=:article_id';
        $params = [
            'article_id' => $id
        ];
        $result = $this->db->query($sql, $params);
        if ($result){
            if ($this->db->isEmpty('article'))
                $this->db->resetAI('article');
            exit("Success");   
        }   
        else 
            exit("Error");
        
    }

    public function updateArticle($id, $header, $text, $imgPath=''){
        $sql = 'UPDATE article 
                SET header = :header, text = :text, img_path = :img_path WHERE (article_id = :article_id)';
        $params = [
            'article_id' => $id,
            'header' =>$header,
            'text' => $text,
            'img_path'=>$imgPath
        ];
        $result = $this->db->query($sql, $params);
        if ($result)
            return true;
        else 
            return false;
    }



    public function getSectionById($id, $editable=FALSE){
        $sql = 'SELECT * FROM about_us_section WHERE about_us_section_id=:about_us_section_id';
        $params = [
            'about_us_section_id' => $id
        ];
        $result = $this->db->row($sql, $params);
        if ($result){
            if (!$editable)
                $result['about_us_section_contents'] = nl2br($result['about_us_section_contents']);
             return $result;
        }
            
        else 
            return false;

    }

    public function updateAboutUsSection($id, $text){
        $sql = 'UPDATE about_us_section 
                SET about_us_section_contents = :about_us_section_contents WHERE (about_us_section_id = :about_us_section_id)';
        $params = [
            'about_us_section_id' =>$id,
            'about_us_section_contents' => $text,
        ];
        $result = $this->db->query($sql, $params);
        if ($result)
            return true;
        else 
            return false;
    }



    public function saveWorker($name, $postion, $vk, $details, $photoPath=''){
        $params = [
            'name' => $name,
            'position' => $postion,
            'vk_link'=>$vk,
            'details' =>$details,
            'photo_path'=> $photoPath
        ];
        $sql = "INSERT INTO worker (name, position, vk_link, details, photo_path) 
                                            VALUES (:name, :position, :vk_link, :details, :photo_path)";
        $result = $this->db->query($sql, $params);
        if ($result)
            return true;
        else 
            return false;
    }

    public function getLastWorkerId(){
        $sql = "SELECT count(worker_id) FROM worker";
        $result = $this->db->getSingleValue($sql);
        if ($result)
            return $result;
        else 
            return false;
    }


    public function updateWorker($id, $name, $position, $vk, $details, $photoPath=''){
        $sql = 'UPDATE worker 
                SET name = :name, position = :position, vk_link= :vk_link, details=:details, photo_path = :photo_path WHERE (worker_id = :worker_id)';
        $params = [
            'worker_id' => $id,
            'name' =>$name,
            'position' => $position,
            'vk_link' => $vk,
            'details'=>$details,
            'photo_path'=>$photoPath
        ];
        $result = $this->db->query($sql, $params);
        if ($result)
            return true;
        else 
            return false;
    }


    public function deleteWorker($id){
        $worker = $this->getWorkerById($id);
        // debug($worker);
        $photoPath = $worker['photo_path'];
        if ($photoPath!=''){
            $this->delImg($photoPath);
        }
        $sql = 'DELETE FROM worker WHERE worker_id=:worker_id';
        $params = [
            'worker_id' => $id
        ];
        $result = $this->db->query($sql, $params);
        if ($result){
            if ($this->db->isEmpty('worker'))
                $this->db->resetAI('worker');
            exit("Success");
        }            
        else 
            exit("Error");
        
    }

    public function savePrice($sections, $services){
        $sql = 'TRUNCATE TABLE price';
        if ($this->db->query($sql)){
            if (isset($sections) && isset($services)){
                $sql = 'INSERT INTO price (service, leaders, price, category) 
                    VALUES (:service, :leaders, :price, :category)';
                // Формируем массив параметров
                for ($i=0; $i<count($services['name']); $i++){
                    $params = [
                        'service'=> $services['name'][$i],
                        'leaders'=> $services['leaders'][$i],
                        'price'=>$services['price'][$i],
                        'category'=>$sections[$services['sectionNumber'][$i]]
                    ];
                    // debug($params);
                    if (!$this->db->query($sql, $params))
                        return false;
                }
            }
            
        }
        else{
            return false;
        }
        return true;
    }



    public function saveGraphics($sections, $groups){
        $sql = 'TRUNCATE TABLE graphic';
        if ($this->db->query($sql)){
            if (isset($sections) && isset($groups)){
                $sql = 'INSERT INTO graphic (group_name, dates, time, leaders) 
                    VALUES (:group_name, :dates, :time, :leaders)';
                // Формируем массив параметров
                // debug($groups);
                for ($i=0; $i<count($groups['dates']); $i++){
                    $params = [
                        'group_name'=>$sections[$groups['sectionNumber'][$i]],
                        'dates'=> $groups['dates'][$i],
                        'time'=> $groups['time'][$i],
                        'leaders'=>$groups['leaders'][$i]
                    ];
                    if (!$this->db->query($sql, $params))
                        return false;
                }
            }
            
        }
        else{
            return false;
        }
        return true;
    }



    public function updateContacts($contacts){
        $sql = "UPDATE contact SET value = :value WHERE (contact_id = :contact_id)";
        for ($i = 0; $i<count($contacts['id']); $i++){
            $params = [
                'contact_id' => $contacts['id'][$i],
                'value' => $contacts['value'][$i]
            ];
            if (!$this->db->query($sql, $params))
                return false;
        }
        return true;
    }

    public function getRequests(){
        $sql = 'SELECT * FROM request ORDER BY status ASC, date DESC';
        $requests = $this->db->rows($sql);
        if ($requests)
            return $requests;
        else
            return false;
    }

    public function setRequestProccesed($id){
        $sql = 'UPDATE request SET status = 1 WHERE (request_id = :request_id);';
        $params = [
            'request_id' => $id
        ];
        if ($this->db->query($sql, $params))
            return true;
        else    
            return false;
    }

}