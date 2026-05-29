<?php $page='student';
include("../../components/connect.php");
if(isset($_COOKIE['owner_id'])){
   $owner_id = $_COOKIE['owner_id'];
}else{
   $owner_id = '';
   header('location:login.php');
}
$errormsg = '';
$action = "add";

$registration_id="";
$emailid='';
$name='';
$doj = '';
$newdoj = '';
$fname = '';
$gender = '';
$remark='';
$contact_no='';
$acontact_no = '';
$year10 = '';
$year12 = '';
$graduationt = '';
$yearg = '';
$pgraduation = '';
$yearpg = '';
$balance = 0;
$fees='';
$address = '';
$program='';


if(isset($_POST['save']))
{

$name = filter_var($_POST['sname'],FILTER_SANITIZE_STRING);
$doj = filter_var($_POST['doj'],FILTER_SANITIZE_STRING);
$fname = filter_var($_POST['fname'],FILTER_SANITIZE_STRING);
$contact_no = filter_var($_POST['contact'],FILTER_SANITIZE_STRING);
$address = filter_var($_POST['address'],FILTER_SANITIZE_STRING);
$emailid = filter_var($_POST['emailid'],FILTER_SANITIZE_STRING);
$program = filter_var($_POST['program'],FILTER_SANITIZE_STRING);
$gender = filter_var($_POST['gender'],FILTER_SANITIZE_STRING);
$acontact_no = filter_var($_POST['acontact'],FILTER_SANITIZE_STRING);
$year10 = filter_var($_POST['year10'],FILTER_SANITIZE_STRING);
$year12 = filter_var($_POST['year12'],FILTER_SANITIZE_STRING);
$yearg = filter_var($_POST['yearg'],FILTER_SANITIZE_STRING);
$yearpg = filter_var($_POST['yearpg'],FILTER_SANITIZE_STRING);
$graduationt = filter_var($_POST['graduation'],FILTER_SANITIZE_STRING);
$pgraduation = filter_var($_POST['pgraduation'],FILTER_SANITIZE_STRING);
$id = unique_id();
 
 if($_POST['action']=="add")
 {
 $remark = filter_var($_POST['remark'],FILTER_SANITIZE_STRING);
 $fees = filter_var($_POST['fees'],FILTER_SANITIZE_STRING);
 $advancefees = filter_var($_POST['advancefees'],FILTER_SANITIZE_STRING);
 $balance = $fees-$advancefees;
 $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id().'.'.$ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_files/'.$rename;
 
  $q1 = $conn->prepare("INSERT INTO `users` (id,name,father_name,gender,contact_no,alternate_contact,email,year10,year12,program,graduationt,yearg,post_graduation,yearpg,address,fees,balance,doj,image) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)") ;
  $q1->execute([$id,$name,$fname,$gender,$contact_no,$acontact_no,$emailid,$year10,$year12,$program,$graduationt,$yearg,$pgraduation,$yearpg,$address,$fees,$balance,$doj,$rename]);
  $registration_id = $conn->lastInsertId();
   move_uploaded_file($image_tmp_name, $image_folder);
		 $insert_otp = $conn->prepare("INSERT INTO `otp`(email) VALUES(?)");
         $insert_otp->execute([$emailid]);
 $q2 = $conn->prepare("INSERT INTO  fees_transaction (stdid,paid,submitdate,transaction_remark) VALUES ('$registration_id','$advancefees','$doj','$remark')") ;
  $q2->execute();  
   echo '<script type="text/javascript">window.location="student.php?act=1";</script>';
 
 }else
  if($_POST['action']=="update")
 {
 $registration_id = filter_var($_POST['registration_id'],FILTER_SANITIZE_STRING);
 #  $image = $_FILES['image']['name'];
 #  $image = filter_var($image, FILTER_SANITIZE_STRING);
 #  $ext = pathinfo($image, PATHINFO_EXTENSION);
 #  $rename = unique_id().'.'.$ext;
 #  $image_size = $_FILES['image']['size'];
  # $image_tmp_name = $_FILES['image']['tmp_name'];
  # $image_folder = 'uploaded_files/'.$rename; 
   
  # $sql = $conn->prepare("UPDATE  users  SET  name= ?,father_name=?,gender= ?,contact_no=?,alternate_contact=?,email=?,year10=?,year12=?,program=?,graduationt=?,yearg=?,post_graduation=?,yearpg=?,address=?,doj=?,image=? WHERE  registration_id  = ?");
   #$sql->execute([$name,$fname,$gender,$contact_no,$acontact_no,$emailid,$year10,$year12,$program,$graduationt,$yearg,$pgraduation,$yearpg,$address,$doj,$rename,$registration_id]);
  # move_uploaded_file($image_tmp_name, $image_folder);
   
   if($_POST['placed']=="yes"){
	   
	   $newdoj=filter_var($_POST['newdoj'],FILTER_SANITIZE_STRING);
	   $cname=filter_var($_POST['cname'],FILTER_SANITIZE_STRING);
	   $package=filter_var($_POST['package'],FILTER_SANITIZE_STRING);
	   $check1=filter_var($_POST['check1'],FILTER_SANITIZE_STRING);
	   $tot_emi=filter_var($_POST['tot_emi'],FILTER_SANITIZE_STRING);
	   $q1 = $conn->prepare("INSERT INTO `placement` (registration_id,doj,company,package,cheque,total_emi,previous_emi_date,next_emi_date) VALUES('$registration_id','$newdoj','$cname','$package','$check1','$tot_emi',current_timestamp(),current_timestamp())");
       $q1->execute();
	   
	   $sql = $conn->prepare("UPDATE users set delete_status = '2'  WHERE registration_id=?");
	   $sql->execute([$registration_id]);
	   
   }
  # echo '<script type="text/javascript">window.location="student.php?act=2";</script>';
 }



}




if(isset($_GET['action']) && $_GET['action']=="delete"){

 $q3 = $conn->prepare("UPDATE users set delete_status = '1'  WHERE registration_id='".$_GET['registration_id']."'");	
 $q3->execute();
header("location: student.php?act=3");

}


$action = "add";
if(isset($_GET['action']) && $_GET['action']=="edit" ){
$registration_id = isset($_GET['registration_id'])?filter_var($_GET['registration_id'],FILTER_SANITIZE_STRING):'';

$sqlEdit = $conn->prepare("SELECT * FROM users WHERE registration_id='".$registration_id."'");
$sqlEdit->execute();
if($sqlEdit->rowCount() > 0)
{
$rowsEdit = $sqlEdit->fetch(PDO::FETCH_ASSOC);
#extract($rowsEdit);
$fname = $rowsEdit['father_name'];
$name = $rowsEdit['name'];
$doj = $rowsEdit['doj'];
$fname = $rowsEdit['father_name'];
$contact_no = $rowsEdit['contact_no'];
$address = $rowsEdit['address'];
$emailid = $rowsEdit['email'];
$program = $rowsEdit['program'];
$gender = $rowsEdit['gender'];
$acontact_no = $rowsEdit['alternate_contact'];
$year10 = $rowsEdit['year10'];
$year12 = $rowsEdit['year12'];
$yearg = $rowsEdit['yearg'];
$yearpg = $rowsEdit['yearpg'];
$graduationt = $rowsEdit['graduationT'];
$pgraduation = $rowsEdit['Post_graduation'];
$fees = $rowsEdit['fees'];
$balance = $rowsEdit['balance'];
$action = "update";
}else
{
$_GET['action']="";
}

}


if(isset($_REQUEST['act']) && @$_REQUEST['act']=="1")
{
$errormsg = "<div class='alert alert-success'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Student record has been added!</div>";
}else if(isset($_REQUEST['act']) && @$_REQUEST['act']=="2")
{
$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Student record has been updated!</div>";
}
else if(isset($_REQUEST['act']) && @$_REQUEST['act']=="3")
{
$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Student has been deleted!</div>";
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
       <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BIRD Fees Management</title>
	
	
    <!-- BOOTSTRAP STYLES-->
    <link href="../../css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="../../css/font-awesome.css" rel="stylesheet" />
       <!--CUSTOM BASIC STYLES-->
    <link href="../../css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="../../css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	
	<link href="../../css/ui.css" rel="stylesheet" />
	<link href="../../css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" />	
	<link href="../../css/datepicker.css" rel="stylesheet" />	
	   <link href="../../css/datatable/datatable.css" rel="stylesheet" />
	   
	   
	
	  <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../../css/style.css">
   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../../js/jquery-1.10.2.js"></script>	
    <script type='text/javascript' src='../../js/jquery/jquery-ui-1.10.1.custom.min.js'></script>
   <script type="text/javascript" src="../../js/validation/jquery.validate.min.js"></script>
   <script src="../../js/dataTable/jquery.dataTables.min.js"></script>
	<script>
	function emp_detail(x){
			 if (x==0){
				document.getElementById("edetails").style.display = "block";
				
			 }else{
				document.getElementById("edetails").style.display = "none";
				
			 }
		 }
		 </script>
</head>
<body>

<?php include '../../components/owner_header.php'; ?>
        <div id="page-wrapper" ">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Manage Students  
						<?php
						echo (isset($_GET['action']) && @$_GET['action']=="add" || @$_GET['action']=="edit")?
						' <a href="student.php" class=" btn-success btn-sm pull-right" style="border-radius:0%">Go Back </a>':'<a href="student.php?action=add" class="btn-danger btn-sm pull-right" style="border-radius:0%"><i class="glyphicon glyphicon-plus"></i> Add New Student</a>';
						?>
						</h1>
                     
<?php

echo $errormsg;
?>
                    </div>
                </div>
				
				
				
        <?php 
		 if(isset($_GET['action']) && @$_GET['action']=="add" || @$_GET['action']=="edit")
		 {
		?>
		
			<script type="text/javascript" src="../../js/validation/jquery.validate.min.js"></script>
                <div class="row">
				
                    <div class="col-sm-10 col-sm-offset-1">
               <div class="panel panel-success">
                        <div class="panel-heading">
                           <?php echo ($action=="add")? "Add Student Details": "Edit Student Details"; ?>
                        </div>
						<form action="student.php" method="post" id="signupForm1" class="form-horizontal">
                        <div class="panel-body">
						<fieldset class="scheduler-border" >
						 <legend  class="scheduler-border">Personal Information:</legend>
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Full Name* </label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="sname" name="sname" value="<?php echo $name;?>"  />
								</div>
							</div>
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Father Name* </label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fname;?>"  />
								</div>
							</div>
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Gender* </label>
								<div class="col-sm-9">
									<select  class="form-control" id="gender" name="gender" >
									<option value="<?php echo ($action=="add")? "Select Gender": "$gender";?>" ><?php echo ($action=="add")? "Select Gender": "$gender";?></option>
								    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
			                        <option value="Other">Other</option>
									</select>
								</div>
							</div>
							
				
							
							
							
							
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Contact* </label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="contact" name="contact" value="<?php echo $contact_no;?>" maxlength="10" />
								</div>
							</div>
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Alternate Contact </label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="acontact" name="acontact" value="<?php echo $acontact_no;?>" maxlength="10" />
								</div>
							</div>
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Email Id </label>
								<div class="col-sm-9">
									
									<input type="text" class="form-control" id="emailid" name="emailid" value="<?php echo $emailid;?>"  />
								</div>
						    </div>
							
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Program* </label>
								<div class="col-sm-9">
									<select  class="form-control" id="program" name="program" >
									<option value="" >Select Program </option>
                                    <?php
									$sql = "select * from program where delete_status='0' order by program.program asc";
									$q = $conn->prepare($sql);
									$q->execute();
									
									while($r = $q->fetch(PDO::FETCH_ASSOC))
									{
									echo '<option value="'.$r['program'].'"  '.(($program==$r['program'])?'selected="selected"':'').'>'.$r['program'].'</option>';
									}
									?>									
									
									</select>
								</div>
						</div>
						
						
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">DOJ* </label>
								<div class="col-sm-9">
									<input type="text" class="form-control" placeholder="Date of Joining" id="doj" name="doj" value="<?php echo  ($doj!='')?date("Y-m-d", strtotime($doj)):'';?>" style="background-color: #fff;" readonly />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="Password">Address </label>
								<div class="col-sm-9">
	                        <textarea class="form-control" id="address" name="address"><?php echo $address;?></textarea >
								</div>
							</div>
							<div class="form-group">
							<label class="col-sm-3 control-label" for="Password">Select Pic </label>
								<div class="col-sm-9">
                                   <input type="file" name="image" accept="image/*"  class="form-control">
	                            </div>
							</div>
						 </fieldset>
						
						
													
							 <fieldset class="scheduler-border" >
						 <legend  class="scheduler-border">Educational Information:</legend>
							
							
							<div class="form-group">
				<label class="col-sm-3 control-label" for="Old">10<sup>TH</sup>	 * </label>	
                 <div class="col-sm-9">				
							<select  class="form-control" id="year10" name="year10" >
               <option value="<?php echo ($action=="add")? "Select Passing Year": "$year10";?>" ><?php echo ($action=="add")? "Select Passing Year": "$year10";?></option>
               <option value="2007">2007</option>
               <option value="2008">2008</option>
			   <option value="2009">2009</option>
			   <option value="2010">2010</option>
			   <option value="2011">2011</option>
			   <option value="2012">2012</option>
			   <option value="2013">2013</option>
			   <option value="2014">2014</option>
			   <option value="2015">2015</option>
			   <option value="2016">2016</option>
			   <option value="2017">2017</option>
			   <option value="2018">2018</option>
			   <option value="2019">2019</option>
			   <option value="2020">2020</option>
			   <option value="2021">2021</option>
			   <option value="2022">2022</option>
			   <option value="2023">2023</option>
			   <option value="2024">2024</option>
			   <option value="2025">2025</option>
			   <option value="2026">2026</option>
			   <option value="2027">2027</option>
			   <option value="2028">2028</option>
			   <option value="2029">2029</option>
			   <option value="2030">2030</option>
			   <option value="2031">2031</option>

            </select>
            	</div>
			</div>
					
				<div class="form-group">			
				<label class="col-sm-3 control-label" for="Old">12<sup>TH</sup> * </label>	
                 <div class="col-sm-9">				
							<select  class="form-control" id="year12" name="year12" >
               <option value="<?php echo ($action=="add")? "Select Passing Year": "$year12";?>" ><?php echo ($action=="add")? "Select Passing Year": "$year12";?></option>
               <option value="2007">2007</option>
               <option value="2008">2008</option>
			   <option value="2009">2009</option>
			   <option value="2010">2010</option>
			   <option value="2011">2011</option>
			   <option value="2012">2012</option>
			   <option value="2013">2013</option>
			   <option value="2014">2014</option>
			   <option value="2015">2015</option>
			   <option value="2016">2016</option>
			   <option value="2017">2017</option>
			   <option value="2018">2018</option>
			   <option value="2019">2019</option>
			   <option value="2020">2020</option>
			   <option value="2021">2021</option>
			   <option value="2022">2022</option>
			   <option value="2023">2023</option>
			   <option value="2024">2024</option>
			   <option value="2025">2025</option>
			   <option value="2026">2026</option>
			   <option value="2027">2027</option>
			   <option value="2028">2028</option>
			   <option value="2029">2029</option>
			   <option value="2030">2030</option>
			   <option value="2031">2031</option>

            </select>
            	</div>
							</div>
							
				<div class="form-group">
				<label class="col-sm-3 control-label" for="Old">Graduation * </label>	
                 <div class="col-sm-9">				
							<select  class="form-control" id="graduation" name="graduation" >
               <option value="<?php echo ($action=="add")? "Select Graduation": "$graduationt";?>" ><?php echo ($action=="add")? "Select Graduation": "$graduationt";?></option>
               <option value="BBA">BBA</option>
               <option value="BCA">BCA</option>
			   <option value="Btech">BTech</option>	
			   <option value="BSc">BSc</option>
			   <option value="BA">BA</option>
			   <option value="BCom">BCom</option>
			   <option value="Other">Other</option>
		    </select>
			</div>
			</div>
			    <div class="form-group">
				<label class="col-sm-3 control-label" for="Old">Graduation Year * </label>	
                 <div class="col-sm-9">				
							<select  class="form-control" id="yearg" name="yearg" >
               <option value="<?php echo ($action=="add")? "Select Passing Year": "$yearpg";?>" ><?php echo ($action=="add")? "Select Passing Year": "$yearpg";?></option>
               <option value="2007">2007</option>
               <option value="2008">2008</option>
			   <option value="2009">2009</option>
			   <option value="2010">2010</option>
			   <option value="2011">2011</option>
			   <option value="2012">2012</option>
			   <option value="2013">2013</option>
			   <option value="2014">2014</option>
			   <option value="2015">2015</option>
			   <option value="2016">2016</option>
			   <option value="2017">2017</option>
			   <option value="2018">2018</option>
			   <option value="2019">2019</option>
			   <option value="2020">2020</option>
			   <option value="2021">2021</option>
			   <option value="2022">2022</option>
			   <option value="2023">2023</option>
			   <option value="2024">2024</option>
			   <option value="2025">2025</option>
			   <option value="2026">2026</option>
			   <option value="2027">2027</option>
			   <option value="2028">2028</option>
			   <option value="2029">2029</option>
			   <option value="2030">2030</option>
			   <option value="2031">2031</option>

            </select>
            	</div>
				</div>
				
							
							<div class="form-group">
				<label class="col-sm-3 control-label" for="Old">Post Graduation* </label>	
                 <div class="col-sm-9">				
							<select  class="form-control" id="pgraduation" name="pgraduation" >
							<option value="<?php echo ($action=="add")? "Select Post Graduation": "$pgraduation";?>" ><?php echo ($action=="add")? "Select Post Graduation": "$pgraduation";?></option>
               <option value="MBA">MBA</option>
               <option value="MCA">MCA</option>
			   <option value="Mtech">MTech</option>
			   <option value="MSc">MSc</option>
			   <option value="MA">MA</option>
			   <option value="MCom">MCom</option>
			   <option value="Other">Other</option>
		    </select>
			</div>
			</div>
			    <div class="form-group">
				<label class="col-sm-3 control-label" for="Old">Post Graudation Year * </label>	
                 <div class="col-sm-9">				
				 <select  class="form-control" id="yearpg" name="yearpg" >
               <option value="<?php echo ($action=="add")? "Select Passing Year": "$yearpg";?>" ><?php echo ($action=="add")? "Select Passing Year": "$yearpg";?></option>
               <option value="2007">2007</option>
               <option value="2008">2008</option>
			   <option value="2009">2009</option>
			   <option value="2010">2010</option>
			   <option value="2011">2011</option>
			   <option value="2012">2012</option>
			   <option value="2013">2013</option>
			   <option value="2014">2014</option>
			   <option value="2015">2015</option>
			   <option value="2016">2016</option>
			   <option value="2017">2017</option>
			   <option value="2018">2018</option>
			   <option value="2019">2019</option>
			   <option value="2020">2020</option>
			   <option value="2021">2021</option>
			   <option value="2022">2022</option>
			   <option value="2023">2023</option>
			   <option value="2024">2024</option>
			   <option value="2025">2025</option>
			   <option value="2026">2026</option>
			   <option value="2027">2027</option>
			   <option value="2028">2028</option>
			   <option value="2029">2029</option>
			   <option value="2030">2030</option>
			   <option value="2031">2031</option>

            </select>
            	</div>
							</div>
			
							</fieldset>
							<fieldset class="scheduler-border" >
						 <legend  class="scheduler-border">Fee Information:</legend>
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Total Fees* </label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="fees" name="fees" value="<?php echo $fees;?>" <?php echo ($action=="update")?"disabled":""; ?>  />
								</div>
						</div>
						
						<?php
						if($action=="add")
						{
						?>
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Advance Fee* </label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="advancefees" name="advancefees" readonly   />
								</div>
						</div>
						<?php
						}
						?>
						
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Balance </label>
								<div class="col-sm-9">
									<input type="text" class="form-control"  id="balance" name="balance" value="<?php echo $balance;?>" disabled />
								</div>
						</div>
						
						<div class="form-group">
								<label class="col-sm-3 control-label" for="placed">Placement </label>
								<div class="col-sm-9">
								    <label  class="col-sm-1" for="placed" >Yes  </label>
									<input class="col-sm-1" type="radio" onclick="emp_detail(0)"  id="placed" name="placed" value="yes"  />
									<label  class="col-sm-1" for="placed">No  </label>
									<input class="col-sm-1" type="radio" onclick="emp_detail(1)" id="placed" name="placed" value="no"  />
								</div>
						</div>
						<fieldset class="scheduler-border"  id="edetails" style="display:none">
						<legend  class="scheduler-border">Employment Details:</legend>
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Date of Joining</label>
								<div class="col-sm-9">
									<input type="text" class="form-control"  id="newdoj" name="newdoj" value="<?php echo  ($newdoj!='')?date("Y-m-d", strtotime($newdoj)):'';?>"  />
								</div>
						</div>
						
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Company Name </label>
								<div class="col-sm-9">
									<input type="text" class="form-control"  id="cname" name="cname" value="" />
								</div>
						</div>
						
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Package </label>
								<div class="col-sm-9">
									<input type="text" class="form-control"  id="package" name="package" value="" />
								</div>
						</div>
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Total EMI </label>
								<div class="col-sm-9">
									<input type="text" class="form-control"  id="tot_emi" name="tot_emi" value="" />
								</div>
						</div>
						
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Cheque* </label>
								<div class="col-sm-9">
									<select  class="form-control" id="check1" name="check1" >
									<option value="Select Check Status">Select Cheque Status</option>
								    <option value="Received">Received</option>
                                    <option value="Pending">Pending</option>
			                        <option value="Returned">Returned</option>
									</select>
								</div>
							</div>
							</fieldset>
							
							<?php
						if($action=="add")
						{
						?>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="Password">Fee Remark </label>
								<div class="col-sm-9">
	                        <textarea class="form-control" id="remark" name="remark"><?php echo $remark;?></textarea >
								</div>
							</div>
						<?php
						}
						?>
							
							</fieldset>

						<div class="form-group">
								<div class="col-sm-8 col-sm-offset-2">
								<input type="hidden" name="registration_id" value="<?php echo $registration_id;?>">
								<input type="hidden" name="action" value="<?php echo $action;?>">
								
									<button type="submit" name="save" class="btn-success" style="border-radius:0%; padding: 6px 12px;margin-left: 230px;">Save </button>
								 
								   
								   
								</div>
							</div>
                         
                           
                           
                         
                           
                         </div>
							</form>
							
                        </div>
                            </div>
            
			
                </div>
               

			   
			   
		<script type="text/javascript">
		

		$( document ).ready( function () {			
			
		$( "#doj" ).datepicker({
dateFormat:"yy-mm-dd",
changeMonth: true,
changeYear: true,
yearRange: "1970:<?php echo date('Y');?>"
});	

$( "#newdoj" ).datepicker({
dateFormat:"yy-mm-dd",
changeMonth: true,
changeYear: true,
yearRange: "1970:<?php echo date('Y');?>"
});	
		

		
		if($("#signupForm1").length > 0)
         {
		 
		 <?php if($action=='add')
		 {
		 ?>
		 
			$( "#signupForm1" ).validate( {
				rules: {
					name: "required",
					doj: "required",
					emailid: "email",
					program: "required",
					
					
					contact: {
						required: true,
						digits: true
					},
					
					fees: {
						required: true,
						digits: true
					},
					
					
					advancefees: {
						required: true,
						digits: true
					},
				
					
				},
			<?php
			}else
			{
			?>
			
			$( "#signupForm1" ).validate( {
				rules: {
					name: "required",
					doj: "required",
					emailid: "email",
					program: "required",
					
					
					contact: {
						required: true,
						digits: true
					}
					
				},
			
			
			
			<?php
			}
			?>
				
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block" );

					// Add `has-feedback` class to the parent div.form-group
					// in order to add icons to inputs
					element.parents( ".col-sm-10" ).addClass( "has-feedback" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent( "label" ) );
					} else {
						error.insertAfter( element );
					}

					// Add the span element, if doesn't exists, and apply the icon classes to it.
					if ( !element.next( "span" )[ 0 ] ) {
						$( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );
					}
				},
				success: function ( label, element ) {
					// Add the span element, if doesn't exists, and apply the icon classes to it.
					if ( !$( element ).next( "span" )[ 0 ] ) {
						$( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
					}
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-10" ).addClass( "has-error" ).removeClass( "has-success" );
					$( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
				},
				unhighlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-10" ).addClass( "has-success" ).removeClass( "has-error" );
					$( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
				}
			} );
			
			}
			
		} );
		
		
		
		$("#fees").keyup( function(){
		$("#advancefees").val("");
		$("#balance").val(0);
		var fee = $.trim($(this).val());
		if( fee!='' && !isNaN(fee))
		{
		$("#advancefees").removeAttr("readonly");
		$("#balance").val(fee);
		$('#advancefees').rules("add", {
            max: parseInt(fee)
        });
		
		}
		else{
		$("#advancefees").attr("readonly","readonly");
		}
		
		});
		
		
		
		
		$("#advancefees").keyup( function(){
		
		var advancefees = parseInt($.trim($(this).val()));
		var totalfee = parseInt($("#fees").val());
		if( advancefees!='' && !isNaN(advancefees) && advancefees<=totalfee)
		{
		var balance = totalfee-advancefees;
		$("#balance").val(balance);
		
		}
		else{
		$("#balance").val(totalfee);
		}
		
		});
		
		
	</script>


			   
		<?php
		}else{
		?>
		
		 <link href="../../css/datatable/datatable.css" rel="stylesheet" />
		 
		
		 
		 
		<div class="panel panel-default">
                        <div class="panel-heading">
                            Manage Student  
                        </div>
                        <div class="panel-body">
                            <div class="table-sorting table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="tSortable22">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name | Contact</th>
											<th>Program</th>
                                            <th>Joined On</th>
                                            <th>Fees</th>
											<th>Balance</th>
											<th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$sql = "select * from users where delete_status='0'";
									$q = $conn->query($sql);
									$i=1;
									while($r = $q->fetch(PDO::FETCH_ASSOC))
									{
									
									echo '<tr '.(($r['balance']>0)?'class="primary"':'').'>
                                            <td>'.$i.'</td>
											<td>'.$r['name'].'<br/>'.$r['contact_no'].'</td>
											<td>'.$r['program'].''.'</td>
                                            <td>'.date("d M y", strtotime($r['doj'])).'</td>
                                            <td>'.$r['fees'].'</td>
											<td>'.$r['balance'].'</td>
											<td>
											
											

											<a href="student.php?action=edit&registration_id='.$r['registration_id'].'" class="btn-success btn-xs" style="border-radius:60px;"><span class="glyphicon glyphicon-edit"></span></a>
											
											<a onclick="return confirm(\'Are you sure you want to deactivate this record\');" href="student.php?action=delete&registration_id='.$r['registration_id'].'" class="btn-danger btn-xs" style="border-radius:60px;"><span class="glyphicon glyphicon-remove"></span></a> </td>
											
                                        </tr>';
										$i++;
									}
									?>
									
                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                     
	<script src="../../js/dataTable/jquery.dataTables.min.js"></script>
    
     <script>
         $(document).ready(function () {
             $('#tSortable22').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bInfo": false,
    "bAutoWidth": true });
	
         });
		 
		 
		
		 
	
    </script>
		
		<?php
		}
		?>
				
				
            
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->

    
   
  
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="../../js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="../../js/jquery.metisMenu.js"></script>
       <!-- CUSTOM SCRIPTS -->
    <script src="../../js/custom1.js"></script>
    
    
</body>
</html>
