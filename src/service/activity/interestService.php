<?php

    if (!doFilter()) {
        http_response_code(403);
        return;
    }

    include $_SERVER["DOCUMENT_ROOT"] . '/service/database/database.php';

    function getAllInterests() {
        return select("id, tag", "interest", "ORDER BY tag DESC", null, null);
    }
