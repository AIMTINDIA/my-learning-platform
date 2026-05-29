<?php $page='fees';
include '../components/connect.php';
if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

$amount='';
$tdate='';
$ttype='';
$errormsg= '';
$action='add';
$ename='';
$description='';
$id='';
if(isset($_POST['save']))
{


if($_POST['action']=="add")
 {
   $amount = filter_var($_POST['amount'],FILTER_SANITIZE_STRING);
   $ename = filter_var($_POST['ename'],FILTER_SANITIZE_STRING);
   $tdate = filter_var($_POST['tdate'],FILTER_SANITIZE_STRING);
   $description = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
   $ttype = filter_var($_POST['ttype'],FILTER_SANITIZE_STRING);
   $id = filter_var($_POST['id'],FILTER_SANITIZE_STRING);
   
   $sql = "insert into expenses(name,amount,ttype,tdate,description) values('$ename','$amount','$ttype','$tdate','$description') ";
   $conn->query($sql);
   
    echo '<script type="text/javascript">window.location="expense.php?act=1";</script>';

}else
  if($_POST['action']=="update")
 {
	 $amount = filter_var($_POST['amount'],FILTER_SANITIZE_STRING);
     $ename = filter_var($_POST['ename'],FILTER_SANITIZE_STRING);
     $tdate = filter_var($_POST['tdate'],FILTER_SANITIZE_STRING);
     $description = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
     $ttype = filter_var($_POST['ttype'],FILTER_SANITIZE_STRING);
	 $id = filter_var($_POST['id'],FILTER_SANITIZE_STRING);
	 $sql = "update expenses set  name='$ename',amount='$amount',ttype='$ttype',tdate='$tdate',description='$description' where id='$id'";
     $conn->query($sql);
 }
}

$action='add';

if(isset($_GET['action']) && $_GET['action']=="edit" ){
$id = isset($_GET['id'])?filter_var($_GET['id'],FILTER_SANITIZE_STRING):'';

$sqlEdit = $conn->prepare("SELECT * FROM expenses WHERE id='".$id."'");
$sqlEdit->execute();
if($sqlEdit->rowCount() > 0)
{
$rowsEdit = $sqlEdit->fetch(PDO::FETCH_ASSOC);
#extract($rowsEdit);
$ename = $rowsEdit['name'];
$amount = $rowsEdit['amount'];
$ttype = $rowsEdit['ttype'];
$tdate = $rowsEdit['tdate'];
$description = $rowsEdit['description'];
$action = "update";
}else
{
$_GET['action']="";
}

}







if(isset($_REQUEST['act']) && @$_REQUEST['act']=="1")
{
$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Expense has been Added</div>";
}

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BIRD Fees Management</title>
	<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
	
    <!-- BOOTSTRAP STYLES-->
    <link href="../css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="../css/font-awesome.css" rel="stylesheet" />
       <!--CUSTOM BASIC STYLES-->
    <link href="../css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="../css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	
	<link href="../css/ui.css" rel="stylesheet" />
	<link href="../css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" />	
	<link href="../css/datepicker.css" rel="stylesheet" />	
	   <link href="../css/datatable/datatable.css" rel="stylesheet" />
	   
	   
	
	  <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">
   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../js/jquery-1.10.2.js"></script>	
    <script type='text/javascript' src='../js/jquery/jquery-ui-1.10.1.custom.min.js'></script>
   <script type="text/javascript" src="../js/validation/jquery.validate.min.js"></script>
   <script src="../js/dataTable/jquery.dataTables.min.js"></script>
</head>

<?php include '../components/admin_header.php'; ?>

    <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Expense  
						<?php
						echo (isset($_GET['action']) && @$_GET['action']=="add" || @$_GET['action']=="edit")?
						' <a href="expense.php" class=" btn-success btn-sm pull-right" style="border-radius:0%">Go Back </a>':'<a href="expense.php?action=add" class="btn-danger btn-sm pull-right" style="border-radius:0%"><i class="glyphicon glyphicon-plus"></i> Add New Expense</a>';
						?>
						</h1>

                    </div>
                </div>
				
				
				
    	<?php
		echo $errormsg;
		?>
		
<!----   Expense Form   -----------> 


        <?php 
		 if(isset($_GET['action']) && @$_GET['action']=="add" || @$_GET['action']=="edit")
		 {
		?>
		
			<script type="text/javascript" src="../js/validation/jquery.validate.min.js"></script>
                <div class="row">
				
                    <div class="col-sm-10 col-sm-offset-1">
               <div class="panel panel-success">
                        <div class="panel-heading">
                           <?php echo ($action=="add")? "Add Expense Details": "Edit Expense Details"; ?>
                        </div>
						<form action="expense.php" method="post" id="signupForm1" class="form-horizontal">
                        <div class="panel-body">
						<fieldset class="scheduler-border" >
						 <legend  class="scheduler-border">Expense:</legend>
						
						
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Name* </label>
								<div class="col-sm-9">
									<select  class="form-control" id="ename" name="ename" >
									<option value="<?php echo ($action=="add")? "Select Name": "$ename";?>"> <?php echo ($action=="add")? "Select Name": "$ename";?></option>
								    <option value="Manjeet">Manjeet</option>
                                    <option value="Anil">Anil</option>
			                        <option value="Other">Other</option>
									</select>
								</div>
							</div>
						
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Amount* </label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="amount" name="amount"  value="<?php echo $amount;?>" />
								</div>
						</div>
						
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Transaction Type* </label>
								<div class="col-sm-9">
									<select  class="form-control" id="ttype" name="ttype" >
									<option value="<?php echo ($action=="add")? "Select Transaction Type": "$ttype";?>"><?php echo ($action=="add")? "Select Transaction Type": "$ttype";?></option>
								    <option value="cash">Cash</option>
                                    <option value="online">Online</option>
			                        <option value="other">Other</option>
									</select>
								</div>
							</div>
						
						<div class="form-group">
								<label class="col-sm-3 control-label" for="Old">Transaction Date* </label>
								<div class="col-sm-9">
									<input type="text" class="form-control" placeholder="Date of Transaction" id="tdate" name="tdate" value="<?php echo  ($tdate!='')?date("Y-m-d", strtotime($tdate)):'';?>" style="background-color: #fff;" readonly />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="Password">Description </label>
								<div class="col-sm-9">
	                        <textarea class="form-control" id="description" name="description"><?php echo $description ;?></textarea >
								</div>
							</div>
							
						 </fieldset>
						
						
													
							
						
							

						<div class="form-group">
								<div class="col-sm-8 col-sm-offset-2">
								<input type="hidden" name="id" value="<?php echo $id;?>">
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
			
		$( "#tdate" ).datepicker({
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
		});

</script>

<?php
		}else{
		?> 


<!----  End Expense Form ----------->   
		

        <div class="row" style="margin-bottom:20px;">
        <div class="col-md-12">
        <fieldset class="scheduler-border" >
            <legend  class="scheduler-border">Search:</legend>
        <form class="form-inline" role="form" id="searchform">
          <div class="form-group">
            <label for="email">Name</label>
            <input type="text" class="form-control" id="student" name="student">
          </div>
          
           <div class="form-group">
            <label for="email"> Monthly Expense </label>
            <input type="text" class="form-control" id="doj" name="doj" >
          </div>
          
         
          
           <button type="button" class="btn-success btn-sm" style="border-radius:0%" id="find" > Filter </button>
          <button type="reset" class="btn-danger btn-sm" style="border-radius:0%" id="clear" > Reset </button>
        </form>
        </fieldset>
        
        </div>
        </div>
        
<script type="text/javascript">
$(document).ready( function() {
    $("#doj").datepicker({
         
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'mm/yy',
        onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
        }
    });
    $("#doj").focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });
		$('#student').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : 'ajx.php',
		      			dataType: "json",
						data: {
						   name_startsWith: request.term,
						   type: 'studentname'
						},
						 success: function( data ) {
						 
							 response( $.map( data, function( item ) {
							
								return {
									label: item,
									value: item
								}
							}));
						}
						
						
						
		      		});
		      	}
        });
	    $('#find').click(function () {
            mydatatable();
                    });


        $('#clear').click(function () {
        
            $('#searchform')[0].reset();
            mydatatable();
        });
		
		function mydatatable()
        {
        
              $("#subjectresult").html('<table class="table table-striped table-bordered table-hover" id="tSortable22"><thead><tr><th>Name</th><th>Amount</th><th>Transaction Type</th><th>Date</th><th>Description</th><th>Action</th></tr></thead><tbody></tbody></table>');
			  
			    $("#tSortable22").dataTable({
							      'sPaginationType' : 'full_numbers',
							     "bLengthChange": false,
                  "bFilter": false,
                  "bInfo": false,
							       'bProcessing' : true,
							       'bServerSide': true,
							       'sAjaxSource': "owner/placed_datatable.php?"+$('#searchform').serialize()+"&type=expense",
							       'aoColumnDefs': [{
                                   'bSortable': false,
                                   'aTargets': [-1] /* 1st one, start by the right */
                                                }]
                                   });


         }
		 
		 $("#tSortable22").dataTable({
			     
                  'sPaginationType' : 'full_numbers',
				  "bLengthChange": false,
                  "bFilter": false,
                  "bInfo": false,
                  
                  'bProcessing' : true,
				  'bServerSide': true,
                  'sAjaxSource': "owner/placed_datatable.php?type=expense",
				  
			      'aoColumnDefs': [{
                  'bSortable': false,
                  'aTargets': [-1] /* 1st one, start by the right */
              }]
            });
});



</script>

<style>
#doj .ui-datepicker-calendar
{
display:none;
}

</style>
		
		<div class="panel panel-default">
                        <div class="panel-heading">
                            Manage Expense 
                        </div>
                        <div class="panel-body">
                            <div class="table-sorting table-responsive" id="subjectresult">
                                <table class="table table-striped table-bordered table-hover" id="tSortable22">
                                    <thead>
                                        <tr>
                                          
                                            <th>Name</th>                                            
                                            <th>Amount</th>
											<th>Transaction Type</th>
											<th>Date</th>
											<th>Description</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
								    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
  

	
	<!-------->
	
	<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
         <!-- <button type="button" class="close" data-dismiss="modal" style="color:red;">&times;</button> -->
          <h4 class="modal-title">Collect Fee</h4>
        </div>
        <div class="modal-body" id="formcontent">
        
        </div>
      
      </div>
    </div>
  </div>

	
    <!--------->
    			
            
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
   
  
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="../js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="../js/jquery.metisMenu.js"></script>
       <!-- CUSTOM SCRIPTS -->
    <script src="../js/custom1.js"></script>
    <script src="../js/script.js"></script>
<?php
		}
		?> 
		
		  		

</body>
</html>

