<?php
    require_once("templates/header.php");
    require_once("dao/UserDao.php");
    require_once("models/User.php");

    $user = new User();

    $userDao = new UserDao($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);
?>
    <div id="main-container" class="container-fluid">
        <div class="offset-md-4 col-md-4 new-movie-countainer">
            <h1 class="page-title">Adicione Filmes</h1>
            <p class="page-description">Adicione filmes que você gostaria de assistir em seu próprio Netflip da Mattec.</p>
            <form action="<?= $BASE_URL ?>movie_process.php" method="POST" id="add-movie-form" enctype="multipart/form-data">
                <input type="hidden" name="type" value="create_filme">
                <div class="form-group">
                    <label for="title">Título:</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Digite o título do filme">
                </div>
                <div class="form-group">
                    <label for="director">Diretor:</label>
                    <input type="text" class="form-control" name="director" id="director" placeholder="Digite o nome do diretor">
                </div>
                <div class="form-group">
                    <label for="release_date">Data de lançamento:</label>
                    <input type="date" class="form-control" name="release_date" id="release_date">
                </div>
                <div class="form-group">
                    <label for="image">Imagem:</label>
                    <input type="file" class="form-control-file" name="image" id="image">
                </div>
                
                <div class="form-group">
                    <label for="length">Duração:</label>
                    <input type="text" class="form-control" name="length" id="length" placeholder="Digite a duração do filme">
                </div>
                <div class="form-group">
                    <label for="category">Categoria:</label>
                    <select class="form-control" name="category" id="category">
                        <option value="">Selecione</option>
                        <option value="Ação">Ação</option>
                        <option value="Drama">Drama</option>
                        <option value="Comédia">Comédia</option>
                        <option value="Fantasia">Fantasia</option>
                        <option value="Ficção">Ficção</option>
                        <option value="Romance">Romance</option>
                        <option value="Infantil">Infantil</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="trailer">Trailer:</label>
                    <input type="text" class="form-control" name="trailer" id="trailer" placeholder="Insira o link do trailer">
                </div>
                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <textarea class="form-control" name="description" id="description" rows="5" placeholder="Insira a descrição do filme"></textarea>
                </div>
                <input type="submit" class="btn card-btn" value="Adicionar filme">
            </form>

        </div>
    </div>

<?php
    require_once("templates/footer.php");
?>
