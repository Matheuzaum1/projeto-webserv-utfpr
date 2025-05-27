<?php
require_once __DIR__ . '/../config/config.php';

class Conexao{
    private static $instance;

    public static function get(){
        try{
            if(!isset(self::$instance)){
                self::$instance = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE.';charset=utf8', DB_USERNAME, DB_PASSWORD);
            }
        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }

        return self::$instance;
    }
}