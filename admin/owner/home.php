<?php

include '../../components/connect.php';

if(isset($_COOKIE['owner_id'])){
   $owner_id = $_COOKIE['owner_id'];
}else{
   $owner_id = '';
   header('location:login.php');
}

$select_payment = $conn->prepare("SELECT sum(paid) FROM `placed_transaction` where submitdate>='2025-05-01'");
$select_payment->execute();
$total_payment = $select_payment->fetch(PDO::FETCH_ASSOC);

$select_fees = $conn->prepare("SELECT sum(paid) FROM `fees_transaction` where submitdate>='2025-05-01'");
$select_fees->execute();
$total_fees = $select_fees->fetch(PDO::FETCH_ASSOC);

$select_expense = $conn->prepare("SELECT sum(amount) FROM `expenses` where tdate>='2025-05-01'");
$select_expense->execute();
$total_expense = $select_expense->fetch(PDO::FETCH_ASSOC);

$select_anil = $conn->prepare("SELECT sum(paid) FROM `placed_transaction` where `receiver` = 'anil' and submitdate>='2025-05-01'");
$select_anil->execute();
$total_anil = $select_anil->fetch(PDO::FETCH_ASSOC);

$select_expense_anil = $conn->prepare("SELECT sum(amount) FROM `expenses` where `name` = 'anil' and tdate>='2025-05-01'");
$select_expense_anil->execute();
$total_expense_anil = $select_expense_anil->fetch(PDO::FETCH_ASSOC);

$select_manjeet = $conn->prepare("SELECT sum(paid) FROM `placed_transaction` where `receiver` = 'Manjeet' and submitdate>='2025-05-01' ");
$select_manjeet->execute();
$total_manjeet = $select_manjeet->fetch(PDO::FETCH_ASSOC);

$select_expense_manjeet = $conn->prepare("SELECT sum(amount) FROM `expenses` where `name` = 'Manjeet' and tdate>='2025-05-01'");
$select_expense_manjeet->execute();
$total_expense_manjeet = $select_expense_manjeet->fetch(PDO::FETCH_ASSOC);

$select_student = $conn->prepare("SELECT * FROM `users`");
$select_student->execute();
$total_student = $select_student->rowCount();

$fee_pending = $conn->prepare("SELECT * FROM `placement` u , `placement` p where p.registration_id=u.registration_id and p.emi!=u.total_emi and p.next_emi_date<=current_timestamp()");
$fee_pending->execute();
$total_pending = $fee_pending->rowCount();

$select_active = $conn->prepare("SELECT * FROM `users` WHERE delete_status = '2'");
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

</head>
<body>

<?php include '../../components/owner_header.php'; ?>
   
<section class="dashboard">

   <h1 class="heading">Dashboard</h1>

   <div class="box-container">

      <div class="box">
         <h3>Welcome! <?= $fetch_profile['name']; ?></h3>
		 <p>Total Fee Pending:  <?= $total_pending; ?></p>
         <a href="placed_fees.php" class="delete-btn">Collect Fee</a>
      </div>
	  
	  <div class="box">
         <h3><?= $total_student; ?></h3>
         <p>Total Students</p>
         <a href="student.php" class="btn">Manage Students</a>
      </div>
      
	  
	  <div class="box">
         <h3><?= $total_active; ?></h3>
         <p>Total Placed Students</p>
         <a href="placed.php" class="btn">Placed Students</a>
      </div>
	  
	  <div class="box">
        <!-- <h3><?= $total_payment['sum(paid)']; ?></h3> -->
         <p>Total Fee Received = <?= $total_payment['sum(paid)']; ?></p>
		 <!--<h3><?= $total_expense['sum(amount)']; ?></h3>-->
         <p>Total Expense = <?= $total_expense['sum(amount)']; ?></p>
         <!--<h3><?= $total_fees['sum(paid)']; ?></h3>-->
         <p>Total Pre Fees = <?= $total_fees['sum(paid)']; ?></p>
		 <!--<h3><?= $total_payment['sum(paid)']+$total_fees['sum(paid)']-$total_expense['sum(amount)']; ?></h3>-->
         <p>Total Profit = <?= $total_payment['sum(paid)']+$total_fees['sum(paid)']-$total_expense['sum(amount)']; ?> </p>
         <h1 class="btn">BIRD<h1>
      </div>

      <div class="box">
         <p>Total Fee Received = <?= $total_anil['sum(paid)']; ?></p>
         <p>Total Expense = <?= $total_expense_anil['sum(amount)']; ?></p>
         <p>Total Pre Fees = <?= $total_fees['sum(paid)']; ?></p>
         <p>Total Profit = <?= $total_anil['sum(paid)']+$total_fees['sum(paid)']-$total_expense_anil['sum(amount)']; ?></p>
         <h1 class="btn">anil<h1>
      </div>

      <div class="box">
         <p>Total Fee Received = <?= $total_manjeet['sum(paid)']; ?></p>
         <p>Total Expense = <?= $total_expense_manjeet['sum(amount)']; ?></p>
         <p>Total Profit = <?= $total_manjeet['sum(paid)']-$total_expense_manjeet['sum(amount)']; ?></p>
         <h1 class="btn">Manjeet<h1>
      </div>
	  
      <div class="box">
         <h3>Quick Select</h3>
         <p>Check Report</p>
            <a href="placed_report.php" class="option-btn">Report</a>         
      </div>
	  
	  <div class="box">
         <h3>Quick Select</h3>
         <p>Create Backup</p>
         <a href="excel.php" class="option-btn">Backup</a>
      </div>

   </div>

</section>















<?php include '../../components/footer.php'; ?>

<script src="../../js/admin_script.js"></script>

</body>
</html>