<?php
    class Movie {
        public $id;
        public $title;
        public $description;
        public $image;
        public $trailer;
        public $category;
        public $length;
        public $users_id;
        public $director;
        public $release_date;

        public function imageGenerateName(){
            return bin2hex(random_bytes(60)) . ".jpg";
        }

    }

    interface MovieDaoInterface {
        public function buildMovie($data);
        public function findAll();
        public function getLatestMovies();
        public function findById($id);
        public function findMoviesByCategory($category);
        public function findMoviesByUserId($id);
        public function findByTitle($title);
        public function create(Movie $movie);
        public function update(Movie $movie);
        public function destroy($id);
    }
?>