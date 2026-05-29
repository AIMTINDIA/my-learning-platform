<?php
session_start();

#header('content-Type: application/json');
include 'components/connect.php';
include('smtp/PHPMailerAutoload.php');

#error_reporting(-1);
#ini_set('display_errors','On');
#set_error_handler("var_dump");

$email=$_POST['email'];
$userType=$_POST['userType'];
$res=$conn->query("select * from otp where email='$email' and user_type='$userType'");


if($res->rowCount() > 0){
	$otp=rand(11111,99999);
        
	$conn->query("update otp set otp='$otp' where email='$email'");
	$html="Your otp verification code is ".$otp;
	$_SESSION['EMAIL']=$email;
	$email_from="bird@birdglobal.co.in";
	$from_name="BIRD ADMIN";
	$headers='From: '.$from_name.'<'.$email_from.'>';
    #mail($email,'OTP Verification',$html,$headers);
	smtp_mailer($email,'OTP Verification',$html);
    echo "yes";
	#$response = [ "status" => "yes",
	         #     "otp" => $otp ];
#	echo json_encode($response);              
}else{
	echo "not_exist";
}

function smtp_mailer($to,$subject, $msg){
#	require_once("smtp/class.phpmailer.php");
	$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
	#$mail->SMTPDebug = 1; 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "birdglobal.co.in@gmail.com";
	$mail->Password = "tfrdhnipgcagpyzo";
	$mail->SetFrom("birdglobal.co.in@gmail.com",'Bird Admin');
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	if(!$mail->Send()){
		return 0;
	}else{
		return 1;
	}
}
?>