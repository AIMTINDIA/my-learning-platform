<?php $page='inact';
include("../../components/connect.php");
#include("php/checklogin.php");

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





#if(isset($_GET['action']) && $_GET['action']=="delete"){

#$conn->query("DELETE FROM users WHERE registration_id='".$_GET['registration_id']."'");	
#header("location: student.php?act=3");

#}

#if(isset($_GET['action']) && $_GET['action']=="approve"){

 #   $conn->query("UPDATE users set delete_status = '0'  WHERE registration_id='".$_GET['registration_id']."'");	
  #  header("location: inactivestd.php?act=2");
    
   # }



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
	
</head>
<?php include '../../components/owner_header.php'; ?>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Placed Students</h1>
                     
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
                                            <th>Company</th>
                                            <th>Joined On</th>
                                            <th>Package</th>
											<th>PEMI</th>
											<th>Cheque Status</th>
											<th>Change Cheque Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$sql = "select u.balance,p.emi,u.registration_id,u.name,u.contact_no,p.company,p.package,p.cheque,p.doj from placement p ,users u where p.registration_id=u.registration_id";
									$q = $conn->query($sql);
									$i=1;
									while($r = $q->fetch(PDO::FETCH_ASSOC))
									{
									
									echo '<tr '.(($r['balance']>0)?'class="primary"':'').'>
                                            <td>'.$i.'</td>
                                            <td>'.$r['name'].'<br/>'.$r['contact_no'].'</td>
                                            <td>'.$r['company'].'</td>
                                            <td>'.date("d M y", strtotime($r['doj'])).'</td>
                                            <td>'.$r['package'].'</td>
											<td>'.$r['emi'].'</td>
											<td>'.$r['cheque'].'</td>
											<td>
											
											<a onclick="return confirm(\'Are you sure Candidate submited the Cheques ?\');" href="placed_inactivestd.php?action=approve&registration_id='.$r['registration_id'].'" class="btn-success btn-xs" style="border-radius:60px;"><span class="glyphicon glyphicon-ok"></span></a>
											
											<a onclick="return confirm(\'Are you sure and want to return the cheques to Candidate ?\');" href="placed_inactivestd.php?action=delete&registration_id='.$r['registration_id'].'" class="btn-danger btn-xs" style="border-radius:60px;"><span class="glyphicon glyphicon-trash"></span></a> </td>
											
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
