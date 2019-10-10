<?php
session_start();
if(isset($_SESSION['user']) && $_SESSION['user'] == "admin") {
    header('Location: admin.php');
}

require_once('config.php');
try {
    $sql = new PDO($dbdsn, $dbuser, $dbpass, array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
    die("Can't connect to database. Check your config.php.");
}
$message = "";

// Si se envio el formulario
if(isset($_POST['pass'])) {
    global $sql;
    $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);

    
    $query = $sql->prepare('SELECT value FROM rotator_config WHERE name = "passw"');
    $query->execute();
    $hash = $query->fetch(PDO::FETCH_OBJ)->value;
    $pass = crypt($pass, $hash);
    

    if($pass != $hash) {
        $message = "Incorrect password";
    } else {
        // Redirect to admin
        $_SESSION['user'] = "admin";
        header('Location: admin.php');
    }
}

$view = <<<TEMPLATE
<!DOCTYPE html>
<html>
<head>
    <link href="public/css/rotator.css" type="text/css" rel="stylesheet" />
    <link href="public/css/skyform.css" type="text/css" rel="stylesheet" />
    <link href="public/assets/font-awesome/css/font-awesome.css" type="text/css" rel="stylesheet" />
    <style>
        body{background-color: #124F54}
    </style>
</head>

<body>
    <div class="login_form">
      <form method="POST" class="sky-form" action="login.php">
        <header>Login</header>
        <fieldset>
            <section>
                <label class="input">
                    <i class="icon-append icon-lock"></i>
                    <input type="password" id="password" placeholder="Password" name="pass" required="required" />
                    <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                </label>
            </section>
        </fieldset>
        <fieldset>
            <section>
                <label class="text">
                    <span class="error">
                        $message
                    </span>
                </label>
            </section>
        </fieldset>
        <footer>
            <input type="hidden" name="_csrf_token" value="" />
            <input type="submit" class="button" id="_submit" name="_submit" value="Login" />
        </footer>
    </form>
</div>
</body>
</html>

TEMPLATE;
echo $view;