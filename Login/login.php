<?php

    require_once "../vendor/autoload.php";
    require_once "../core/init.php";

    use classes\{DB, Config, Validation, Common, Session, Token, Hash, Redirect};
    use models\User;

    // First we check if the user is already connected we redirect him to index page
    if($user->getPropertyValue("isLoggedIn")) {
        Redirect::to("../index.php");
    }
    $validate = new Validation();

    $reg_success_message = '';
    $login_failure_message = '';

    if(isset($_POST["login"])) {
        if(Token::check(Common::getInput($_POST, "token_log"), "login")) {
            $validate->check($_POST, array(
                "email-or-username"=>array(
                    "name"=>"Email or username",
                    "required"=>true,
                    "max"=>255,
                    "min"=>6,
                    "email-or-username"=>true
                ),
                "password"=>array(
                    "name"=>"Password",
                    "required"=>true,
                    // Later
                    "strength"=>true
                )
            ));
    
            if($validate->passed()) {
                // Remember $user is created in init file
                $remember = isset($_POST["remember"]) ? true: false;
                $log = $user->login(Common::getInput($_POST, "email-or-username"), Common::getInput($_POST, "password"), $remember);
                
                if($log) {
                    Redirect::to("../index.php");
                } else {
                    // Here define a variable with value and display it in error div in case credentials are wrong
                    $login_failure_message = "Either email or password is invalid !";
                }
            } else {
                // Here instead of printing out errors we can put them in an array and use them in proper html labels
                $login_failure_message = $validate->errors()[0];
            }
        } else {
            $validate->addError('Invalide csrf token');
        }
    }

    if(isset($_POST["register"])) {
        $validate = new Validation();
        if(Token::check(Common::getInput($_POST, "token_reg"), "register")) {
            $validate->check($_POST, array(
                "firstname"=>array(
                    "name"=>"Firstname",
                    "min"=>2,
                    "max"=>50
                ),
                "lastname"=>array(
                    "name"=>"Lastname",
                    "min"=>2,
                    "max"=>50
                ),
                "username"=>array(
                    "name"=>"Username",
                    "required"=>true,
                    "min"=>6,
                    "max"=>20,
                    "unique"=>true
                ),
                "email"=>array(
                    "name"=>"Email",
                    "required"=>true,
                    "email-or-username"=>true
                ),
                "password"=>array(
                    "name"=>"Password",
                    "required"=>true,
                    "min"=>6
                ),
                "password_again"=>array(
                    "name"=>"Repeated password",
                    "required"=>true,
                    "matches"=>"password"
                ),
            ));
    
            if($validate->passed()) {
                $salt = Hash::salt(16);
    
                $user = new User();
                $user->setData(array(
                    "firstname"=>Common::getInput($_POST, "firstname"),
                    "lastname"=>Common::getInput($_POST, "lastname"),
                    "username"=>Common::getInput($_POST, "username"),
                    "email"=>Common::getInput($_POST, "email"),
                    "password"=> Hash::make(Common::getInput($_POST, "password"), $salt),
                    "salt"=>$salt,
                    "joined"=> date("Y/m/d h:i:s"),
                    "user_type"=>1,
                    "cover"=>'',
                    "picture"=>'',
                    "private"=>-1
                ));
                $user->add();
                
                mkdir("../data/users/" . Common::getInput($_POST, "username")."/");
                mkdir("../data/users/" . Common::getInput($_POST, "username")."/posts/");
                mkdir("../data/users/" . Common::getInput($_POST, "username")."/media/");
                mkdir("../data/users/" . Common::getInput($_POST, "username")."/media/pictures/");
                mkdir("../data/users/" . Common::getInput($_POST, "username")."/media/covers/");

                $reg_success_message = "Your account has been created successfully.";
                /* The following flash will be shown in the index page if the user is new, and we'll also check if the user registered 
                is the same person log in because the user could create a new account but login with other account, in that case we won't
                show any welcome message*/
                
                Session::flash("register_success", "Welcome to TNTS Study Hub!");
                Session::flash("new_username", Common::getInput($_POST, "username"));
            } else {
                $login_failure_message = $validate->errors()[0];
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TNTS Study Hub</title>
    <link rel='shortcut icon' type='image/x-icon' href='../public/assets/images/favicons/tnts_logo.png' />
    <link rel="stylesheet" href="../public/css/global.css">
    <link rel="stylesheet" href="../public/css/login.css">
    <link rel="stylesheet" href="../public/css/log-header.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <?php include "../page_parts/basic/log-header.php" ?>
    
</body>
</html>