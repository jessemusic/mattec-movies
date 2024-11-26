<?php
    require_once("models/Movie.php");
    require_once("models/Message.php");

    class MovieDao implements MovieDaoInterface{

        private $conn;
        private $url;
        private $message;
        public function __construct(PDO $conn, $url){
            $this->conn = $conn;
            $this->url =$url;
            $this->message = new Message($url);
    }

    public function buildMovie($data){

        $movie = new Movie();
        $movie->id = $data['id'];
        $movie->title = $data['title'];
        $movie->description = $data['description'];
        $movie->image = $data['image'];
        $movie->trailer = $data['trailer'];
        $movie->category = $data['category'];
        $movie->length = $data['length'];
        $movie->users_id = $data['users_id'];
        $movie->director = $data['director'];
        $movie->release_date = $data['release_date'];
        return $movie;
    }
    public function findAll(){}

    public function getLatestMovies(){
        $movies = [];

        $stmt = $this->conn->query("SELECT * FROM movies ORDER BY id DESC");
        $stmt->execute();
        if($stmt->rowCount() >0){

            $moviesArray = $stmt->fetchAll();

            foreach($moviesArray as $movie){
                $movies[] = $this ->buildMovie($movie);
            }

        }
        return $movies;


    }
    public function findById($id){

        $movie = [];
        $stmt = $this->conn->prepare("SELECT * FROM movies WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if($stmt->rowCount() >0){
            $movieData = $stmt->fetch();
            $movie = $this->buildMovie($movieData);
            // print_r($movie);exit;
            return $movie;
        }else{
            return false;
        }
    }
    public function findMoviesByCategory($category){
        $moviesCategory = [];

        // print_r($category);exit;

        $stmt = $this->conn->prepare("SELECT * FROM movies WHERE category = :category ORDER BY id DESC");
        $stmt->bindParam(":category", $category);
        $stmt->execute();
        if($stmt->rowCount() >0){

            $moviesArray = $stmt->fetchAll();

            foreach($moviesArray as $movie){
                $moviesCategory[] = $this ->buildMovie($movie);
            }

        }
        return $moviesCategory;

    }
    public function findMoviesByUserId($id){

        $moviesId = [];

        // print_r($category);exit;

        $stmt = $this->conn->prepare("SELECT * FROM movies WHERE users_id = :users_id");
        $stmt->bindParam(":users_id", $id);
        $stmt->execute();
        if($stmt->rowCount() >0){

            $moviesArray = $stmt->fetchAll();

            foreach($moviesArray as $movie){
                $moviesId[] = $this ->buildMovie($movie);
            }

        }
        return $moviesId;

    }
    public function findByTitle($title){}

    public function create(Movie $movie){
        $stmt =$this->conn->prepare("INSERT INTO movies (
            title, description,image,trailer,category,length,users_id, director, release_date

        ) VALUES(
        :title, :description, :image, :trailer, :category, :length, :users_id, :director, :release_date

        )");
        $stmt->bindParam(":title",$movie->title);
        $stmt->bindParam(":description",$movie->description);
        $stmt->bindParam(":image",$movie->image);
        $stmt->bindParam(":trailer",$movie->trailer);
        $stmt->bindParam(":category",$movie->category);
        $stmt->bindParam(":length",$movie->length);
        $stmt->bindParam(":users_id",$movie->users_id);
        $stmt->bindParam(":director",$movie->director);
        $stmt->bindParam(":release_date",$movie->release_date);

        $stmt->execute();

        $this->message->setMessage("Filme cadastrado com sucesso!","success","index.php");
       
    }

    public function update(Movie $movie){}
    public function destroy($id){}
    }