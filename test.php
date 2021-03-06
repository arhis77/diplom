<?php
    // Допустим, у нас есть две переменные с названиями файлов картинок,
    // которые нам нужно вставить в письмо. JPEG и GIF файлы.
    $image1 = 'diplom.jpg';
    $image2 = 'diplom.jpg';
    // Переменная, хранящая адрес почты, на который нужно отправить письмо
    $to = 'arhis77@yandex.ru';
    // В переменной $html - сам текст письма, т.е. HTML-макет, в который
    // нужно встроить картинки и отправить по почте
    $html = '<html>
        <head>
            <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
            <title>Тема письма</title>
        </head>
        <body>
            <div>
                Картинка 1 ниже:<br />
                <img src="cid:' . $image1 . '" />
            </div>
            <br />
            <br />
            <div>
                Картинка 2 ниже:<br />
                <img src="cid:' . $image2 . '" />
            </div>
        </body>
    </html>';
    // Разделитель путей файлов, используемый в той операционной системе,
    // в которой выполняется наш скрипт. Вообще, можно просто использовать
    // константу DIRECTORY_SEPARATOR, но для краткости - создадим новую
    // константу с более коротким названием DS
    define('DS', DIRECTORY_SEPARATOR);
    // Определяем абсолютный путь к папке, в которой находится PHPMailer,
    // наш класс для отправки почты. В данном примере он лежит в той же папке,
    // в которой находится наш скрипт
    $path = dirname(__FILE__);
    // Определяем абсолютный путь к папке, в которой находятся отправляемые картинки.
    // В данном примере картинки находятся в папке images, которая, в свою очередь,
    // лежит в той же папке, в которой находится наш скрипт
    $imgPath = dirname(__FILE__) . DS . 'images';
    // Теперь подключаем класс PHPMailer
    require($path . DS . 'class.phpmailer.php');
    // И инициализируем его, создаём объект из класса
    $mailer = new PHPMailer();
    // Теперь начинается наша работа с этим объектом PHPMailer. Нам нужно
    // задать параметры отправляемого письма.
    // Указываем адрес отправителя почты. Это тот адрес, который будет
    // значиться в поле "От кого"
    $mailer->From = 'info@my-web-dev.16mb.com';
    // Указываем имя отправителя почты
    $mailer->FromName = 'Администрация my-web-dev.16mb.com';
    // Указываем кодировку письма
    $mailer->CharSet = 'utf-8';
    // Указываем тему письма
    $mailer->Subject = 'Тестовое письмо';
    // Теперь нужно прикрепить все картинки к письму. Если бы названия картинок,
    // которые нужно прикрепить, были бы в массиве, то можно было бы прикрепить их
    // в цикле, перебрав массив с помощью foreach. Но в данном примере названия
    // картинок находятся в обычных переменных, и мы будем прикреплять каждую
    // картинку отдельно. Как мы помним, первая картинка у нас типа JPEG, а вторая -
    // типа GIF.
    $mailer->AddEmbeddedImage($imgPath . DS . $image1, $image1, $image1, 'base64', 'image/jpeg');
    $mailer->AddEmbeddedImage($imgPath . DS . $image2, $image2, $image2, 'base64', 'image/gif');
    // Теперь указываем PHPMailer-у наш макет письма
    $mailer->Body = $html;
    // Далее указываем, что наше письмо имеет формат HTML, а не простой текст
    $mailer->IsHTML(true);
    // Указываем адрес получателя, куда нужно отправить наше письмо.
    $mailer->AddAddress($to);
    // Ну и наконец, письмо можно отправить. При вызове метода Send() объект
    // $mailer подготовит список необходимых заголовков для всего письма, а также
    // создаст заголовки для каждой отправляемой картинки. После чего он всё это
    // скомпонует в письмо и отправит его. Функцию mail() вызовет сам PHPMailer,
    // передав ей нужные параметры, а нам незачем об этом думать.
    $sended = $mailer->Send();
    // В переменной $sended должен быть результат отправки письма - переменная типа
    // boolean: true, если письмо отправилось и false, если нет. Посмотрим, что там у нас
    var_dump($sended);
?>