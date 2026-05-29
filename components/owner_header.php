<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

if(isset($_COOKIE['owner_id'])){
   $owner_id = $_COOKIE['owner_id'];
}else{
   $owner_id = '';
  # header('location:login.php');
}
?>

<header class="header">

   <section class="flex">

      <a href="home.php" style="display: flex;justify-content: center;"><img style="width:55%" src="../../images/logo1.png"></a>

      <form action="search_page.php" method="post" class="search-form">
         <input type="text" name="search" placeholder="search here..." required maxlength="100">
         <button type="submit" class="fas fa-search" name="search_btn"></button>
      </form>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="toggle-btn" class="fas fa-sun"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `owners` WHERE id = ?");
            $select_profile->execute([$owner_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="../../uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <span>Director</span>
         <!--<a href="profile.php" class="btn">view profile</a>  -->
         <!-- <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div> -->
         <a href="../../components/owner_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         <?php
            }else{
         ?>
         <h3>please login or register</h3>
          <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
         <?php
            }
         ?>
      </div>

   </section>

</header>

<!-- header section ends -->

<!-- side bar section starts  -->

<div class="side-bar">

   <div class="close-side-bar">
      <i class="fas fa-times"></i>
   </div>

   <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `owners` WHERE id = ?");
            $select_profile->execute([$owner_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <span>Director</span>
         <!-- <a href="profile.php" class="btn">view profile</a> -->
         <?php
            }else{
         ?>
         <h3>please login or register</h3>
         <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <!--<a href="register.php" class="option-btn">register</a>-->
         </div>
         <?php
            }
         ?>
      </div>

   <nav class="navbar">
      <a href="home.php"><i class="fas fa-home"></i><span>Home</span></a>
      <a href="placed_fees.php"><i class="fa-solid fa-money"></i><span>Collect Fee</span></a>
      <a href="student.php"><i class="fas fa-users"></i><span>Manage Students</span></a>
      <a href="placed_report.php"><i class="fas fa-file-pdf-o"></i><span>Reports</span></a>
      <a href="../../components/owner_logout.php" onclick="return confirm('logout from this website?');"><i class="fas fa-right-from-bracket"></i><span>Logout</span></a>
   </nav>

</div>

<!-- side bar section ends -->