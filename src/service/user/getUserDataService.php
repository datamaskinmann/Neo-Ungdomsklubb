<?php
    include '../html/htmlService.php';
    include '../database/database.php';
    include '../database/advancedQueries.php';

    session_start();

    if(!doFilter() || !$_SESSION["isAdmin"]) {
        http_response_code(403);
        return;
    }

    print json_encode(getMemberData($_POST["email"])->fetch_all(MYSQLI_ASSOC)[0]);

