<?php

    $host = 'localhost';
    $db = '9les';
    $user = 'root';
    $pass = 'root';
    $charset = 'utf8';
    $text = $_POST['email'];
    $password = md5($_POST['password']);
        
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, $user, $pass, $opt);

    $sql = "SELECT * FROM users WHERE email=:mail and password=:password limit 1";

    $rows = $pdo->prepare($sql);
    $rows->execute(['mail'=>$text, 'password'=>$password]);

    $users = $rows->fetch();

    if($users) 
    {
        require 'Session.php';
        $session = new Session;
        $session->set('id', $users['id']);
        $session->set('email', $users['email']);
        $session->set('fio', $users['fio']);
        $session->set('role_id', $users['role_id']);

        $date = date('Y-m-d');
        $id = $users['id'];

        $sql = "UPDATE `users` SET `last_enter_date`=:day WHERE `id`=:id";
        $rows = $pdo->prepare($sql);
        $rows->execute(['day'=>$date, 'id'=>$id]);

        echo json_encode(['status'=>true]);
        
    } 
    else 
    {
        echo json_encode(['status'=>false, 'message'=>'Пользователь не найден в системе']);
    }
?>
