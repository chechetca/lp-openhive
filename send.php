<?php
// проверяем отпарвлена ли форма
if (isset($_POST['email']))
{
    //Получаем данные
    $email = $_POST['email'];
    $name = $_POST['name'];
    $text = $_POST['message'];

    $massage = "Имя: ".$name."\n E-mail: ".$email."\n\n".$text;
    $to = "info@openhive.ru";
    $subject = "Отправлено с openhive.ru";
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: '.$email;


    //Формируем сообщение
    mail($to, $subject, $massage, $headers);
}