<?php
$errors = [];
$status = true;

if ($_SERVER['REQUEST_METHOD'] === "POST") 
{

    if (empty($_POST['email'])) {      
        $status = false;
        $errors['email']= 'Поле email обязательное для заполнения';
    }

    if (empty($_POST['password'])) {
      $status = false;
      $errors['password']= 'Поле password обязательное для заполнения';
    }

    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['email'])) {
      $status = false;
      $errors['email']= 'Поле email не валидно';
    }

    if(!$status){
        echo json_encode([
        'status' => $status,
        'errors' => implode(' ', $errors),
        ]);
    die;    
    }    
}
if($status) 
{
    require 'cheking.php';
}

?>
