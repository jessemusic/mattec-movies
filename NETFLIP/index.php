<?php
    require_once("templates/header.php");
    require_once("dao/MovieDao.php");
    $movieDao = new MovieDao($conn,$BASE_URL);

    $lastestMovies = $movieDao->getLatestMovies();
    // print_r($lastestMovie);exit;
    $ActionMovies =  $movieDao->findMoviesByCategory("Ação");
    $comedyMovies = $movieDao->findMoviesByCategory("Comédia");
    $suspenseMovies = $movieDao->findMoviesByCategory("Suspense");
    $dramaMovies = $movieDao->findMoviesByCategory("Drama");
    $fantasiaMovies = $movieDao->findMoviesByCategory("Fantasia");
    $infantilMovies = $movieDao->findMoviesByCategory("Infantil");


?>
    <div id="main-container" class="container-fluid">
        <h2 class="section-title">Novos filmes</h2>
        <P class="section-descriptions">Observem críticas adicionadas no MATTEC movies</P>
        <div class="movies-container">
            <?php foreach ($lastestMovies as $movie):?>
               <?php require("templates/movie_card.php"); ?>
            <?php endforeach;?>
            <?php if(count($lastestMovies) === 0):?>
            <p class="empty-list-films">Nenhum filme de adicionado ainda.</p>
            <?php endif;?>
        </div>

        <h2 class="section-title">Ação</h2>
        <P class="section-descriptions">Os melhores filmes de ação de todos os tempos</P>
        <div class="movies-container">
        <?php foreach ($ActionMovies as $movie):?>
            <?php require("templates/movie_card.php"); ?>
        <?php endforeach;?>
        <?php if(count($ActionMovies) === 0):?>
            <p class="empty-list-films">Nenhum filme de ação adicionado ainda.</p>
        <?php endif;?>
        </div>

        <h2 class="section-title">Comédia</h2>
        <P class="section-descriptions">As melhores comédias</P>
        <div class="movies-container">
        <?php foreach ($comedyMovies as $movie):?>
               <?php require("templates/movie_card.php"); ?>
        <?php endforeach;?>
        <?php if(count($comedyMovies) === 0):?>
            <p class="empty-list-films">Nenhum filme de comédia adicionado ainda.</p>
        <?php endif;?>
        </div>

        <h2 class="section-title">Suspense</h2>
        <P class="section-descriptions">Filmes de suspense inesquecíveis </P>
        <div class="movies-container">
        <?php foreach ($suspenseMovies as $movie):?>
            <?php require("templates/movie_card.php"); ?>
        <?php endforeach;?>
        <?php if(count($suspenseMovies) === 0):?>
            <p class="empty-list-films">Nenhum filme de suspense adicionado ainda.</p>
            <?php endif;?>
        </div>

        <h2 class="section-title">Drama</h2>
        <P class="section-descriptions">Filmes de drama inesquecíveis </P>
        <div class="movies-container">
        <?php foreach ($dramaMovies as $movie):?>
            <?php require("templates/movie_card.php"); ?>
        <?php endforeach;?>
        <?php if(count($dramaMovies) === 0):?>
            <p class="empty-list-films">Nenhum filme de drama adicionado ainda.</p>
            <?php endif;?>
        </div>

        <h2 class="section-title">Fantasia</h2>
        <P class="section-descriptions">Filmes de Fantasia inesquecíveis </P>
        <div class="movies-container">
        <?php foreach ($fantasiaMovies as $movie):?>
            <?php require("templates/movie_card.php"); ?>
        <?php endforeach;?>
        <?php if(count($fantasiaMovies) === 0):?>
            <p class="empty-list-films">Nenhum filme de Fantasia adicionado ainda.</p>
            <?php endif;?>
        </div>

        <h2 class="section-title">Infantil</h2>
        <P class="section-descriptions">Filmes de Infantil inesquecíveis </P>
        <div class="movies-container">
        <?php foreach ($infantilMovies as $movie):?>
            <?php require("templates/movie_card.php"); ?>
        <?php endforeach;?>
        <?php if(count($infantilMovies) === 0):?>
            <p class="empty-list-films">Nenhum filme de Infantil adicionado ainda.</p>
            <?php endif;?>
        </div>
    </div>

<?php
    require_once("templates/footer.php")
?>
