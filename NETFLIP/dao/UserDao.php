<?php 
    require_once("models/User.php");

    class UserDao implements UserDaoInterface{

        private $conn;
        private $url;

        public function __construct(PDO $conn, $url){
            $this->conn =$conn;
            $this->url = $url;           
           
        }


        public function buildUser($data){
            $user = new User();
            $user->id = $data['id'];
            $user->name = $data['name'];
            $user->lastname = $data['lastname'];
            $user->email = $data['email'];
            $user->password = $data['password'];
            $user->image = $data['image'];
            $user->biografia = $data['biografia'];
            $user->token = $data['token'];
            return $user;


        }
        public function createUser(User $user, $authUser = false){}
        public function updateUser(User $user){}
        public function verifyToken($protected = false){}
        public function setTokenToSession($token, $redirect = true){}
        public function authenticationUser($email, $password){}
        public function findUserByEmail($email){
            if($email != ''){
                $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                if($stmt->rowCount() >0){
                    $data = $stmt->fetch();
                    return $this->buildUser($data);
                }else{
                    return false;
                }
            }else{

            }

        }
        public function findUserById($id){}
        public function findbytoken($token){}
        public function changePassword($password){}

        public function deleteUser(User $user){}

    }