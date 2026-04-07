<?php

require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = "blockaid_super_secure_secret_key_2026_for_jwt_authentication";

if(!isset($_COOKIE['token'])){
    header("Location: login.php");
    exit();
}

$token = $_COOKIE['token'];

try{

$decoded = JWT::decode($token,new Key($secret_key,'HS256'));

$user_id = $decoded->data->user_id;
$account_type = $decoded->data->account_type;
$email = $decoded->data->email;



}catch(Exception $e){

header("Location: login.php");
exit();

}