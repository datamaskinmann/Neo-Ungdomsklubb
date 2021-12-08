<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Registrer deg</title>
    <link rel="stylesheet" href="../stylesheets/body.css"/>
    <link rel="stylesheet" href="../stylesheets/center.css"/>
    <link rel="stylesheet" href="../stylesheets/h.css"/>
    <link rel="stylesheet" href="../stylesheets/box.css"/>
    <link rel="stylesheet" href="../stylesheets/input.css"/>
    <link rel="stylesheet" href="../stylesheets/popin.css"/>
    <link rel="stylesheet" href="../stylesheets/a.css"/>
    <link rel="stylesheet" href="../stylesheets/header.css"/>
    <link rel="stylesheet" href="../stylesheets/overlay.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<body>
<div class="center" style="top: 30%">
    <h1 style="color: #f6c453">Registrer deg</h1>
    <div class="box popIn">
        <form style="display: block" action="../service/user/registrationService.php" method="post">
            <input type="text" name="firstname" placeholder="Fornavn..." required/>
            <input type="text" name="lastname" placeholder="Etternavn..." required/>
            <input type="tel" name="phonenumber" placeholder="Telefonnummer..." required/>
            <input type="email" name="email" placeholder="Epost-addresse..." required/>
            <input type="password" name="password" placeholder="Passord..." required/>
            <select name="gender" required>
                <option disabled selected>Kjønn...</option>
                <option value="male">Mann</option>
                <option value="female">Kvinne</option>
            </select>
            <input type="text" name="street" placeholder="Adresse..." required/>
            <input type="number" min="0" max="9999" name="postalCode" placeholder="Postkode..." required/>
            <input type="text" name="city" placeholder="Poststed..." required/>
            <input type="text" name="interests" placeholder="Interesser... (Separer med komma)" required/>
            <input type="submit" name="submit" value="Send inn"/>
        </form>
    </div>
</div>
</body>
</html>