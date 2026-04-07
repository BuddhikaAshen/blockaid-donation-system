<?php

require 'db.php';
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = "blockaid_super_secure_secret_key_2026_for_jwt_authentication";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $sql = "SELECT id,email,password_hash,account_type FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$email);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows == 1){

        $user = $result->fetch_assoc();

        if(password_verify($password,$user['password_hash'])){

            $payload = [

                "iss"=>"blockaid",
                "iat"=>time(),
                "exp"=>time()+3600,

                "data"=>[
                    "user_id"=>$user['id'],
                    "email"=>$user['email'],
                    "account_type"=>$user['account_type']
                ]
            ];

            $jwt = JWT::encode($payload,$secret_key,'HS256');

            echo json_encode([
                "status"=>"success",
                "token"=>$jwt
            ]);
            setcookie("token",$jwt,time()+3600,"/");

        }else{

            echo json_encode([
                "status"=>"error",
                "message"=>"Incorrect password"
            ]);
            

        }

    }else{

        echo json_encode([
            "status"=>"error",
            "message"=>"User not found"
        ]);

    }

}
?>