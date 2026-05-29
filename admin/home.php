<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

$select_contents = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
$select_contents->execute([$tutor_id]);
$total_contents = $select_contents->rowCount();

$select_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
$select_playlists->execute([$tutor_id]);
$total_playlists = $select_playlists->rowCount();

$select_student = $conn->prepare("SELECT * FROM `users`");
$select_student->execute();
$total_student = $select_student->rowCount();

$fee_pending = $conn->prepare("SELECT * FROM `users` where balance!='0'");
$fee_pending->execute();
$total_pending = $fee_pending->rowCount();

$select_active = $conn->prepare("SELECT * FROM `users` WHERE delete_status = '0'");
$select_active->execute();
$total_active = $select_active->rowCount();

$select_inactive = $conn->prepare("SELECT * FROM `users` WHERE delete_status = '1'");
$select_inactive->execute();
$total_inactive = $select_inactive->rowCount();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>
   <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- BOOTSTRAP STYLES-->
    <link href="../css/bootstrap.css" rel="stylesheet" />
	<!-- FONTAWESOME STYLES-->
    <link href="../css/font-awesome.css" rel="stylesheet" />
   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">
       <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>

<?php include '../components/admin_header.php'; ?>
   
<section class="dashboard">

   <h1 class="heading">Dashboard</h1>

   <div class="box-container">

      <div class="box">
         <h3>Welcome! <?= $fetch_profile['name']; ?></h3>
		 <p>Total Fee Pending:  <?= $total_pending; ?></p>
         <a href="fees.php" class="delete-btn">Collect Fee</a>
      </div>
	  
	   <div class="box">
         <h3>Report</h3>
         <p>Check Report</p>
         <div class="flex-btn">
            <a href="report.php" class="option-btn">Report</a>
         </div>
      </div>
	  
	   <div class="box">
         <h3>Expense</h3>
         <p>Check Expense</p>
         <div class="flex-btn">
            <a href="expense.php" class="delete-btn">Add Expense</a>
         </div>
      </div>

      <div class="box">
         <h3><?= $total_student; ?></h3>
         <p>Total Students</p>
         <a href="student.php" class="btn">Manage Students</a>
      </div>
      
	  <div class="box">
         <h3><?= $total_active; ?></h3>
         <p>Total Active Students</p>
         <a href="student.php" class="btn">Active Students</a>
      </div>

      <div class="box">
         <h3><?= $total_inactive; ?></h3>
         <p>Total In-Active Students</p>
         <a href="inactivestd.php" class="btn">view In-active Students</a>
      </div>
	  
	  <div class="box">
         <h3><?= $total_contents; ?></h3>
         <p>Total Contents</p>
         <a href="add_content.php" class="btn">add new content</a>
      </div>

      <div class="box">
         <h3><?= $total_playlists; ?></h3>
         <p>Total Playlists</p>
         <a href="add_playlist.php" class="btn">add new playlist</a>
      </div>
     

   </div>

</section>















<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>