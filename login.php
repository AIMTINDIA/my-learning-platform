<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form action="" method="post" enctype="multipart/form-data" class="login">
      <h3>Welcome Back!</h3>
	  <div class="form-group first_box">
        <p>Your Email <span>*</span></p>
        <input type="email" id="email"  placeholder="Enter Your Email" maxlength="50" required class="box">
        <span id="confirmation" style="color:green;font-size:15px"> </span></br>
		<span id="email_error" class="field_error" style="color:red;font-size:18px"></span>
	  </div>
	  <div class="first_box">
        <button type="button" class="btn" onclick="send_otp()">Send OTP</button>
      </div>
	  <div class="form-group second_box">
	   <!--   <h1 id="showotp"> </h1>  -->
	    <input type="text" id="otp" class="box" placeholder="OTP" required="required">
	    <span id="otp_error" class="field_error"></span>
	  </div>
	  <div class="form-group second_box">
        <button type="button" class="option-btn" onclick="submit_otp()">Submit OTP</button>
      </div>   
      <!--<input type="submit" name="submit" value="login now" class="btn">-->
   </form>

</section>












<?php include 'components/footer.php'; ?>

<script>
function send_otp(){
	jQuery('#confirmation').html(' Validating Please wait...');
	jQuery('#email_error').html('');
	var email=jQuery('#email').val();
	jQuery.ajax({
		url:'send_otp.php',
		type:'post',
		data:'email='+email+'&userType=student',
		success:function(result){
			if(result=='yes'){
				jQuery('.second_box').show();
				jQuery('.first_box').hide();
			}
			if(result=='not_exist'){
				jQuery('#confirmation').html('');
				jQuery('#email_error').delay(5000).html('Please enter valid email');
			}
		}
	});
}

function submit_otp(){
	var otp=jQuery('#otp').val();
	jQuery.ajax({
		url:'check_otp.php',
		type:'post',
		data:'otp='+otp,
		success:function(result){
			if(result=='yes'){
				
					    
				window.location='home.php'
			}
			if(result=='not_exist'){
				jQuery('#otp_error').html('Please enter valid otp');
			}
		}
	});
}
</script>


<!-- custom js file link  -->
<script src="js/script.js"></script>
<style>
.second_box{display:none;}
.field_error{color:red;}
</style>   
</body>
</html>