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

    }

    interface UserDaoInterface {

        public function buildUser($data);
        public function createUser(User $user, $authUser = false);
        public function updateUser(User $user);
        public function verifyToken($protected = false);
        public function setTokenToSession($token, $redirect = true);
        public function authenticationUser($email, $password);
        public function findUserByEmail($email);
        public function findUserById($id);
        public function findbytoken($token);
        public function changePassword($password);


        public function deleteUser(User $user);
    }