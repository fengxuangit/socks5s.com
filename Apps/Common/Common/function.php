<?php
//打折信息
function GetMoneyCount($month, $price){
    $month = $month / 30;
    switch ($month) {
        case 1:
            return $price;
            break;
        case 6:
            return $price * ($month - 1) ;
            break;
        case 12:
            return $price * ($month - 2) ;
            break;
    }
}

//发送邮件
function SendMail($address, $title, $message){
    vendor('PHPMailer.class#phpmailer');

    $mail = new \PHPMailer();

    $mail->IsSMTP();

    $mail->CharSet='UTF-8';

    $mail->AddAddress($address);

    $mail->Body=$message;

    $mail->From=C('MAIL_ADDRESS');

    $mail->FromName='shadowssocks';

    $mail->Subject = $title;

        // 设置SMTP服务器。
    $mail->Host=C('MAIL_SMTP');
 
    // 设置为"需要验证"
    $mail->SMTPAuth=true;
 
    // 设置用户名和密码。
    $mail->Username=C('MAIL_LOGINNAME');
    $mail->Password=C('MAIL_PASSWORD');
 
    // 发送邮件。
    return($mail->Send());
}

//生成随机数
function mail_random($length = 6 , $numeric = 0) {
    PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
    if($numeric) {
        $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
    } else {
        $hash = '';
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
        $max = strlen($chars) - 1;
        for($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
    }
    return $hash;
}

?>