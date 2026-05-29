<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>
   
   <link rel="stylesheet" href="css/testimonial.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- about section starts  -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about-img.svg" alt="">
      </div>

      <div class="content" style="text-align:left">
         <h3>Why Choose Us?</h3>
         <ul style="font-size:15px">
<li>1. Industry-Relevant Training :
At BIRD, we don't just teach theory; we focus on practical, hands-on experience with real-world projects. Our courses are designed in collaboration with top industry experts to ensure you’re learning the most up-to-date skills and technologies that IT companies are looking for. Whether you enroll in a 3, 6, or 9-month program, you’ll gain the expertise that aligns with current market demands.</li>
<li>2. Job-Oriented Courses :
We understand that the ultimate goal of education is to secure employment. That’s why our courses are tailored to make you job-ready. Our programs are designed to bridge the gap between academic learning and professional skills, making you an attractive candidate for top IT companies.</li>
<li>3. Placement Assistance & Networking :
Our placement assistance is one of the best in the industry. At BIRD, we don't just teach you, we help you connect with the right employers. From resume-building to mock interviews, we prepare you for success. With strong ties to leading IT firms, our alumni network and industry connections open up exclusive job opportunities for you.</li>
<li>4. Experienced Faculty & Mentorship
Our instructors aren’t just teachers—they’re professionals who have worked in the IT industry and bring real-world knowledge to the classroom. You’ll receive mentorship from experts who are passionate about helping you succeed. With a blend of experienced faculty and practical training, you’ll gain insights and skills that are directly applicable to your future job.</li>

         <a href="courses.php" class="inline-btn">Our Courses</a>
      </div>

   </div>

   <div class="box-container">

      <div class="box">
         <i class="fas fa-graduation-cap"></i>
         <div>
            <h3>+1k</h3>
            <span>Online Courses</span>
         </div>
      </div>

      <div class="box">
         <i class="fas fa-user-graduate"></i>
         <div>
            <h3>+1k</h3>
            <span>Brilliants Students</span>
         </div>
      </div>

      <div class="box">
         <i class="fas fa-chalkboard-user"></i>
         <div>
            <h3>+5</h3>
            <span>Expert Teachers</span>
         </div>
      </div>

      <div class="box">
         <i class="fas fa-briefcase"></i>
         <div>
            <h3>100%</h3>
            <span>Job Placement Assurance</span>
         </div>
      </div>

   </div>

</section>

<!-- about section ends -->

<!-- reviews section starts  -->



<section class="reviews">

   <h1 class="heading">Student's Reviews</h1>

   <div class="box-container">


<div class="container">
      <div class="testimonials-wrapper">
        <div class="testimonials-header">
          <h3>Our Candidates</h3>
          <div class="stars">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
          </div>
        </div>
        <div class="testimonials">
          <div class="slider">
            <div class="slide">
              <div class="slide-bg"></div>
              <div class="slide-content">
                <i class="fa-solid fa-quote-left"></i>
                <i class="fa-solid fa-quote-right"></i>
                <div class="slide-img">
                  <img src="images/client1.jpg" />
                </div>
                <div class="slide-text">
                  <p>
                    I have had a wonderful experience at BIRD. The faculty is knowledgeable and always willing to help. The curriculum is well-structured and covers all the essential topics. The learning environment is supportive and encourages growth. I highly recommend BIRD to anyone looking to advance their education....ðŸ™ŒðŸ˜Š
                  </p>
                  <p class="client">- Abhishek Bhardwaj</p>
                </div>
              </div>
            </div>
            <div class="slide">
              <div class="slide-bg"></div>
              <div class="slide-content">
                <i class="fa-solid fa-quote-left"></i>
                <i class="fa-solid fa-quote-right"></i>
                <div class="slide-img">
                  <img src="images/client2.jpg" />
                </div>
                <div class="slide-text">
                  <p>
                    BIRD is a good place to work with management being flexible to promote work, life balance. Helps employees to gain more subject knowledge and enhance soft skills with feedback from peers and also through various training sessions
                  </p>
                  <p class="client">- Jatin Chikara</p>
                </div>
              </div>
            </div>
            <div class="slide">
              <div class="slide-bg"></div>
              <div class="slide-content">
                <i class="fa-solid fa-quote-left"></i>
                <i class="fa-solid fa-quote-right"></i>
                <div class="slide-img">
                  <img src="images/client3.jpg" />
                </div>
                <div class="slide-text">
                  <p>
                    Thighly recommend BIRD for anyone looking to build or advance their career in IT. The combination of expert instructors, comprehensive content, and excellent career support makes it a top choice for learning Linux, SQL, and Shell Scripting.
                  </p>
                  <p class="client">- Harsh Sharma</p>
                </div>
              </div>
            </div>
            <div class="slide">
              <div class="slide-bg"></div>
              <div class="slide-content">
                <i class="fa-solid fa-quote-left"></i>
                <i class="fa-solid fa-quote-right"></i>
                <div class="slide-img">
                  <img src="images/client4.jpg" />
                </div>
                <div class="slide-text">
                  <p>
                    I have taken the certifications course from this institute. I was an amazing experience from here . Quality of coaching is incredible. Coaching is more on practical knowledge. The environment between teacher & student is very friendly.
                  </p>
                  <p class="client">- Hina Yadav</p>
                </div>
              </div>
            </div>
			
            <div class="slide">
              <div class="slide-bg"></div>
              <div class="slide-content">
                <i class="fa-solid fa-quote-left"></i>
                <i class="fa-solid fa-quote-right"></i>
                <div class="slide-img">
                  <img src="images/client5.jpg" />
                </div>
                <div class="slide-text">
                  <p>
                    My experience at BIRD has been incredibly positive, especially in the areas of SQL, PL/SQL, Linux, and MERN stack technologies. The instructors are highly knowledgeable and present complex topics in a way that is easy to understand. BIRD has provided me with the skills and knowledge needed to excel in these technologies. I would highly recommend their courses to anyone looking to advance their career in tech.
                  </p>
                  <p class="client">- Saurabh Chauhan</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="controls">
          <i class="fa-solid fa-arrow-left"></i>
          <i class="fa-solid fa-arrow-right"></i>
          <div class="dots">
            <span class="active"></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
      </div>
    </div>
 
   </div>

</section>

<!-- reviews section ends -->










<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script src="js/testimonial.js"></script>
   
</body>
</html>