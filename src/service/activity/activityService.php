<?php

    if(!doFilter()) {
        http_response_code(403);
        return;
    }

    include  $_SERVER["DOCUMENT_ROOT"] . '/service/database/database.php';

    function getAllActivities() {
        return select("id, tag, date", "activity", "ORDER BY date ASC", null, null);
    }
