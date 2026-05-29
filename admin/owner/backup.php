<?php
$connect = mysqli_connect('localhost','telecall_admin','Amiara@201925','telecall_bird_management');
$expense = '';
$tutors = '';
$bookmarks='';
$comments='';
$contacts='';
$contents='';
$fees_transactions='';
$likes='';
$otps='';
$owners='';
$placed_transactions='';
$placements='';
$playlists='';
$programs='';
$users='';



if(isset($_POST["expenses_Backup"]))
{
	mysqli_query($connect,"update backup set backup_date=date_format(CURRENT_DATE(), '%d-%m-%Y') where table_name='expenses'");
	$sql = "select * from expenses order by id desc";
	$result = mysqli_query($connect,$sql);
	if(mysqli_num_rows($result)>0)
	{
		$expense .= '<table class="table" bordered="1">
                    <tr>
                        <th>Id</th>
						<th>Name</th>
                        <th>Amount</th>
                        <th>Transacntion_Type</th>
                        <th>Transaction_Date</th>
                        <th>Description</th>	
                    </tr>';
        while( $row = mysqli_fetch_array($result)){
			$expense .= '<tr>
			                <td>'.$row["id"].'</td>
						    <td>'.$row["name"].'</td>
                            <td>'.$row["amount"].'</td>
                            <td>'.$row["ttype"].'</td>
                            <td>'.$row["tdate"].'</td>
                            <td>'.$row["description"].'</td>
		                </tr>';
			
		}
		$expense .= '</table>';
		header("Content-Type: application/xls");
		header("Content-Disposition: attachement; filename=expenses_download.xls");
		
		echo $expense;
    }
}

if(isset($_POST["tutors_Backup"]))
{	
    mysqli_query($connect,"update backup set backup_date=date_format(CURRENT_DATE(), '%d-%m-%Y') where table_name='tutors'");
	$sql = "select * from tutors";
	$tutor = mysqli_query($connect,$sql);
	if(mysqli_num_rows($tutor)>0)
	{
		$tutors .= '<table class="table" bordered="1">
                    <tr>
                        <th>Id</th>
						<th>Name</th>
                        <th>profession</th>
                        <th>email</th>
                        <th>password</th>
                        <th>image</th>	
                    </tr>';
        while( $row = mysqli_fetch_array($tutor)){
			$tutors .= '<tr>
			                <td>'.$row["id"].'</td>
						    <td>'.$row["name"].'</td>
                            <td>'.$row["profession"].'</td>
                            <td>'.$row["email"].'</td>
                            <td>'.$row["password"].'</td>
                            <td>'.$row["image"].'</td>
		                </tr>';
			
		}
		$tutors .= '</table>';
		header("Content-Type: application/xls");
		header("Content-Disposition: attachement; filename=tutor_download.xls");
		
		
		
		echo $tutors;
    }
}	



if(isset($_POST["bookmark_Backup"]))
{	
    mysqli_query($connect,"update backup set backup_date=date_format(CURRENT_DATE(), '%d-%m-%Y') where table_name='bookmark'");
	$sql = "select * from bookmark order by user_id desc";
	$bookmark = mysqli_query($connect,$sql);
	if(mysqli_num_rows($bookmark)>0)
	{
		$bookmarks .= '<table class="table" bordered="1">
                    <tr>
                        <th>User_id</th>
						<th>Playlist_id</th>   	
                    </tr>';
        while( $row = mysqli_fetch_array($bookmark)){
			$bookmarks .= '<tr>
			                <td>'.$row["user_id"].'</td>
						    <td>'.$row["playlist_id"].'</td>                            
		                </tr>';
			
		}
		$bookmarks .= '</table>';
		header("Content-Type: application/xls");
		header("Content-Disposition: attachement; filename=bookmark_download.xls");
		
		
		
		echo $bookmarks;
    }
}	



if(isset($_POST["comments_Backup"]))
{	
    mysqli_query($connect,"update backup set backup_date=date_format(CURRENT_DATE(), '%d-%m-%Y') where table_name='comments'");
	$sql = "select * from comments";
	$comment1 = mysqli_query($connect,$sql);
	if(mysqli_num_rows($comment1)>0)
	{
		$comments .= '<table class="table" bordered="1">
                    <tr>
                        <th>Id</th>
						<th>Content_id</th>  
                        <th>User_id</th>
						<th>Tutor_id</th> 
                        <th>Comment</th>
						<th>date</th> 						
                    </tr>';
        while( $row = mysqli_fetch_array($comment1)){
			$comments .= '<tr>
			                <td>'.$row["id"].'</td>
						    <td>'.$row["content_id"].'</td>  
			                <td>'.$row["user_id"].'</td>
						    <td>'.$row["tutor_id"].'</td>  
			                <td>'.$row["comment"].'</td>
						    <td>'.$row["date"].'</td>  							
		                </tr>';
			
		}
		$comments .= '</table>';
		header("Content-Type: application/xls");
		header("Content-Disposition: attachement; filename=comment_download.xls");
		
		
		
		echo $comments;
    }
}



if(isset($_POST["contact_Backup"]))
{	
    mysqli_query($connect,"update backup set backup_date=date_format(CURRENT_DATE(), '%d-%m-%Y') where table_name='contact'");
	$sql = "select * from contact";
	$contact = mysqli_query($connect,$sql);
	if(mysqli_num_rows($contact)>0)
	{
		$contacts .= '<table class="table" bordered="1">
                    <tr>
                        <th>Name</th>
						<th>Email</th>  
                        <th>Number</th>
						<th>Message</th>  						
                    </tr>';
        while( $row = mysqli_fetch_array($contact)){
			$contacts .= '<tr>
			                <td>'.$row["name"].'</td>
						    <td>'.$row["email"].'</td>  
			                <td>'.$row["number"].'</td>
						    <td>'.$row["message"].'</td>  			                 							
		                </tr>';
			
		}
		$contacts .= '</table>';
		header("Content-Type: application/xls");
		header("Content-Disposition: attachement; filename=contact_download.xls");
		
		
		
		echo $contacts;
    }
}

if(isset($_POST["content_Backup"]))
{	
    mysqli_query($connect,"update backup set backup_date=date_format(CURRENT_DATE(), '%d-%m-%Y') where table_name='content'");
	$sql = "select * from content";
	$content = mysqli_query($connect,$sql);
	if(mysqli_num_rows($content)>0)
	{
		$contents .= '<table class="table" bordered="1">
                    <tr>
                        <th>Id</th>
						<th>Tutor_id</th>  
                        <th>Playlist_id</th>
						<th>Title</th>  
                        <th>Description</th>
						<th>Video</th> 
                        <th>Thumb</th>
						<th>Date</th>  	
						<th>Status</th> 						
                    </tr>';
        while( $row = mysqli_fetch_array($content)){
			$contents .= '<tr>
			                <td>'.$row["id"].'</td>
						    <td>'.$row["tutor_id"].'</td>  
			                <td>'.$row["playlist_id"].'</td>
						    <td>'.$row["title"].'</td>  
						    <td>'.$row["description"].'</td>
						    <td>'.$row["video"].'</td> 
			                <td>'.$row["thumb"].'</td>
						    <td>'.$row["date"].'</td> 
							<td>'.$row["status"].'</td> 
		                </tr>';
			
		}
		$contents .= '</table>';
		header("Content-Type: application/xls");
		header("Content-Disposition: attachement; filename=contents_download.xls");
		
		
		
		echo $contents;
    }
}


if(isset($_POST["fees_transaction_Backup"]))
{	
    mysqli_query($connect,"update backup set backup_date=date_format(CURRENT_DATE(), '%d-%m-%Y') where table_name='fees_transaction'");
	$sql = "select f.*,u.name from fees_transaction f join users u on f.stdid=u.registration_id where submitdate>='2024-08-01' order by f.id desc;";
	$fees_transaction = mysqli_query($connect,$sql);
	if(mysqli_num_rows($fees_transaction)>0)
	{
		$fees_transactions .= '<table class="table" bordered="1">
                    <tr>
                        <th>Id</th>
						<th>Student_id</th>  
                        <th>Paid</th>
						<th>SubmitDate</th>  
                        <th>Transaction Remark</th> 						
                    </tr>';
        while( $row = mysqli_fetch_array($fees_transaction)){
			$fees_transactions .= '<tr>
			                <td>'.$row["id"].'</td>
						    <td>'.$row["stdid"].'</td>  
			                <td>'.$row["paid"].'</td>
						    <td>'.$row["submitdate"].'</td>  
						    <td>'.$row["transaction_remark"].'</td>
		                </tr>';
			
		}
		$fees_transactions .= '</table>';
		header("Content-Type: application/xls");
		header("Content-Disposition: attachement; filename=fees_transactions_download.xls");
		
		
		
		echo $fees_transactions;
    }
}


if(isset($_POST["likes_Backup"]))
{	
    mysqli_query($connect,"update backup set backup_date=date_format(CURRENT_DATE(), '%d-%m-%Y') where table_name='likes'");
	$sql = "select * from likes";
	$like = mysqli_query($connect,$sql);
	if(mysqli_num_rows($like)>0)
	{
		$likes .= '<table class="table" bordered="1">
                    <tr>
                        <th>User_id</th>
						<th>Tutor_id</th>   
                        <th>Content_id</th>						
                    </tr>';
        while( $row = mysqli_fetch_array($like)){
			$likes .= '<tr>
			                <td>'.$row["user_id"].'</td>
						    <td>'.$row["tutor_id"].'</td>     
						    <td>'.$row["content_id"].'</td>   							
		                </tr>';
			
		}
		$likes .= '</table>';
		header("Content-Type: application/xls");
		header("Content-Disposition: attachement; filename=likes_download.xls");
		
		
		
		echo $likes;
    }
}

if(isset($_POST["otp_Backup"]))
{	
    mysqli_query($connect,"update backup set backup_date=date_format(CURRENT_DATE(), '%d-%m-%Y') where table_name='otp'");
	$sql = "select * from otp";
	$otp = mysqli_query($connect,$sql);
	if(mysqli_num_rows($otp)>0)
	{
		$otps .= '<table class="table" bordered="1">
                    <tr>
                        <th>Id</th>
						<th>Email</th>  
                        <th>OTP</th>
						<th>User_Type</th>  						
                    </tr>';
        while( $row = mysqli_fetch_array($otp)){
			$otps .= '<tr>
			                <td>'.$row["id"].'</td>
						    <td>'.$row["email"].'</td>  
			                <td>'.$row["otp"].'</td>
						    <td>'.$row["user_type"].'</td>  			                 							
		                </tr>';
			
		}
		$otps .= '</table>';
		header("Content-Type: application/xls");
		header("Content-Disposition: attachement; filename=otp_download.xls");
		
		
		
		echo $otps;
    }
}




if(isset($_POST["owners_Backup"]))
{	
    mysqli_query($connect,"update backup set backup_date=date_format(CURRENT_DATE(), '%d-%m-%Y') where table_name='owners'");
	$sql = "select * from owners";
	$owner = mysqli_query($connect,$sql);
	if(mysqli_num_rows($owner)>0)
	{
		$owners .= '<table class="table" bordered="1">
                    <tr>
                        <th>Id</th>
						<th>Name</th>  
                        <th>Email</th> 						
                    </tr>';
        while( $row = mysqli_fetch_array($owner)){
			$owners .= '<tr>
			                <td>'.$row["id"].'</td>
						    <td>'.$row["name"].'</td>  
			                <td>'.$row["email"].'</td>			                 							
		                </tr>';
			
		}
		$owners .= '</table>';
		header("Content-Type: application/xls");
		header("Content-Disposition: attachement; filename=owners_download.xls");
		
		
		
		echo $owners;
    }
}





if(isset($_POST["placed_transaction_Backup"]))
{	
    mysqli_query($connect,"update backup set backup_date=date_format(CURRENT_DATE(), '%d-%m-%Y') where table_name='placed_transaction'");
	$sql = "select * from placed_transaction  where submitdate>='2024-08-01'";
	$placed_transaction = mysqli_query($connect,$sql);
	if(mysqli_num_rows($placed_transaction)>0)
	{
		$placed_transactions .= '<table class="table" bordered="1">
                    <tr>
                        <th>Id</th>
						<th>Student_id</th>  
                        <th>Paid</th> 	
                        <th>SubmitDate</th>
						<th>Transaction Remark</th>  
                        <th>EMI</th> 
                        <th>Receiver</th> 						
                    </tr>';
        while( $row = mysqli_fetch_array($placed_transaction)){
			$placed_transactions .= '<tr>
			                <td>'.$row["id"].'</td>
						    <td>'.$row["stdid"].'</td>  
			                <td>'.$row["paid"].'</td>	
                            <td>'.$row["submitdate"].'</td>
						    <td>'.$row["transaction_remark"].'</td>  
			                <td>'.$row["emi"].'</td>	
                            <td>'.$row["receiver"].'</td>						
		                </tr>';
			
		}
		$placed_transactions .= '</table>';
		header("Content-Type: application/xls");
		header("Content-Disposition: attachement; filename=placed_transaction_download.xls");
		
		
		
		echo $placed_transactions;
    }
}


if(isset($_POST["placement_Backup"]))
{	
    mysqli_query($connect,"update backup set backup_date=date_format(CURRENT_DATE(), '%d-%m-%Y') where table_name='placement'");
	$sql = "select * from placement order by id desc";
	$placement = mysqli_query($connect,$sql);
	if(mysqli_num_rows($placement)>0)
	{
		$placements .= '<table class="table" bordered="1">
                    <tr>
                        <th>Id</th>
						<th>Registration_id</th>  
                        <th>DOJ</th>
						<th>Company</th>  
                        <th>Total_EMI</th>
						<th>EMI</th> 
                        <th>Previous_EMI_Date</th>
						<th>Next_EMI_Date</th>  	
						<th>Fees</th> 	
                        <th>Balance</th>
						<th>Cheque</th>  	
						<th>Package</th> 						
                    </tr>';
        while( $row = mysqli_fetch_array($placement)){
			$placements .= '<tr>
			                <td>'.$row["id"].'</td>
						    <td>'.$row["registration_id"].'</td>  
			                <td>'.$row["doj"].'</td>
						    <td>'.$row["company"].'</td>  
						    <td>'.$row["total_emi"].'</td>
						    <td>'.$row["emi"].'</td> 
			                <td>'.$row["previous_emi_date"].'</td>
						    <td>'.$row["next_emi_date"].'</td> 
							<td>'.$row["fees"].'</td> 
			                <td>'.$row["balance"].'</td>
						    <td>'.$row["cheque"].'</td> 
							<td>'.$row["package"].'</td> 
		                </tr>';
			
		}
		$placements .= '</table>';
		header("Content-Type: application/xls");
		header("Content-Disposition: attachement; filename=placement_download.xls");
		
		
		
		echo $placements;
    }
}


if(isset($_POST["playlist_Backup"]))
{	
    mysqli_query($connect,"update backup set backup_date=date_format(CURRENT_DATE(), '%d-%m-%Y') where table_name='playlist'");
	$sql = "select * from playlist";
	$playlist = mysqli_query($connect,$sql);
	if(mysqli_num_rows($playlist)>0)
	{
		$playlists .= '<table class="table" bordered="1">
                    <tr>
                        <th>Id</th>
						<th>Tutor_id</th>  
                        <th>Title</th>
						<th>Description</th> 
                        <th>Thumb</th>
						<th>Date</th> 	
						<th>Status</th> 						
                    </tr>';
        while( $row = mysqli_fetch_array($playlist)){
			$playlists .= '<tr>
			                <td>'.$row["id"].'</td>
						    <td>'.$row["tutor_id"].'</td>  
			                <td>'.$row["title"].'</td>
						    <td>'.$row["description"].'</td>  
			                <td>'.$row["thumb"].'</td>
						    <td>'.$row["date"].'</td>  	
						    <td>'.$row["status"].'</td>							
		                </tr>';
			
		}
		$playlists .= '</table>';
		header("Content-Type: application/xls");
		header("Content-Disposition: attachement; filename=playlist_download.xls");
		
		
		
		echo $playlists;
    }
}



if(isset($_POST["program_Backup"]))
{	
    mysqli_query($connect,"update backup set backup_date=date_format(CURRENT_DATE(), '%d-%m-%Y') where table_name='program'");
	$sql = "select * from program";
	$program = mysqli_query($connect,$sql);
	if(mysqli_num_rows($program)>0)
	{
		$programs .= '<table class="table" bordered="1">
                    <tr>
                        <th>Id</th>
						<th>Program</th>  
                        <th>Detail</th>
						<th>Delete_Status</th>  						
                    </tr>';
        while( $row = mysqli_fetch_array($program)){
			$programs .= '<tr>
			                <td>'.$row["id"].'</td>
						    <td>'.$row["program"].'</td>  
			                <td>'.$row["detail"].'</td>
						    <td>'.$row["delete_status"].'</td>  			                 							
		                </tr>';
			
		}
		$programs .= '</table>';
		header("Content-Type: application/xls");
		header("Content-Disposition: attachement; filename=program_download.xls");
		
		
		
		echo $programs;
    }
}


if(isset($_POST["users_Backup"]))
{	
    mysqli_query($connect,"update backup set backup_date=date_format(CURRENT_DATE(), '%d-%m-%Y') where table_name='users'");
	$sql = "select * from users";
	$user = mysqli_query($connect,$sql);
	if(mysqli_num_rows($user)>0)
	{
		$users .= '<table class="table" bordered="1">
                    <tr>
                        <th>Id</th>
						<th>Registration_id</th>  
                        <th>Name</th>
						<th>Father_Name</th>  
                        <th>Gender</th>
						<th>Contact_No</th> 
                        <th>Alternate_Contact</th>
						<th>Email</th>  	
						<th>Year10</th> 	
                        <th>Year12</th>
						<th>Program</th>  	
						<th>Graduation_Type</th> 	
                        <th>YearG</th>
						<th>Post_Graduation_Type</th>  	
						<th>YearPG</th> 	
                        <th>Address</th>
						<th>Fees</th>  	
						<th>Balance</th> 	
                        <th>Image</th>
						<th>DOJ</th>  	
						<th>Delete_Status</th> 						
                    </tr>';
        while( $row = mysqli_fetch_array($user)){
			$users .= '<tr>
			                <td>'.$row["id"].'</td>
						    <td>'.$row["registration_id"].'</td>  
			                <td>'.$row["name"].'</td>
						    <td>'.$row["father_name"].'</td>  
						    <td>'.$row["gender"].'</td>
						    <td>'.$row["contact_no"].'</td> 
			                <td>'.$row["alternate_contact"].'</td>
						    <td>'.$row["email"].'</td> 
							<td>'.$row["year10"].'</td> 
			                <td>'.$row["year12"].'</td>
						    <td>'.$row["program"].'</td> 
							<td>'.$row["graduationT"].'</td> 
							<td>'.$row["yearg"].'</td>
						    <td>'.$row["Post_graduation"].'</td>  
						    <td>'.$row["yearpg"].'</td>
						    <td>'.$row["address"].'</td> 
			                <td>'.$row["fees"].'</td>
						    <td>'.$row["balance"].'</td> 
							<td>'.$row["image"].'</td> 
			                <td>'.$row["doj"].'</td>
						    <td>'.$row["delete_status"].'</td> 
		                </tr>';
			
		}
		$users .= '</table>';
		header("Content-Type: application/xls");
		header("Content-Disposition: attachement; filename=users_download.xls");
		
		
		
		echo $users;
    }
}
