<?php
include '../../components/connect.php';

if(isset($_POST['req']) && $_POST['req']=='1') 
{

$sid = (isset($_POST['student']))?filter_var($_POST['student'],FILTER_SANITIZE_STRING):'';

 $sql = "select s.registration_id,s.name,p.total_emi-p.emi as emi_pending,p.fees,s.contact_no,b.program,s.doj from users as s,program as b, placement as p where b.program=s.program and s.registration_id=p.registration_id and  s.delete_status='2' and s.registration_id='".$sid."'";
 $q = $conn->prepare($sql);
 $q->execute();
 #$row = $q->fetch(PDO::FETCH_ASSOC);
#$q = $conn->query($sql);
if($q->rowCount() > 0)
{

$res = $q->fetch(PDO::FETCH_ASSOC);
echo '  <form class="form-horizontal" id ="signupForm1" action="placed_fees.php" method="post">
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Name:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" disabled  value="'.$res['name'].'" >
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Contact:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" disabled  value="'.$res['contact_no'].'" />
    </div>
  </div>
  
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Last EMI Paid:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="totalfee" id="totalfee"   value="'.$res['fees'].'"  />
    </div>
  </div>
  
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">EMI Pending:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="balance"  id="balance" value="'.$res['emi_pending'].'"  />
	  <input type="hidden" value="'.$res['registration_id'].'" name="sid">
    </div>
  </div>
  
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Paid:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="paid"  id="paid"  />
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Date:</label>
    <div class="col-sm-10">
	
      <input type="text" class="form-control" name="submitdate"  id="submitdate" style="background:#fff;"  readonly />
    </div>
  </div>
  
  
   <div class="form-group">
    <label class="control-label col-sm-2" for="email">Remark:</label>
    <div class="col-sm-10">
      <textarea class="form-control" name="transaction_remark" id="transaction_remark"></textarea>
    </div>
  </div>
 
 
    <div class="form-group">
    <label class="control-label col-sm-2" for="email">Receiver:</label>
    <div class="col-sm-10">
	  <select  class="form-control" id="receive" name="receive" >
									
								    <option value="Anil">Anil</option>
                                    <option value="Manjeet">Manjeet</option>
			                        
									</select>
    </div>
  </div>
 
 
  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn-success" style="border-radius:0%;padding: 6px 12px" name="save">Submit</button>
      <button type="button" class="btn-danger" style="border-radius:0% ;padding: 6px 12px "  onclick="closed()" data-dismiss="modal">Close</button>
	</div>
  </div>
</form>

<script type="text/javascript">

function closed()  {
             let sideBar = document.querySelector(".side-bar");
			 console.log(sideBar);
             sideBar.classList.toggle("active");
		 }
</script>		 

<script type="text/javascript">		 
$(document).ready( function() {
$("#submitdate").datepicker( {
        changeMonth: true,
        changeYear: true,
       
        dateFormat: "yy-mm-dd",
      
    });
	
	
///////////////////////////

$( "#signupForm1" ).validate( {
				rules: {
					submitdate: "required",
					
					paid: {
						required: true,
						digits: true,
						
					}	
					
					
				},
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

					
					if ( !element.next( "span" )[ 0 ] ) {
						$( "<span class=\'glyphicon glyphicon-remove form-control-feedback\'></span>" ).insertAfter( element );
					}
				},
				success: function ( label, element ) {
					if ( !$( element ).next( "span" )[ 0 ] ) {
						$( "<span class=\'glyphicon glyphicon-ok form-control-feedback\'></span>" ).insertAfter( $( element ) );
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


//////////////////////////	
	
	
	
});

</script>
';

}else
{
echo "Something Goes Wrong! Try After sometime.";
}


}

if(isset($_POST['req']) && $_POST['req']=='2') 
{

$sid = (isset($_POST['student']))?filter_var($_POST['student'],FILTER_SANITIZE_STRING):'';
$sql = "select paid,submitdate,transaction_remark,receiver,emi from placed_transaction  where stdid='".$sid."'";
$fq = $conn->prepare($sql);
$fq->execute();
#$fq = $conn->query($sql);
if($fq->rowCount() > 0)
{


 $sql = "select s.registration_id,s.name,p.total_emi-p.emi as emi_pending,p.total_emi,s.contact_no,b.program,s.doj from users as s,program as b,placement p where b.program=s.program and s.registration_id=p.registration_id and s.registration_id='".$sid."'";
 $sq = $conn->prepare($sql);
 $sq->execute();
#$sq = $conn->query($sql);
$sr = $sq->fetch(PDO::FETCH_ASSOC);

echo '
<h4>Student Info : '.$sr['registration_id'].'</h4>
<div class="table-responsive">
<table class="table table-bordered">
<tr>
<th>Full Name</th>
<td>'.$sr['name'].'</td>
<th>Program</th>
<td>'.$sr['program'].'</td>
</tr>
<tr>
<th>Contact</th>
<td>'.$sr['contact_no'].'</td>
<th>Joined On</th>
<td>'.date("d-m-Y", strtotime($sr['doj'])).'</td>
</tr>


</table>
</div>
';


echo '
<h4>Fee Info</h4>
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
      <tr>
        <th>Date</th>
        <th>Paid</th>
        <th>Remarks</th>
		<th>EMI</th>
		<th>Receiver</th>
      </tr>
    </thead>
    <tbody>';
	$totapaid = 0;
while($res = $fq->fetch(PDO::FETCH_ASSOC))
{
$totapaid+=$res['paid'];
        echo '<tr>
        <td>'.date("d-m-Y", strtotime($res['submitdate'])).'</td>
        <td>'.$res['paid'].'</td>
        <td>'.$res['transaction_remark'].'</td>
		<td>'.$res['emi'].'</td>
		<td>'.$res['receiver'].'</td>
      </tr>' ;
}
      
echo '	  
    </tbody>
  </table>
 </div> 
 
<table style="width:200px;" >
<tr>
<th>Total EMI: 
</th>
<td>'.$sr['total_emi'].'
</td>
</tr>

<tr>
<th>Total Paid: 
</th>
<td>'.'Rs. '.$totapaid.'
</td>
</tr>

<tr>
<th>Pending EMI: 
</th>
<td>'.$sr['emi_pending'].'
</td>
</tr>
</table>
 ';


 }
else
{
echo 'No fees submit.';
}
 
}
		
		 
			
			
	

?>