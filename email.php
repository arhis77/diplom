<?php
    $from = 'you@mail.com';
    $email = $_POST['email'];

    $db = mysqli_connect('127.0.0.1', 'arhis77_bduction', 'VX6vm9zw', 'arhis77_bduction')
        or die('Error connecting to MySQL server.');

    // $query = "SELECT * FROM abduction WHERE email = '$email'";
	$query = mysql_query("SELECT * FROM abduction WHERE email = '$email'");
	if(mysql_num_rows($query) > 0) {
		echo 'email exest';
	}

    // $result = mysqli_query($db, $query)
    //     or die('Error querying database.');

    // while ($row = mysqli_fetch_array($result)){
    //     $to = $_POST['email'];
    //     $first_name = $row['first_name'];
    //     $last_name = $row['last_name'];
    //     $subject = 'Ваш сертификат участника';
    //     mail($to, $subject, $first_name . ' ' . $last_name);
    //     echo 'Email sent to: ' . $to . '<br />';
    // } 

    mysqli_close($dbc);
?>