<?php


class Connexion
{

    public static function GetConnexion(){
        try{

            $pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
            $connexion  = new PDO('mysql:host=localhost;dbname=db_centralisation;charset=utf8mb4','root','',$pdo_options);
            return $connexion;

        }
        catch(Exception $e) {
            die('ERREUR : '. $e->getMessage());
        }

    }
}