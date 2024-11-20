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

    }else{
        $message->setMessage("Informações inválidas", "error", "index.php");
    }