<?php

    class User {

        public $id;
        public $name;
        public $lastname;
        public $email;
        public $password;
        public $image;
        public $biografia;
        public $token;

        public function getFullName($user){
            return $user->name . " " . $user->lastname;
        }

        public function generateToken(){
            return bin2hex(random_bytes(50));
        }

        public function gegeratePassword($password){
            return password_hash($password, PASSWORD_DEFAULT);
        }

        public function imageGenerateName(){
            return bin2hex(random_bytes(60)) . ".jpg";

        }

    }

    interface UserDaoInterface {

        public function buildUser($data);
        public function createUser(User $user, $authUser = false);
        public function updateUser(User $user, $redirect = true);
        public function verifyToken($protected = false);
        public function setTokenToSession($token, $redirect = true);
        public function authenticationUser($email, $password);
        public function findUserByEmail($email);
        public function findUserById($id);
        public function findbytoken($token);
        public function changePassword(User $user);


        public function destroyToken();
    }