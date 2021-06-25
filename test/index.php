
<?php
error_reporting(0);
$msgerror = '';
$msgsuccess='';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if ($_POST['mailto'] == "") {

        $msgerror = 'Пожалуйста, введите email.';
    } else {

        /**/
        $mailto = $_POST['mailto'];
        $mailfrom = 'RHRS';
        $mailsubject = 'Ваш сертификат об участии в конгрессе';


     /* Подключение к базе данных */

    $db = mysqli_connect('127.0.0.1', 'arhis77_bduction', 'VX6vm9zw', 'arhis77_bduction')
        or die('Error connecting to MySQL server.');

    $query = "SELECT * FROM users WHERE email = '$email'";

    $result = mysqli_query($db, $query)
        or die('Error querying database.');

    while ($row = mysqli_fetch_array($result)){
       $firstname = $row['first_name'];
       $lastname = $row['last_name'];
    } 
    // echo $firstname;

    mysqli_close($dbc);
    
    /*********************************************************/


        $content = '';

        $content .= '
                <style>
                table {
                border-collapse: collapse;
                }

                table{
                 width:800px;
                 margin:0 auto;
                }

                td{
                border: 1px solid #e2e2e2;
                padding: 10px; 
                max-width:520px;
                word-wrap: break-word;
                }


                </style>

                ';
        /* you css */

        $content .= '<div style="position: relative;">';
        // $content .= '<img src="https://2019.rhrs.pro/img/diplom_2019_spb.jpg" width="750" style="max-width: 100%;">';
        $content .= '<div style="position: absolute; color: red; font-size: 34px; top: 591px; width: 558px; text-align: center; text-transform: uppercase;">' . $firstname . '&nbsp;' . $lastname . 'aasdfdasfa</div>';
        $content .= '</div>';

        // $content .= '<table>';

        // $content .= '<tr><td>Mail To</td> <td>' . $mailto . '</td> </tr>';
        // $content .= '<tr><td>Mail From</td>   <td>' . $mailfrom . '</td> </tr>';
        // $content .= '<tr><td>Mail Subject</td>   <td>' . $mailsubject . '</td> </tr>';
        // $content .= '<tr><td>Firstname</td>   <td>' . $firstname . '</td> </tr>';
        // $content .= '<tr><td>Lastname</td>   <td>' . $lastname . '</td> </tr>';
        // $content .= '<tr><td>Description</td>   <td>' . $description . '</td> </tr>';

        // $content .= '</table>';


        require_once('html2pdf/html2pdf.class.php');
        // require($_SERVER["DOCUMENT_ROOT"]."/html2pdf/html2pdf.class.php");


        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8');
        $html2pdf->setDefaultFont('arialunicid0'); // для поддержки кириллицы

        // $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8');

        $html2pdf->setDefaultFont('arialunicid0'); //add this line
        $html2pdf->WriteHTML($content);


        $to = $mailto;
        $from = $mailfrom;
        $subject = $mailsubject;

        $message = "<p>Please see the attachment.</p>";
        $separator = md5(time());
        $eol = PHP_EOL;
        $filename = "pdf-document.pdf";
        $pdfdoc = $html2pdf->Output('', 'S');
        $attachment = chunk_split(base64_encode($pdfdoc));




        $headers = "From: " . $from . $eol;
        $headers .= "MIME-Version: 1.0" . $eol;
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol . $eol;

        $body = '';

        $body .= "Content-Transfer-Encoding: 7bit" . $eol;
        $body .= "This is a MIME encoded message." . $eol; //had one more .$eol


        $body .= "--" . $separator . $eol;
        // $body .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol;
        $body .= "Content-Type: text/html; charset=\"UTF-8\"" . $eol;
        $body .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
        $body .= $message . $eol;


        $body .= "--" . $separator . $eol;
        $body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
        $body .= "Content-Transfer-Encoding: base64" . $eol;
        $body .= "Content-Disposition: attachment" . $eol . $eol;
        $body .= $attachment . $eol;
        $body .= "--" . $separator . "--";

        if (mail($to, $subject, $body, $headers)) {

            $msgsuccess = 'Ваше сообщение успешно отправлено. Сертификат об участии в конгрессе будет выслан на почту ' . $mailto . ' .';
        } else {

            $msgerror = 'Main not send';
        }


        /**/
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>webatsolution - php email send  with attachment</title>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <style>


        </style>

    </head>
    <body>

        <div class="container">
            <div class="page-header">
                <h1>Введите Ваш Email:</h1>      
            </div>

<?php
if ($msgerror) {
    ?>
                <div class="alert alert-danger"><?php echo $msgerror; ?></div>
            <?php } else if ($msgsuccess) { ?>
                <div class="alert alert-success"><?php echo $msgsuccess; ?></div>
            <?php } ?>

            <div class="form"> 
                <form class="form-horizontal" action="" method="post">

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="mailto">Email:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="mailto" placeholder="Enter mailto" name="mailto" value="<?php echo $_POST['mailto']; ?>">
                        </div>
                    </div>

                    <div class="form-group">        
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Отправить</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.form -->



        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    </body>
</html> 
