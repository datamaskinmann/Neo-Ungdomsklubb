<?php

    include '../html/htmlService.php';
    include '../database/advancedQueries.php';
    include '../database/database.php';

    session_start();

    if(!doFilter() || !$_SESSION["isAdmin"]) {
        http_response_code(403);
        return;
    }

    if(in_array("street", $_POST["editedFields"]) || in_array("postalCode", $_POST["editedFields"]) ||
        in_array("city", $_POST["editedFields"])) {
        unset($_POST["editedFields"]["street"]);
        unset($_POST["editedFields"]["postalCode"]);
        unset($_POST["editedFields"]["city"]);
        update("adress", "WHERE id='" . $_POST["userData"]["adressId"] . "'",
            ["street" => $_POST["userData"]["street"],
                "postalCode" => $_POST["userData"]["postalCode"],
                "city" => $_POST["userData"]["city"]], "sis");
    }

    if(in_array("interests", $_POST["editedFields"])) {

        $currentInterests = explode(',', getInterests($_POST["userData"]["id"])->fetch_row()[0]);

        $intersect = array_intersect($currentInterests, explode(',', $_POST["userData"]["interests"]));

        $removed = array_diff($currentInterests, $intersect);

        foreach($removed as $e) {
            $id = select("id", "interest", "WHERE tag=?", ["tag" => $e], "s")->fetch_row()[0];
            delete("memberInterest", "WHERE interestId=? AND memberId=?",
            ["interestId" => $id, "memberId" => $_POST["userData"]["id"]], "ii");

            if(!hasInterestMembers($id)) {
                delete("interest", "WHERE id=?", ["id" => $id], "i");
            }
        }

        unset($_POST["editedFields"]["interests"]);
        foreach(explode(',', $_POST["userData"]["interests"]) as $interest) {
            $res = select("*", "interest", "WHERE tag=?", ["tag" => $interest], "s")->fetch_all(MYSQLI_ASSOC)[0];

            if($res != null) {
                $res2 = select("*", "memberInterest", "WHERE memberId=? AND interestId=?",
                ["memberId" => $_POST["userData"]["id"], "interestId" => $res["id"]], "ii")->fetch_all(MYSQLI_ASSOC)[0];

                if($res2 == null) {
                    insert("memberInterest", "ii",
                        ["memberId" => $_POST["userData"]["id"], "interestId" => $res["id"]]);
                }
            } else {
                $i = insert("interest", "s", ["tag" => $interest]);
                insert("memberInterest", "ii", ["memberId" => $_POST["userData"]["id"],
                    "interestId" => $i["insertId"]]);
            }
        }
    }
