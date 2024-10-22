assertion2<br>
<?php
$page = $_POST['page'];
$login = $_POST['user'];
$name = $_POST['name'];
$lastname = $_POST['lastname'];
$fathername = $_POST['fathername'];
$number = $_POST['number'];
$mail = $_POST['mail'];
$password = $_POST['password'];
$passwordd = $_POST['password_d'];
$completionErr = '';
if ($page == 'registration.html') {
    $variable = [$login, $name, $lastname, $fathername, $number, $mail, $password, $passwordd];
    $variablePatterns = [
        '/^[a-zA-Z0-9а-яА-Я]{3,50}[^!@#$%\^&*()_+=-?:;№\|\/\\>]$/mu',
        '/^[а-яa-zA-ZёЁ]{2,50}[^0-9!@#$%\^&*()_+=-?:;№\|\/\\><{}\'\"\`~&]$/miu',
        '/^[а-яa-zA-ZёЁ]{2,50}[^0-9!@#$%\^&*()_+=-?:;№\|\/\\><{}\'\"\`~&]$/miu',
        '/^[а-яa-zA-ZёЁ]{2,50}[^0-9!@#$%\^&*()_+=-?:;№\|\/\\><{}\'\"\`~&]$/miu',
        '/^[ ]{0,1}[+]{0,1}[ ]{0,1}[0-9]{0,1}[ ]{0,1}[(]{0,1}[ ]{0,1}[0-9]{0,3}[ ]{0,1}[)]{0,1}[ ]{0,1}[0-9]{3}[ ]{0,1}[-]{0,1}[ ]{0,1}[0-9]{2}[ ]{0,1}[-]{0,1}[ ]{0,1}[0-9]{2}[^!@#$%^&*_=a-z<{}\'\"\`~&][ ]{0,1}$/m',
        '/^[a-zA-Z0-9.]{3,50}[^!#$%\^&*()_+=-?:;№\|\/,\\<{>}\'\"\`~&>][@]{1}[a-zA-Z0-9]{3,20}[.]{1}[a-zA-Z0-9.]{2,10}$/m',
        '/^[a-zA-Z0-9]{2,50}[^!@#$%\^&*()_+=-?:;№\|\/\\><{}\'\"\`~&]$/m',
        '/^[a-zA-Z0-9]{2,50}[^!@#$%\^&*()_+=-?:;№\|\/\\><{}\'\"\`~&]$/m'
    ];
    $i = 0;
    foreach ($variable as $key) {
        if ($key == '' || !preg_match_all($variablePatterns[$i], $key)) {
            echo preg_match_all($variablePatterns[$i], $key);
            header('Location: ../pages/registration.html');
            exit;
        }
        $i += 1;
    }
} else if ($page == 'authorization.html' && ($login == '' || $password == '')) {
    header('Location: ../pages/' . $page);
    exit;
}
if ($page != '') {
    try {
        $host = "localhost";
        $user = "root";
        $db = "dem_exam";//https://phpmyadmin/public/phpMyAdmin-5.2.1-all-languages/index.php?route=/database/structure&db=Dem_Exam
        $pass = "root";
        $usertable = "users_pr";
        $charset = 'UTF-8';
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);// Создаём подключение
        echo "есть подключние";
    } catch (PDOException $e) {
        echo "Нет подключение к базе данных";
    }
    $sql = "SELECT * FROM `users_pr` WHERE `Login`='" . $login . "'";

    $result = $pdo->query($sql);
    if ($page == 'registration.html') {
        $sql2 = "SELECT * FROM `users_pr` WHERE `Email`='" . $mail . "'";
        $result2 = $pdo->query($sql2);
        echo "2";
        if ($result->rowCount() == 0) {
            echo "3";
            $query = "insert into $usertable (Login, Password	, Firstname, Lastname, Surname, Phone, Email, prov) values ('$login', '" . password_hash(hash('sha256', $password . 'loginHash'), PASSWORD_ARGON2I) . "', '$name', '$lastname', '$fathername', '$number', '$mail', '' )";
            $result = $pdo->query($query);
            $sql = "SELECT * FROM `users_pr` WHERE `login`='" . $login . "'";
            // $result = $pdo->query($sql)->fetch();
            $result = $pdo->query($sql)->fetch();
            session_start();
            $_SESSION["id"] = $result['User_Id'];
            echo session_name();
            header('Location: ../main.php?id='.$result['User_id']);
            exit;
        } else {
            echo "1";
            header('Location: ../pages/registration.html');
            exit;
        }
    } else if ($result->rowCount() == 1 && $page == "authorization.html") {
        $sql = "SELECT * FROM `Users_pr` WHERE `login`='" . $login . "' ";
        $result = $pdo->query($sql)->fetch();
        if (password_verify(hash('sha256', $password . 'loginHash'), $result['Password'])) {
            if($result['prov'] == true){
                session_start();
                $_SESSION["id"] = $result['User_id'];
                $_SESSION["prov"] = true;
                header('Location: ../pages/admin_Panel.php?id='.$result['User_id']);
                exit();
            }
            else{
                session_start();
                $_SESSION["id"] = $result['User_id'];
                $_SESSION["prov"] = false;
                header('Location: ../main.php?id='.$result['User_id']);
                exit();
            }
        } else {
            echo 'false';
            header('location: ../pages/registration.html');
        }
        echo '2';
        // $timeout = new EvTimer(10, 0, function () {
        //     session_destroy();
        // });
    }
} else {
    header('Location: ../pages/registration.html');
    exit;
}

// header('Location: ../main.php');

// header('Location: ../pages/'.$page);




// header('Location: http://www.example.com/form.php');
// exit;

// $argon2i$v=19$m=65536,t=4,p=1$ZVNHZnE3TEVxd0QyVU1KTA$F+SEW7o2y168N11PR4UZGX9ExEfr8eihxs8B0Ug9r+o
// $argon2i$v=19$m=65536,t=4,p=1$ZVNHZnE3TEVxd0QyVU1KTA$F+SEW7o2y168N11PR4UZGX9ExEfr8eihxs8B0Ug9r+o