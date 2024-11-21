<?php
    require_once("templates/header.php");
    require_once("dao/MovieDao.php");
    $movieDao = new MovieDao($conn,$BASE_URL);

    $lastestMovie = $movieDao->getLatestMovies();
    // print_r($lastestMovie);exit;
    $ActionMovies = [];
    $comedyMovies = [];


?>
    <div id="main-container" class="container-fluid">
        <h2 class="section-title">Novos filmes</h2>
        <P class="section-descriptions">Observem críticas adicionadas no MATTEC movies</P>
        <div class="movies-container">
            <?php foreach ($lastestMovie as $movie):?>
               <?php require("templates/movie_card.php"); ?>
            <?php endforeach;?>

        </div>

        <h2 class="section-title">Ação</h2>
        <P class="section-descriptions">Os melhores filmes de ação de todos os tempos</P>
        <div class="movies-container"></div>

        <h2 class="section-title">Comédia</h2>
        <P class="section-descriptions">As melhores comédias</P>
        <div class="movies-container"></div>

        <h2 class="section-title">Suspense</h2>
        <P class="section-descriptions">Filmes de suspense inesquecíveis </P>
        <div class="movies-container"></div>
    </div>

<?php
    require_once("templates/footer.php")
?>
