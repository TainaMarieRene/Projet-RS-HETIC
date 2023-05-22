<?php

function db()
{
    $host = "localhost";
    $user = "root";
    $password = "";
    $db_name = "unilink";

    $dsn = "mysql:host=$host;dbname=$db_name";

    return new PDO($dsn, "$user", "$password", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
}

function getUserInfo($user_id) {

    $pdo = db();

    $requete = $pdo->prepare("SELECT
    profile_picture, profile_banner, profile_bio, profile_location, profile_activity, profile_certification, profile_status
    FROM profiles
    WHERE user_id = :user_id;
    ");

    $requete->execute([
        ":user_id"=>$user_id
    ]);

    $result = $requete->fetchAll(PDO::FETCH_ASSOC);

    return $result;

}