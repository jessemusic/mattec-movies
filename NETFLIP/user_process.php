<?php
    require_once("models/User.php");
    require_once("models/Message.php");
    require_once("dao/UserDao.php");
    require_once("globals.php");
    require_once("database.php");

    $message = new Message($BASE_URL);
    $userDao = new UserDao($conn,$BASE_URL);
   

    $type = filter_input(INPUT_POST,"type");

    if ($type == "update") {

        $userData = $userDao->verifyToken();

        $name = filter_input(INPUT_POST,"name");
        $lastname = filter_input(INPUT_POST,"lastname");
        $email = filter_input(INPUT_POST,"email");
        $biografia = filter_input(INPUT_POST,"biografia");

        $userData->name =$name;
        $userData->lastname =$lastname;
        $userData->email =$email;
        $userData->biografia =$biografia;

        $userDao->updateUser( $userData);




        // print_r($userData);exit;




    }else if ($type == "change_password") {

    }else{
        $message->setMessage("Por favor, preencha todos os campos.", "error", "index.php");
    }
     
