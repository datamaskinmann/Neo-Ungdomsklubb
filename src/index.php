<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>PHP Test</title>
    <link rel="stylesheet" href="./stylesheets/body.css"/>
    <link rel="stylesheet" href="./stylesheets/center.css"/>
    <link rel="stylesheet" href="./stylesheets/h.css"/>
    <link rel="stylesheet" href="./stylesheets/box.css"/>
    <link rel="stylesheet" href="./stylesheets/input.css"/>
    <link rel="stylesheet" href="./stylesheets/popin.css"/>
    <link rel="stylesheet" href="./stylesheets/a.css"/>
    <link rel="stylesheet" href="stylesheets/header.css"/>
</head>
<body>
<?php
    include './service/html/htmlService.php';
    getHeader();
?>
<div class="center">
    <h1 style="color: #f6c453">Neo Ungdomsklubb</h1>
    <div class="box popIn">
        <form method="POST" action="./service/user/loginService.php" style="display: block">
                <input name="email" type="email" placeholder="Epost-addresse..."/>
                <input name="password" type="password" placeholder="Passord..."/>
                <input type="submit" value="Logg inn"/>
        </form>
        <h3><a href="page/register.php">Registrer deg</a></h3>
    </div>
</div>
</body>
</html>