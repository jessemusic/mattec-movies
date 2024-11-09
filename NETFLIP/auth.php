<?php
    require_once("templates/header.php")
?>
    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <div class="row" id="auth-row">
                <div class="col-md-4" id="login-container">
                    <h2>Entrar</h2>
                    <form action="auth.php" method="POST">
                    <input type="hidden" name ="type"value="login">
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input class="form-control" name="email" id="email"  placeholder="Digite o email">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input class="form-control" name="password" id="password"  placeholder="Digite a senha">
                        </div>
                        <input type="submit" class="btn car-btn" value="Entrar">

                    </form>
                </div>
                <div class="col-md-4" id="register-container">
                    <h2>Criar Conta</h2>
                    <form action="" method="POST">
                        <input type="hidden" name ="type"value="register">
                    </form>
                </div>


            </div>
        </div>
    </div>

<?php
    require_once("templates/footer.php")
?>
