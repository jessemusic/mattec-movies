<?php
    require_once("templates/header.php");
    require_once("dao/UserDao.php");
    require_once("models/User.php");

    $user = new User();

    $userDao = new UserDao($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);

    $fullName = $user->getFullName($userData);

    if($userData->image == ""){
        $userData->image = "user.png";
    }
?>
    <div id="main-container" class="container-fluid edit-profile-page">
        <div class="col-md-12">
            <form action="<?= $BASE_URL ?>user_process.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="type" value="update">
                <div class="row">
                    <div class="col-md-4">
                        <h1><?= $fullName ?></h1>
                        <p class="page-description">Alteração de dados de usúario:</p>
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Digite o seu nome" value="<?= $userData->name?>">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Sobrenome:</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Digite o seu sobrenome" value="<?= $userData->lastname?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" readonly class="form-control disabled" name="email" id="email" placeholder="Digite o seu email" value="<?= $userData->email?>">
                        </div>
                        <input type="submit" class="btn card-btn" value="Alterar">
                    </div>
                    <div class="col-md-4">
                        <div id="profile-image-container" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
                        <div class="form-group">
                            <label for="image">Foto:</label>
                            <input type="file" class="form-control-file" name="image">
                        </div>
                        <div class="form-group">
                            <label for="biografia">Sobre você:</label>
                            <textarea rows="5" class="form-control" name="biografia" id="biografia" placeholder="Dê uma descrição de você, trabalho, ect..!" ><?= $userData->biografia?></textarea>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row" id="change-password-container">
                <div class="col-md-4">
                    <h2>Alterar a senha</h2>
                    <p class="page-description">Digite a nova senha, redigite-a logo abaixo e clique no botão para alterar!</p>
                    <form action="<?= $BASE_URL?>user_process.php" method="POST">
                        <input type="hidden" name="type" value="change_password">
                        <!-- <div class="form-group">
                            <label for="password">Senha atual:</label>
                            <input type="password" class="form-control" name="password_atual" id="password_atual" placeholder="Digite a senha atual">
                        </div> -->
                        <div class="form-group">
                            <label for="new_password">Nova senha:</label>
                            <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Digite a nova senha">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirmar senha:</label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Digite a confirmação de senha"></div>
                            <input type="submit" class="btn card-btn" value="Alterar Senha">
                    </form>

                </div>
            </div>
        </div>
    </div>

<?php
    require_once("templates/footer.php")
?>
