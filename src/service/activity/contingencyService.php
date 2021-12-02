<?php

    if (!doFilter()) {
        http_response_code(403);
        return;
    }

    include $_SERVER["DOCUMENT_ROOT"] . '/service/database/database.php';

    function getAllPaid() {
        return select("*", "contingencyStatus", "WHERE ", null, null);
    }
