<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<title>Поиск пропавших котов - сценарий</title>
</head>
<body>

<h2>Сообщения о поиске моего кота</h2>

<p>Сообщение будет добавлено в базу данных</p>

<?php

    $description = $_POST['description'];
    $email = $_POST['email'];
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $the_date = $_POST['when'];
    
    echo 'Спасибо за заполнение формы.<br>';
    echo 'Имя' . $first_name . '<br>';
    echo 'Фамилия: ' . $last_name . '<br>';
    echo 'Ваш email: ' . $email;
    
    $db = mysqli_connect('127.0.0.1', 'arhis77_bduction', 'VX6vm9zw', 'arhis77_bduction')
        or die('Error in established MySQL-server connect');
        
    $query = "INSERT INTO abduction (first_name, last_name, email) VALUES ('$first_name', '$last_name', '$email')";
             
    $result = mysqli_query($db, $query)
        or die ('Error in query to database');

    mysqli_close($db);

?>

</body>
</html>