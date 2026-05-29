<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>courses</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- courses section starts  -->

<section class="courses">

   <h1 class="heading">all courses</h1>

   <div class="box-container">

      <?php
           $select_categories = $conn->prepare("SELECT * FROM categories");
           $select_categories->execute();

           while($cat = $select_categories->fetch(PDO::FETCH_ASSOC)){
			   $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
               $select_tutor->execute([$cat['tutor_id']]);
               $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
       ?>

          <div class="box">
         <div class="tutor">
            <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_tutor['name']; ?></h3>
            </div>
         </div>
         <img src="uploaded_files/<?= $cat['thumb']; ?>" class="thumb" alt="">
         <h3 class="title" style="font-size: 2.5rem;color: black;"><?= $cat['name']; ?></h3>
         <a href="category_courses.php?category_id=<?= $cat['id']; ?>" class="inline-btn">view playlist</a>
      </div>
      <?php
      }
      ?>


</div>
</section>

<!-- courses section ends -->










<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>