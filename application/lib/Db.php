<?php

namespace application\lib;

use PDO;

class Db{

    protected $db;

    public function __construct(){
        $config = require "application/config/db.php";
        $this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['dbname'], $config['user'], $config['password']);
    }

    public function query($sql, $params=[]){
        $stmt = $this->db->prepare($sql);
        if (!empty($params) && preg_match('#^(INSERT|UPDATE)#', $sql, $matches)){
            
            foreach($params as $key=>&$value){
                $value = preg_replace('#И#', '\$\$', $value);
                unset($value);
            }
            // debug($params);
        }
        if (!empty($params)){
            // debug($params);
            foreach($params as $key => $value){
                $stmt->bindValue(':'.$key, $value);
            }
        }
        $result = $stmt->execute();
        if ($result)
            return $stmt;
        else 
            return false;
    }

    public function rows($sql, $params=[]){
        $result = $this->query($sql, $params);
        if ($result){
            $rows = $result->fetchAll(PDO::FETCH_ASSOC);
            foreach($rows as &$row){
                foreach($row as $key=>&$value){
                    $value = preg_replace('#\$\$#', 'И', $value);
                    unset($value);
                }
                unset($row);
            }
            // debug($tmp);
            return $rows;
        }
            
        else 
            return false;
        
    }

    public function row($sql, $params=[]){
        $result = $this->query($sql, $params);
        if ($result){
            $rows = $result->fetchAll(PDO::FETCH_ASSOC);
            if (isset($rows[0])){
                $row = $rows[0];
                foreach($row as $key=>&$value){
                    $value = preg_replace('#\$\$#', 'И', $value);
                    unset($value);
                }
                return $row;
            }
                
        }

        return false;
    }

    // public function column($sql, $params=[]){
    //     $result = $this->query($sql, $params);
    //     if ($result)
    //         return $result->fetchColumn(PDO::FETCH_ASSOC);
    //     else 
    //         return false;
        
    // }

    public function getSingleValue($sql, $params=[]){
        $result = $this->row($sql, $params);
        // debug($result);
        if ($result)
            return array_shift($result);
        else 
            return false;
        
    }

    public function isEmpty($table){
        $sql = 'SELECT count(*) FROM '.$table;
        $rows = $this->row($sql);
        if ($rows==0)
            return true;
        else
            return false;
    }

    public function resetAI($table){
        $sql = 'ALTER TABLE '.$table.' AUTO_INCREMENT=0';
        $result = $this->query($sql);
        if ($result)
            return true;
        else
            return false;
    }


}