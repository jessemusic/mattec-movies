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
    </div>
</div>


<?php
    require_once("templates/footer.php");
?>