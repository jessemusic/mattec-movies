<?php
    require_once("templates/header.php");

    require_once("dao/MovieDao.php");
    require_once("dao/UserDao.php");
    require_once("models/User.php");

    $user = new User();

    $userDao = new UserDao($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);

    $movieDao =  new MovieDao($conn, $BASE_URL);

    $id = filter_input(INPUT_GET,"id");

    if($id === null || $id ===""){
        // echo "chegou não nenhum um id--> $id";exit;
        $message->setMessage("O filme não foi encontrado! ", "error", "index.php");
    }else{
        // echo "chegou um id---else-> $id";exit;
        $movie = $movieDao->findById($id);

        if(!$movie){
            // echo "chegou um id---filme não exite-> $id";exit;
            $message->setMessage("O filme não foi encontrado! ", "error", "index.php");
        }
        
    }

    $trailerUrl = getYouTubeEmbedUrl($movie->trailer);
 
    function getYouTubeEmbedUrl($url) {
        if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        return null; 
    }

    if($userData->image == ""){
        $userData->image = "movie_cover.jpg";
    }
    
?>

<div id="main-container" class="container-fluid">

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 offset-md-1">
                <h1><?= $movie->title ?></h1>
                <p class="page-description">Altere os dados do filme:</p>
                <form id="edit-movie-form" action="<?= $BASE_URL ?>movie_process.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="type" value="update_filme">
                <input type="hidden" name="id" value="<?= $movie->id ?>">
        <div class="form-group">
            <label for="title">Título:</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Digite o título do filme" value="<?= $movie->title ?>">
        </div>
        <div class="form-group">
            <label for="director">Diretor:</label>
            <input type="text" class="form-control" name="director" id="director" placeholder="Digite o nome do diretor" value="<?= $movie->director ?>">
        </div>
        <div class="form-group">
            <label for="release_date">Data de lançamento:</label>
            <input type="date" class="form-control" name="release_date" id="release_date" value="<?= $movie->release_date ?>">
        </div>
        <div class="form-group">
            <label for="image">Imagem:</label>
            <input type="file" class="form-control-file" name="image" id="image" value="<?= $movie->image ?>">
        </div>
        
        <div class="form-group">
            <label for="length">Duração:</label>
            <input type="text" class="form-control" name="length" id="length" placeholder="Digite a duração do filme" value="<?= $movie->length ?>">
        </div>
        <div class="form-group">
            <label for="category">Categoria:</label>
            <select class="form-control" name="category" id="category" >
                <option value="">Selecione</option>
                <option value="Ação" <?= $movie->category === "Ação" ? "selected" : "" ?>>Ação</option>
                <option value="Drama" <?= $movie->category === "Drama" ? "selected" : "" ?>>Drama</option>
                <option value="Comédia" <?= $movie->category === "Comédia" ? "selected" : "" ?>>Comédia</option>
                <option value="Fantasia" <?= $movie->category === "Fantasia" ? "selected" : "" ?>>Fantasia</option>
                <option value="Ficção" <?= $movie->category === "Ficção" ? "selected" : "" ?>>Ficção</option>
                <option value="Romance" <?= $movie->category === "Romance" ? "selected" : "" ?>>Romance</option>
                <option value="Infantil" <?= $movie->category === "Infantil" ? "selected" : "" ?>>Infantil</option>
                <option value="Suspense" <?= $movie->category === "Suspense" ? "selected" : "" ?>>Suspense</option>
                <option value="Terror" <?= $movie->category === "Terror" ? "selected" : "" ?>>Terror</option>
                <option value="Aventura" <?= $movie->category === "Aventura" ? "selected" : "" ?>>Aventura</option>
                <option value="Ficção Científica" <?= $movie->category === "Ficção Científica" ? "selected" : "" ?>>Ficção Científica</option>
            </select>
        </div>
        <div class="form-group">
            <label for="trailer">Trailer:</label>
            <input type="text" class="form-control" name="trailer" id="trailer" placeholder="Insira o link do trailer" value="<?= $movie->trailer ?>">
        </div>
        <div class="form-group">
            <label for="description">Descrição:</label>
            <textarea class="form-control" name="description" id="description" rows="5" placeholder="Insira a descrição do filme" ><?= $movie->description ?></textarea>
        </div>
        <input type="submit" class="btn card-btn" value="Atualizar filme">

                </form>
            </div>
            <div class="col-md-3">
                <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>/img/movies/<?= $movie->image ?>')"></div>
            
                <?php if ($trailerUrl): ?>
                <iframe src="<?= htmlspecialchars($trailerUrl, ENT_QUOTES) ?>" width="460" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <?php else: ?>
                    <p>Trailer não disponível.</p>
                <?php endif; ?>
                <p><?= $movie->description ?></p>
            </div>
                </div>
            </div>
</div>

<?php
    require_once("templates/footer.php");
?>
