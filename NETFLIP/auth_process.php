<?php 
   require_once("models/User.php");
   require_once("models/Message.php");
   require_once("dao/UserDao.php");
   require_once("globals.php");
   require_once("database.php");


   // verificando se o usuario está logado
   $message = new Message($BASE_URL);
   $userDao = new UserDao($conn,$BASE_URL);

   // formulario
   $type = filter_input(INPUT_POST,"type");

  
   if($type === "register"){

    $name = filter_input(INPUT_POST,"name");
    $lastname = filter_input(INPUT_POST,"lastname");
    $email = filter_input(INPUT_POST,"email");
    $password = filter_input(INPUT_POST,"password");
    $confirmpassword = filter_input(INPUT_POST,"confirmpassword");

    if($name && $lastname && $email && $password){

      if($password === $confirmpassword){

        if($userDao->findUserByEmail($email) === false){

            echo "nenhum email encontrado no sistema";
            exit();

        }else{
            echo "entro email não cadastrado";
            exit();
            $message->setMessage("Email já cadastrado no sistema", "error", "back");
        }
       

      }else{
        $message->setMessage("As senhas não estão compativeis", "error", "back");
      }
    } else {
        
        $message->setMessage("Por favor, preencha todos os campos.", "error", "back");
       
    }

   } else if($type === "login"){

   }

   




