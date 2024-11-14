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

           
            $user = new User();
            $userToken = $user->generateToken();
            $finalPassword = $user->gegeratePassword($password);

            $user->name = $name;
            $user->lastname = $lastname;
            $user->email = $email;
            $user->password = $finalPassword;
            $user->token = $userToken;

            $auth = true;
            $userDao->createUser($user,$auth);

           
        }else{
            
            $message->setMessage("Email já cadastrado no sistema", "error", "back");  
        }
       

      }else{
        $message->setMessage("As senhas não estão compativeis", "error", "back");
      }
    } else {
        
        $message->setMessage("Por favor, preencha todos os campos.", "error", "back");
       
    }

   } else if($type === "login"){

    $email = filter_input(INPUT_POST,"email");
    $password = filter_input(INPUT_POST,"password");

      if($userDao->authenticationUser($email, $password)){
          $message->setMessage("Seja bem vindo", "success", "editprofile.php");
        }else{
          // echo "Error aqui neste lugar"; exit;
          $message->setMessage("Usuário ou senha incorretos.", "error", "back");
        }
    }else{
      $message->setMessage("Por favor, preencha todos os campos.", "error", "index.php");
    }
   
  
  
   

   




