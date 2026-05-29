<?phpsession_start();$con=mysqli_connect('localhost','root','','course_db');$email=$_POST['email'];$res=mysqli_query($con,"select * from otp where email='$email'");$count=mysqli_num_rows($res);if($count>0){	$otp=rand(11111,99999);	mysqli_query($con,"update otp set otp='$otp' where email='$email'");	$html="Your otp verification code is ".$otp;	$_SESSION['EMAIL']=$email;	smtp_mailer($email,'OTP Verification',$html);	echo "yes";}else{	echo "not_exist";}function smtp_mailer($to,$subject, $msg){
	require_once("smtp/class.phpmailer.php");
	$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
	$mail->SMTPDebug = 1; 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'TLS'; 
	$mail->Host = "mail.atmasamman.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "aimt@atmasamman.com";
	$mail->Password = "aimt@123";
	$mail->SetFrom("aimt@atmasamman.com",'AIMT INDIA');
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	if(!$mail->Send()){
		return 0;
	}else{
		return 1;
	}
}?>