<?php 
    require_once("models/User.php");
    require_once("models/Message.php");

    class UserDao implements UserDaoInterface{

        private $conn;
        private $url;

        private $message;

        public function __construct(PDO $conn, $url){
            $this->conn =$conn;
            $this->url = $url;  
            $this->message = new Message($url);
           
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
        public function createUser(User $user, $authUser = false){
            $stmt = $this->conn->prepare("INSERT INTO users(
            name,lastname,email,password,token) VALUES(
            :name,:lastname,:email,:password,:token)");

            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":lastname", $user->lastname);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":token", $user->token);

            $stmt->execute();

            if($authUser){
                $this->setTokenToSession($user->token);

                // $this->updateUser($user);
  
              }
  




        }
        public function updateUser(User $user, $redirect = true){


                $stmt = $this->conn->prepare("UPDATE users SET
                    name = :name,
                    lastname = :lastname,
                    email = :email,
                    image = :image,
                    biografia = :biografia,
                    token = :token
                    WHERE id = :id
                ");
                $stmt->bindParam(':name', $user->name);
                $stmt->bindParam(':lastname', $user->lastname);
                $stmt->bindParam(':email', $user->email);
                $stmt->bindParam(':image', $user->image);
                $stmt->bindParam(':biografia', $user->biografia);
                $stmt->bindParam(':token', $user->token);
                $stmt->bindParam(':id', $user->id);
                $stmt->execute();

                if($redirect){
                    $this->message->setMessage("Dados atualizados com sucesso!","success","editprofile.php");
               
                }
            

        }
        public function verifyToken($protected = false){
            if(!empty($_SESSION['token'])){
                $token = $_SESSION['token'];
                $userFound = $this->findbytoken($token);

                if($userFound){
                    // echo "vamos retornar o usuário";
                    // exit();
                    return $userFound;

                }else if($protected){
                   

                    $this->message->setMessage("É necessário fazer a atenticação do usuário para acessar o sistema!","error","index.php");
                }


            }else if($protected){
               

                $this->message->setMessage("É necessário fazer a atenticação do usuário para acessar o sistema!","error","index.php");
            }

        }
        public function setTokenToSession($token, $redirect = true){

            $_SESSION["token"] = $token;

            if($redirect){
               $this->message->setMessage("Seja bem vindo, usuário logado com sucesso!","success","editprofile.php");
            }

        }
        public function authenticationUser($email, $password){
            
            $user = $this->findUserByEmail($email);
            if($user){

                if(password_verify($password,$user->password)){
                    $token = $user->generateToken();

                    $this->setTokenToSession($token,false);
            
                    $user->token = $token;

                    $this->updateUser($user,false);
                    return true;
               
                }else{
                   
                    return false;

                }
        }else{

            return false;

        }

        }
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
        public function findbytoken($token){
            if($token != ''){
                $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = :token");
                $stmt->bindParam(':token', $token);
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
        public function changePassword(User $user){
            $stmt = $this->conn->prepare("UPDATE users SET 
            password = :password 
            WHERE id = :id");

            $stmt->bindParam(":password",$user->password);
            $stmt->bindParam(":id",$user->id);
            $stmt->execute();

            $this->message->setMessage("Senha atualizada com sucesso","success","editprofile.php");

        }

        public function destroyToken(){
            $_SESSION["token"] = "";

            $this->message->setMessage("você fez o lougout da session","success","index.php");
        }

    }