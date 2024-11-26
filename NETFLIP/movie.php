<?php
    require_once("templates/header.php");
    require_once("dao/MovieDao.php");
    require_once("models/Movie.php");

    $id = filter_input(INPUT_GET,"id");

    $movie;

    $movieDao = new MovieDao($conn, $BASE_URL);

    if($id === null || $id ===""){
        $message->setMessage("O filme não foi encontrado! ", "error", "index.php");
    }else{
        $movie = $movieDao->findById($id);

        if(!$movie){
            $message->setMessage("O filme não foi encontrado! ", "error", "index.php");
        }
    }

    if($userData->image == ""){
        $userData->image = "movie_cover.jpg";
    }

    // verifique se o filme é do próprio usuário

    $userQwnersMovie = false;

    if(!empty($userData)){

        if($userData->id === $movie->users_id){
            $userQwnersMovie = true;
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

?>

<div id="main-container" class="container-fluid">
    <div class="row">
        <div class="offset-md-1 col-md-6 movie-container">
            <h1 class="page-title"><?= $movie->title ?></h1>
            <p class="movie-details">
                <span>Duração: <?= $movie->length ?></span>
                <span class="pipe"></span>
                <span><?= $movie->category ?></span>
                <span class="pipe"></span>
                <span><i class="fas fa-star"></i>3</span>
            </p>
            <?php if ($trailerUrl): ?>
            <iframe src="<?= htmlspecialchars($trailerUrl, ENT_QUOTES) ?>" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <?php else: ?>
                <p>Trailer não disponível.</p>
            <?php endif; ?>
            <p><?= $movie->description ?></p>


        </div>
        <div class="col-md-4">
            <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>/img/movies/<?= $movie->image ?>')"></div>                
        </div>
        <div class="offset-md-1 col-md-10" id="reviews-container">
            <h3 id="revies-title">Avaliações: </h3>

            <div class="col-md-12" id="review-form-container">
                <h4>Envie sua avaliação:</h4>
                <p class="page-description">Preencha sua avaliação do filme:</p>
                <form action="<?= $BASE_URL ?>review_process.php" method="POST" id="review-form">
                    <input type="hidden" name="type" value="create_avaliacao">
                    <input type="hidden" name=",movies_id" value="<?= $movie->id ?>">
                    <div class="form-group">
                        <label for="rating">Nota do filme</label>
                        <select name="rating" clratingss="form-control" id="rating">
                            <option value="">Selecione</option>
                            <option value="10">10</option>
                            <option value="9">9</option>
                            <option value="8">8</option>
                            <option value="7">7</option>
                            <option value="6">6</option>
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                            <option value="0">0</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="review">Seu comentário:</label>
                        <textarea name="review" class="form-control" rows="3" id="review" placeholder="O que você achou do filme"></textarea>
                    </div>
                    <input type="submit" class="btn card-btn" value="Enviar comentário" >

                </form>
            </div>
            <!-- review lógica -->
            <div class="col md-12 review">
                <div class="row">
                    <div class="col-md-1">
                        <div class="profile-image-container review-image" style="background-image: url('<?= $BASE_URL ?>img/users/user.png')"></div>
                    </div>
                    <div class="col-md-9 author-details-container">
                        <h4 class="author-name">
                            <a href="#">Jesse testando</a>
                        </h4>
                        <p><i class="fas fa-star"></i>9</p>
                    </div>
                    <div class="col-md-12">
                        <p class="coment-title">Comentários:</p>
                        <p>Este é o comentário do usuário:</p>
                    </div>
                </div>
            </div>
            <div class="col md-12 review">
                <div class="row">
                    <div class="col-md-1">
                        <div class="profile-image-container review-image" style="background-image: url('<?= $BASE_URL ?>img/users/user.png')"></div>
                    </div>
                    <div class="col-md-9 author-details-container">
                        <h4 class="author-name">
                            <a href="#">Jesse testando</a>
                        </h4>
                        <p><i class="fas fa-star"></i>9</p>
                    </div>
                    <div class="col-md-12">
                        <p class="coment-title">Comentários:</p>
                        <p>Este é o comentário do usuário:</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<?php
    require_once("templates/footer.php");
?>