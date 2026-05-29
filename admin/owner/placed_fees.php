<?php $page='fees';
include '../../components/connect.php';
if(isset($_COOKIE['owner_id'])){
   $owner_id = $_COOKIE['owner_id'];
}else{
   $owner_id = '';
   header('location:login.php');
}

$errormsg= '';
if(isset($_POST['save']))
{
$paid = filter_var($_POST['paid'],FILTER_SANITIZE_STRING);
$receiver = filter_var($_POST['receive'],FILTER_SANITIZE_STRING);
$submitdate = filter_var($_POST['submitdate'],FILTER_SANITIZE_STRING);
$transaction_remark = filter_var($_POST['transaction_remark'],FILTER_SANITIZE_STRING);
$sid = filter_var($_POST['sid'],FILTER_SANITIZE_STRING);





$pemi = $conn->query("SELECT emi FROM placement where registration_id = '$sid'");
$x = $pemi->fetch(PDO::FETCH_ASSOC);
$emi = $x['emi'] + 1;

$sql = "insert into placed_transaction(stdid,submitdate,transaction_remark,paid,receiver,emi) values('$sid','$submitdate','$transaction_remark','$paid','$receiver','$emi') ";
$conn->query($sql);

$sql = "SELECT sum(paid) as totalpaid FROM placed_transaction WHERE stdid = '$sid'";
$tpq = $conn->query($sql);
$tpr = $tpq->fetch(PDO::FETCH_ASSOC);
$totalpaid = $tpr['totalpaid'];
$tbalance = $totalpaid;

$sql = "update placement set balance='$tbalance',emi='$emi',fees='$paid',previous_emi_date='$submitdate',next_emi_date='$submitdate'+interval 20 day where registration_id = '$sid'";
$conn->query($sql);



 echo '<script type="text/javascript">window.location="placed_fees.php?act=1";</script>';
}


if(isset($_REQUEST['act']) && @$_REQUEST['act']=="1")
{
$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Fees has been submitted</div>";
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
                        <h1 class="page-head-line">Fees  
						
						</h1>

                    </div>
                </div>
				
				
				
    	<?php
		echo $errormsg;
		?>
		
		

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
            <label for="email">Contact NO</label>
            <input type="text" class="form-control" id="contactno" name="contactno">
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
        
              $("#subjectresult").html('<table class="table table-striped table-bordered table-hover" id="tSortable22"><thead><tr><th>Name/Contact</th><th>Package</th><th>Balance</th><th>PEMI</th><th>DOJ</th><th>Action</th></tr></thead><tbody></tbody></table>');
			  
			    $("#tSortable22").dataTable({
							      'sPaginationType' : 'full_numbers',
							     "bLengthChange": false,
                  "bFilter": false,
                  "bInfo": false,
							       'bProcessing' : true,
							       'bServerSide': true,
							       'sAjaxSource': "placed_datatable.php?"+$('#searchform').serialize()+"&type=feesearch",
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
                  'sAjaxSource': "placed_datatable.php?type=feesearch",
				  
			      'aoColumnDefs': [{
                  'bSortable': false,
                  'aTargets': [-1] /* 1st one, start by the right */
              }]
            });
});

function GetFeeForm(sid)
{

$.ajax({
            type: 'post',
            url: 'placedgetfeeform.php',
            data: {student:sid,req:'1'},
            success: function (data) {
              $('#formcontent').html(data);
			  $("#myModal").modal({backdrop: "static"});
            }
          });
      let sideBar = document.querySelector('.side-bar');


       sideBar.classList.toggle('active');

}

</script>

<style>
#doj .ui-datepicker-calendar
{
display:none;
}

</style>
		
		<div class="panel panel-default">
                        <div class="panel-heading">
                            Manage Fees  
                        </div>
                        <div class="panel-body">
                            <div class="table-sorting table-responsive" id="subjectresult">
                                <table class="table table-striped table-bordered table-hover" id="tSortable22">
                                    <thead>
                                        <tr>
                                          
                                            <th>Name/Contact</th>                                            
                                            <th>Package</th>
											<th>Balance</th>
											<th>PEMI</th>
											<th>DOJ</th>
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
    <script src="../../js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="../../js/jquery.metisMenu.js"></script>
       <!-- CUSTOM SCRIPTS -->
    <script src="../../js/custom1.js"></script>
    <script src="../../js/script.js"></script>


</body>
</html>

