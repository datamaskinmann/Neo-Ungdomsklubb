<?php

    include '../service/html/htmlService.php';
    session_start();
    if (!doFilter()) {
        http_response_code(403);
        return;
    }

    if(empty($_GET["id"])) {
        http_response_code(400);
        return;
    }

