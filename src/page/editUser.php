<?php
// Page for editing a user
include "../service/html/htmlService.php";
session_start();
if (!doFilter() || !$_SESSION["isAdmin"]) { // If the user is not logged in or is not an admin
    http_response_code(403);
    return;
}

?>

<html>
<style>
    h3 {
        color: #f6c453;
    }

    li {
        transition: opacity 0.25s;
        opacity: 1;
        margin: 1em;
    }

    li:hover {
        transition: opacity 0.25s;
        opacity: 0.75;
    }

    input:hover {
        cursor: pointer;
    }

    textarea {
        width: 100%;
        height: 100%;
        background-color: #e1eedd;
        border: none;
    }

    hr {
        background-color: #e1eedd;
        height: 2px;
        border-width: 0;
        color: #e1eedd;
        border-color: #e1eedd;
    }

    ul {
        width: 100%;
        list-style: none;
        padding: 0;
        margin-right: 1em;
    }

    input[type=submit] {
        background-color: #183a1d;
        color: white;
        width: 40%;
        float: right;
        margin: 1em auto;
        padding: 0.5em;
        transition: opacity 0.25s;
        opacity: 1;
        border-radius: 1em;
    }

    input[type=submit]:hover {
        transition: 0.25s;
        opacity: 0.75;
        cursor: pointer;
    }

    input[type=text] {
        background-color: #e1eedd;
        margin-bottom: 0.5em;
        width: 100%;
    }

    #editContainer {
        visibility: hidden;
    }

    input:disabled {
        transition: opacity 0.25s;
        opacity: 0.5;
    }

    input {
        background-color: red;
        transition: 0.25s;
        opacity: 1;
    }
</style>
<head>
    <link rel="stylesheet" href="../stylesheets/body.css">
    <link rel="stylesheet" href="../stylesheets/box.css">
    <link rel="stylesheet" href="../stylesheets/input.css">
    <link rel="stylesheet" href="../stylesheets/header.css">
    <link rel="stylesheet" href="../stylesheets/activitiesTable.css">
    <link rel="stylesheet" href="../stylesheets/center.css">
    <link rel="stylesheet" href="../stylesheets/button.css">
    <link rel="stylesheet" href="../stylesheets/icons.css"/>
    <link rel="stylesheet" href="../stylesheets/h.css">
    <link rel="stylesheet" href="../stylesheets/a.css">
    <link rel="stylesheet" href="../stylesheets/overlay.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../service/html/HTTP.js"></script>
    <script src="../service/user/getUserData.js"></script>
    <script src="../service/user/editUserData.js"></script>
</head>
<body>
<?php
include "../service/activity/activityService.php";

getHeader();
?>
<div style="width: 100%; display: flex; justify-content: center">
    <h2>Rediger en bruker</h2>
</div>
<div style="max-height: 85%; overflow-y: auto; display: flex; flex-direction: row; justify-content: center">
    <div style="width: 25%; overflow-y: auto">
        <?php
        include '../service/database/advancedQueries.php';
        include '../service/database/filtering.php';

        // Query that gets all activities with participants
        $activityParticipants = getAllActivityParticipants()->fetch_all(MYSQLI_ASSOC);
        // Query that gets all interests with members associated
        $interests = getAllInterests()->fetch_all(MYSQLI_ASSOC);
        // Query that gets all the newest contingency states for all users
        $contingencyState = getAllContingencyState()->fetch_all(MYSQLI_ASSOC);
        // Query that gets all past members
        $pastMembers = getAllPastMembers()->fetch_all(MYSQLI_ASSOC);

        echo "<div id='emailListContainer'>";
        echo "<h2>Aktiviteter</h2>";
        // Finds all unique tags and iterates over them
        foreach (filterResultByAttributeUnique($activityParticipants, "tag") as $tag) {
            echo "<h3>" . $tag . "</h3>";
            echo "<ul>";
            // Finds all users who participate in an activity with a specific tag ($tag)
            foreach (filterResultByAttributeValue($activityParticipants, "tag", $tag) as $member) {
                echo "<li>";
                echo "<div>";
                echo $member["firstname"] . " " . $member["lastname"] . " (" . $member["email"] . ")";
                echo "<input email='" . $member["email"] . "' type='checkbox' style='float: right;'/>";
                echo "</div>";
                echo "</li>";
            }
            echo "</ul>";
        }
        echo "<h2>Interesser</h2>";
        // Finds all unique interests and iterates over them
        foreach (filterResultByAttributeUnique($interests, "tag") as $interest) {
            echo "<h3>" . mb_strtoupper($interest[0]) . substr($interest, 1) . "</h3>";
            echo "<ul>";
            // Finds all users with a specific interest ($interest)
            foreach (filterResultByAttributeValue($interests, "tag", $interest) as $member) {
                echo "<li>";
                echo "<div>";
                echo $member["firstname"] . " " . $member["lastname"] . " (" . $member["email"] . ")";
                echo "<input email='" . $member["email"] . "' type='checkbox' style='float: right;'/>";
                echo "</div>";
                echo "</li>";
            }
            echo "</ul>";
        }
        echo "<h2>Kontingentstatus</h2>";
        // Gets all unique contingency statuses (paid&unpaid)
        foreach (filterResultByAttributeUnique($contingencyState, "status") as $status) {
            echo "<h3>" . $status . "</h3>";
            echo "<ul>";
            // Iterates members who have status paid/unpaid
            foreach (filterResultByAttributeValue($contingencyState, "status", $status) as $member) {
                echo "<li>";
                echo "<div>";
                echo $member["firstname"] . " " . $member["lastname"] . " (" . $member["email"] . ")";
                echo "<input email='" . $member["email"] . "' type='checkbox' style='float: right;'/>";
                echo "</div>";
                echo "</li>";
            }
            echo "</ul>";
        }
        echo "<h2>Tidligere medlemmer</h2>";
        // Iterates past members
        foreach ($pastMembers as $member) {
            echo "<li>";
            echo "<div>";
            echo $member["firstname"] . " " . $member["lastname"] . " (" . $member["email"] . ")";
            echo "<input email='" . $member["email"] . "' type='checkbox' style='float: right;/>";
            echo "</div>";
            echo "</li>";
        }
        echo "</div>";
        ?>
    </div>
    <div class="box" style="width: 25%; background-color: #e1eedd">
        <div id="editContainer" style="width: 50%; margin: auto">
            <h3 id="username"></h3>
            <input class="userEditor" type="text" name="firstname" placeholder="Fornavn..." required/>
            <input class="userEditor" type="text" name="lastname" placeholder="Etternavn..." required/>
            <input class="userEditor" type="tel" name="phonenumber" placeholder="Telefonnummer..." required/>
            <input class="userEditor" type="email" name="email" placeholder="Epost-addresse..." required/>
            <input class="userEditor" type="password" name="password" placeholder="Passord..." required/>
            <select class="userEditor" id="gender" name="gender" required>
                <option disabled selected>Kjønn...</option>
                <option value="male">Mann</option>
                <option value="female">Kvinne</option>
            </select>
            <input class="userEditor" type="text" name="street" placeholder="Adresse..." required/>
            <input class="userEditor" type="number" min="0" max="9999" name="postalCode" placeholder="Postkode..." required/>
            <input class="userEditor" type="text" name="city" placeholder="Poststed..." required/>
            <input class="userEditor" type="text" name="interests" placeholder="Interesser... (Separer med komma)" required/>
            <input class="userEditor" type="submit" name="submit" value="Send inn"/>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    // When clicking on a checkbox
    $("input[type='checkbox']").on('change', (e) => {
        let email = e.target.attributes["email"].value;
        // Make all checkboxes with the same email checked (in case the member is in multiple categories)
        $("input[email='" + email + "']").prop("checked", e.target.checked);
        // Make all checkboxes which do not have that email disabled
        $("input[type='checkbox'][email!='" + email + "']").prop("disabled", e.target.checked);
        let user;
        let editedFields = [];
        // Gets the user's data in JSON format
        getUserData(email, (e) => {
            user = JSON.parse(e);
            editedFields = [];
            $("#username").html(user.email);
            // Iterate over field names in user object which are the same as our input names
            for(const key in user) {
                // Special case for gender
                if(key === "gender") {
                    $("#gender option[value='" + user[key] + "']").attr("selected", "selected");
                    continue;
                }
                // Set the respective input's value
                $("input[name='" + key + "']").val(user[key]);
            }
        });
        // Display the edit area if a member is selected
        $("#editContainer").css("visibility", e.target.checked ? "visible" : "hidden");
        $(".userEditor").on('change', (e) => {
            // Keep track of changed fields + track the edits in the user object
            user[e.target.name] = e.target.value;
            editedFields.push(e.target.name);
        });
        $("input[type='submit']").on('click', () => {
            editUserData(user, editedFields, (e) => {
                alert("Brukeren ble oppdatert");
                window.location.reload();
            });
        });
    });
</script>
</html>
