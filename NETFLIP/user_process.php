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

        $user = new User();

        if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])){
            
            $image = $_FILES["image"];
            $imageTypes =["image/jpg","image/png","image/jpeg"];
            $jpgArray = ["image/jpg","image/jpeg"];

            if(in_array($image["type"],$imageTypes)){

                if(in_array($image["type"],$jpgArray)){
                    // echo "entrou no if" ;exit;
                    
                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                }else{
                    print_r($jpgArray);
                    echo "entrou no else" ;exit;
                    $imageFile = imagecreatefrompng($image["tmp_name"]);
 
                }

                $imageName = $user->imageGenerateName();

                imagejpeg($imageFile, "./img/users/" . $imageName,100);

                $userData->image = $imageName;

            }else{
                $message->setMessage("Tipo invalido de imagem, escolha jpeg/jpg/png ", "error", "back");
            }
        }

        $userDao->updateUser( $userData);

    }else if ($type == "change_password") {

    }else{
        $message->setMessage("Por favor, preencha todos os campos.", "error", "index.php");
    }
     
