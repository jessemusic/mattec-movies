<?php

    $database ="netflip";
    $host = "localhost";
    $username = "root";
    $password = "";
    $table_users = "users";
    $table_movies = "movies";

    // Create connection
    $conn = new PDO("mysql:dbname=" . $database . ";host=" . $host, $username, $password);

    // Check error code
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
 