<?php 

    require_once("globals.php");
    require_once("database.php");
    require_once("models/Movie.php");
    require_once("models/Message.php");
    require_once("dao/UserDao.php");
    require_once("dao/MovieDao.php");

    $message = new Message($BASE_URL);

    $userDao = new UserDao($conn,$BASE_URL);

    $movieDao = new MovieDao($conn, $BASE_URL);

    $type = filter_input(INPUT_POST,"type");

    $userData = $userDao->verifyToken();

    if ($type === "create_filme") {

        $title = filter_input(INPUT_POST,"title");
        $description = filter_input(INPUT_POST,"description");
        $image = filter_input(INPUT_POST,"image");
        $trailer = filter_input(INPUT_POST,"trailer");
        $category = filter_input(INPUT_POST,"category");
        $users_id = filter_input(INPUT_POST,"users_id");
        $director = filter_input(INPUT_POST,"director");
        $release_date = filter_input(INPUT_POST,"release_date");
        $length = filter_input(INPUT_POST,"length");

        

        $movie = new Movie();

        if(!empty($title) && !empty($description) && !empty($trailer ) && !empty($category) && !empty($director) && !empty($release_date) && !empty($length)){

            $movie->title =$title;
            $movie->description =$description;
            $movie->image =$image;
            $movie->trailer =$trailer;
            $movie->category =$category;
            $movie->users_id =$userData->id;
            $movie->director =$director;
            $movie->release_date =$release_date;
            $movie->length =$length;

            if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
                $image = $_FILES["image"];
                $imageTypes =["image/jpg","image/png","image/jpeg"];
                $jpgArray = ["image/jpg","image/jpeg"];

                if(in_array($image["type"], $imageTypes)){

                    if(in_array($image["type"], $jpgArray)){
                        $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                    }else{
                        $imageFile = imagecreatefrompng($image["tmp_name"]);
                    }
                $imageName = $movie->imageGenerateName();

                // print_r("image é --> $imageName");exit;

                imagejpeg($imageFile, "./img/movies/" .$imageName, 100);

                $movie->image = $imageName;

                }else{
                    $message->setMessage("Tipo de imagem inválido", "error", "back");
                }
            }

        // print_r($_POST); print_r($_FILES);exit;
            $movieDao->create($movie);

        }else{
            $message->setMessage("É necessários adicionar todos os dados! ", "error", "back");

        }

    }else if($type === "delete"){
        $id =filter_input(INPUT_POST, "id",);
        $movie = $movieDao->findById($id);

        if($movie){

            if($movie->users_id === $userData->id){
                $movieDao->destroy($movie->id);

            }else{
                $message->setMessage("Informações inválidas", "error", "index.php");
            }

        }else{
            $message->setMessage("Informações inválidas", "error", "index.php");
        }


    }else if($type === "update_filme"){

        $title = filter_input(INPUT_POST,"title");
        $description = filter_input(INPUT_POST,"description");
        $image = filter_input(INPUT_POST,"image");
        $trailer = filter_input(INPUT_POST,"trailer");
        $category = filter_input(INPUT_POST,"category");
        $users_id = filter_input(INPUT_POST,"users_id");
        $director = filter_input(INPUT_POST,"director");
        $release_date = filter_input(INPUT_POST,"release_date");
        $length = filter_input(INPUT_POST,"length");
        $id = filter_input(INPUT_POST,"id");

        $movieData= $movieDao->findById($id);

        // echo "title --> $title <br>";
        // echo "description -->  $description <br>";
        // echo "trailer -->  $trailer <br>";
        // echo "image -->  $image <br>";exit;
        // echo "category -->  $category <br>";
        // echo "director -->  $director <br>";
        // echo "release_date -->  $release_date <br>";
        // echo "length -->  $length <br>";
        // echo "id -->  $id <br>";exit;

        // echo "users_id,  validação!!! $movieData->users_id <br>";
        // echo "userData,  validação!!! $userData->id";exit;

        if($image === "" || $image == null && $movieData->image){
            $image = $movieData->image;
            // echo "tem imagem no banco, manter a imagem!!";exit;
        }

        if($movieData->users_id === $userData->id) {
            //  echo "é filme do usuário,  validação!!!";exit;

            if(!empty($title) &&
            !empty($description) &&
            !empty($trailer ) &&
            !empty($category) &&
            !empty($director) &&
            !empty($release_date) &&
            !empty($length) &&
            !empty($id)
            ){
               //  echo "passou na validação!!!";exit;
   
               $movieData->title =$title;
               $movieData->description =$description;
               $movieData->trailer =$trailer;
               $movieData->image =$image;
               $movieData->category =$category;
               $movieData->users_id =$userData->id;
               $movieData->director =$director;
               $movieData->release_date =$release_date;
               $movieData->length =$length;
   
               if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
                
                   $image = $_FILES["image"];
                   $imageTypes =["image/jpg","image/png","image/jpeg"];
                   $jpgArray = ["image/jpg","image/jpeg"];

                //    echo"chegou aqui agora";exit;
   
                   if(in_array($image["type"], $imageTypes)){
   
                       if(in_array($image["type"], $jpgArray)){
                           $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                       }else{
                           $imageFile = imagecreatefrompng($image["tmp_name"]);
                       }
                            //    print_r("image é --> $movie");exit;
                        $movie = new Movie();
                        $imageName = $movie->imageGenerateName();
        
                        // print_r("image é --> $imageName");exit;
        
                        imagejpeg($imageFile, "./img/movies/" .$imageName, 100);
        
                        $movieData->image = $imageName;
   
                   }else{
                       $message->setMessage("Tipo de imagem inválido", "error", "back");
                   }
                //    echo"agora chegou aqui agora";exit;
               }
            //    echo"estamos nos preparando para a gravação <br>";exit;
   
        //    print_r($_POST); print_r($_FILES);exit;
                // print_r($movieData);exit;
               $movieDao->update($movieData);
   
           }else{
               $message->setMessage("É necessários adicionar todos os dados! ", "error", "back");
   
           }
   
   
        //    print_r("Estou aqui *** <br>");
        //    print_r($movieData->id);exit;
        //    $message->setMessage("Informações inválidas", "error", "index.php");


        }else{
            print_r("Não permitido, não é filme do usuário atual! *** <br>");
            $message->setMessage("Não permitido, não é filme do usuário atual!", "error", "back");
        }

       
    }else{
        $message->setMessage("Informações inválidas", "error", "index.php");
    }
