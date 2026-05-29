<?php

include '../../components/connect.php';

if(isset($_COOKIE['owner_id'])){
   $owner_id = $_COOKIE['owner_id'];
}else{
   $owner_id = '';
   header('location:login.php');
}


$select_expenses = $conn->prepare("SELECT backup_date FROM `backup` where table_name='expenses'");
$select_expenses->execute();
$expenses = $select_expenses->fetch(PDO::FETCH_ASSOC);

$select_tutors = $conn->prepare("SELECT backup_date FROM `backup` where table_name='tutors'");
$select_tutors->execute();
$tutors = $select_tutors->fetch(PDO::FETCH_ASSOC);

$select_contact = $conn->prepare("SELECT backup_date FROM `backup` where table_name='contact'");
$select_contact->execute();
$contact = $select_contact->fetch(PDO::FETCH_ASSOC);

$select_comments = $conn->prepare("SELECT backup_date FROM `backup` where table_name='comments'");
$select_comments->execute();
$comments = $select_comments->fetch(PDO::FETCH_ASSOC);

$select_bookmark = $conn->prepare("SELECT backup_date FROM `backup` where table_name='bookmark'");
$select_bookmark->execute();
$bookmark = $select_bookmark->fetch(PDO::FETCH_ASSOC);

$select_content = $conn->prepare("SELECT backup_date FROM `backup` where table_name='content'");
$select_content->execute();
$content = $select_content->fetch(PDO::FETCH_ASSOC);

$select_fees_transaction = $conn->prepare("SELECT backup_date FROM `backup` where table_name='fees_transaction'");
$select_fees_transaction->execute();
$fees_transaction = $select_fees_transaction->fetch(PDO::FETCH_ASSOC);

$select_likes = $conn->prepare("SELECT backup_date FROM `backup` where table_name='likes'");
$select_likes->execute();
$likes = $select_likes->fetch(PDO::FETCH_ASSOC);

$select_otp = $conn->prepare("SELECT backup_date FROM `backup` where table_name='otp'");
$select_otp->execute();
$otp = $select_otp->fetch(PDO::FETCH_ASSOC);

$select_owners = $conn->prepare("SELECT backup_date FROM `backup` where table_name='owners'");
$select_owners->execute();
$owners = $select_owners->fetch(PDO::FETCH_ASSOC);

$select_placed_transaction = $conn->prepare("SELECT backup_date FROM `backup` where table_name='placed_transaction'");
$select_placed_transaction->execute();
$placed_transaction = $select_placed_transaction->fetch(PDO::FETCH_ASSOC);

$select_placement = $conn->prepare("SELECT backup_date FROM `backup` where table_name='placement'");
$select_placement->execute();
$placement = $select_placement->fetch(PDO::FETCH_ASSOC);

$select_playlist = $conn->prepare("SELECT backup_date FROM `backup` where table_name='playlist'");
$select_playlist->execute();
$playlist = $select_playlist->fetch(PDO::FETCH_ASSOC);


$select_program = $conn->prepare("SELECT backup_date FROM `backup` where table_name='program'");
$select_program->execute();
$program = $select_program->fetch(PDO::FETCH_ASSOC);

$select_users = $conn->prepare("SELECT backup_date FROM `backup` where table_name='users'");
$select_users->execute();
$users = $select_users->fetch(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- BOOTSTRAP STYLES-->
    <link href="../../css/bootstrap.css" rel="stylesheet" />
	<!-- FONTAWESOME STYLES-->
    <link href="../../css/font-awesome.css" rel="stylesheet" />
   <!-- custom css file link  -->
   <link rel="stylesheet" href="../../css/admin_style.css">
       <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
	   .excel{
		     border-radius: 0.5rem;
    padding: 1rem 3rem;
    font-size: 1.8rem;
    color: #fff;
    text-transform: capitalize;
    cursor: pointer;
    text-align: center;
	width: 100% 
	   }
	</style>
</head>
<body>

<?php include '../../components/owner_header.php'; ?>
   
<section class="dashboard">

   <h1 class="heading">Dashboard</h1>

   <div class="box-container">

      <div class="box">
         <h3>Expenses Table </h3>
		 <p>Last Backup On:</br><?=$expenses['backup_date'];?></p>
         <form action="backup.php" method="post">
                <input type="submit" name="expenses_Backup" class="excel"  value="expenses_Backup"/>
            </form>
      </div>
	  
	  <div class="box">
         <h3>Tutors Table </h3>
		 <p>Last Backup On:</br><?=$tutors['backup_date'];?></p>
         <form action="backup.php" method="post">
                <input type="submit" name="tutors_Backup" class="excel"  value="tutors_Backup"/>
            </form>
      </div>
	  
	  <div class="box">
         <h3>BookMark Table </h3>
		 <p>Last Backup On:</br><?=$bookmark['backup_date'];?> </p>
         <form action="backup.php" method="post">
                <input type="submit" name="bookmark_Backup" class="excel"  value="bookmark_Backup"/>
            </form>
      </div>
	  
	  <div class="box">
         <h3>Comments Table </h3>
		 <p>Last Backup On:</br><?=$comments['backup_date'];?></p>
         <form action="backup.php" method="post">
                <input type="submit" name="comments_Backup" class="excel"  value="comments_Backup"/>
            </form>
      </div>
	  
	  <div class="box">
         <h3>Contact Table </h3>
		 <p>Last Backup On:</br><?=$contact['backup_date'];?></p>
         <form action="backup.php" method="post">
                <input type="submit" name="contact_Backup" class="excel"  value="contact_Backup"/>
            </form>
      </div>
	  
	  <div class="box">
         <h3>Content Table </h3>
		 <p>Last Backup On:</br><?=$content['backup_date'];?></p>
         <form action="backup.php" method="post">
                <input type="submit" name="content_Backup" class="excel"  value="content_Backup"/>
            </form>
      </div>
	  
	  <div class="box">
         <h3>Fees_Transaction Table </h3>
		 <p>Last Backup On:</br><?=$fees_transaction['backup_date'];?></p>
         <form action="backup.php" method="post">
                <input type="submit" name="fees_transaction_Backup" class="excel"  value="fees_transaction_Backup"/>
            </form>
      </div>
	  
	  <div class="box">
         <h3>Likes Table </h3>
		 <p>Last Backup On:</br><?=$likes['backup_date'];?></p>
         <form action="backup.php" method="post">
                <input type="submit" name="likes_Backup" class="excel"  value="likes_Backup"/>
            </form>
      </div>
	  
	  <div class="box">
         <h3>OTP Table </h3>
		 <p>Last Backup On:</br><?=$otp['backup_date'];?></p>
         <form action="backup.php" method="post">
                <input type="submit" name="otp_Backup" class="excel"  value="otp_Backup"/>
            </form>
      </div>
	  
	  <div class="box">
         <h3>Owners Table </h3>
		 <p>Last Backup On:</br><?=$owners['backup_date'];?></p>
         <form action="backup.php" method="post">
                <input type="submit" name="owners_Backup" class="excel"  value="owners_Backup"/>
            </form>
      </div>
	  
	  <div class="box">
         <h3>Place_Transaction Table </h3>
		 <p>Last Backup On:</br><?=$placed_transaction['backup_date'];?></p>
         <form action="backup.php" method="post">
                <input type="submit" name="placed_transaction_Backup" class="excel"  value="placed_transaction_Backup"/>
            </form>
      </div>
	  
	  <div class="box">
         <h3>Placement Table </h3>
		 <p>Last Backup On:</br><?=$placement['backup_date'];?></p>
         <form action="backup.php" method="post">
                <input type="submit" name="placement_Backup" class="excel"  value="placement_Backup"/>
            </form>
      </div>
	  
	  <div class="box">
         <h3>Playlist Table </h3>
		 <p>Last Backup On:</br><?=$playlist['backup_date'];?></p>
         <form action="backup.php" method="post">
                <input type="submit" name="playlist_Backup" class="excel"  value="playlist_Backup"/>
            </form>
      </div>
	  
	  <div class="box">
         <h3>Program Table </h3>
		 <p>Last Backup On:</br><?=$program['backup_date'];?></p>
         <form action="backup.php" method="post">
                <input type="submit" name="program_Backup" class="excel"  value="program_Backup"/>
            </form>
      </div>
	  
	  
	  <div class="box">
         <h3>Users Table </h3>
		 <p>Last Backup On:</br><?=$users['backup_date'];?></p>
         <form action="backup.php" method="post">
                <input type="submit" name="users_Backup" class="excel"  value="users_Backup"/>
            </form>
      </div>
	  
   </div>

</section>

<script>
    let plist = document.querySelectorAll('p');
	let d = new Date();
	plist.forEach((item)=>{
		let data = item.innerHTML.slice(19).split('-');
		let backupd = new Date(data[2],data[1]-1,data[0]);
		backupd.setMonth(backupd.getMonth()+1);
		if ( d >= backupd ){
		  
		   item.nextElementSibling.firstElementChild.classList.add('delete-btn');
		   item.nextElementSibling.firstElementChild.value = 'Take Backup';
		}else{
			 item.nextElementSibling.firstElementChild.classList.add('btn-success');
			 item.nextElementSibling.firstElementChild.value = 'Backup Done';	
		}
		
		
	})
	
		var button = document.getElementsByTagName("input"),
    len = button.length,
    i;
function click(){
	this.value = 'Backup Done';	
	this.classList.add('btn-success');
	this.classList.remove('delete-btn');
}
for(i=1;i<len;i+=1){
  button[i].onclick= click;
 
}
</script>
<?php include '../../components/footer.php'; ?>

<script src="../../js/admin_script.js"></script>

</body>
</html>