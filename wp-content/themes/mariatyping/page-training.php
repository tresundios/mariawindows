<?php
/*
Template Name: Training Page
*/
get_header('home'); ?>
<!-- subheader -->
<section id="subheader" class="subh-center" data-stellar-background-ratio=".2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Maria Beauty Care's Training</h1>
            </div>
        </div>
    </div>
</section>
<!-- subheader close -->
 <style>
    #subheader .circy {
    background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/background/subheader-2.jpg') !important;
}
    #content {
        padding-top:0px !important;
    }
    .hero {
      background-color:rgb(239, 221, 235);
    
      text-align: center;
     
    }
    .hero h1 { font-weight: bold; font-size: 36px; margin-bottom: 10px; }
    .hero p { font-size: 18px; }
    .stats { margin: 40px 0; text-align: center; }
    .stats h3 { font-size: 28px; margin-bottom: 5px; }
    .section-title { font-size: 24px; font-weight: bold; margin-top: 40px; }
    .timeline { background: #f1f1f1; padding: 20px; margin: 20px 0; border-radius: 5px; }
    .testimonial { background: #fff; padding: 15px; border: 1px solid #eee; border-radius: 4px; margin-bottom: 15px; }
    .footer-cta {
      background: #333;
      color: #fff;
      text-align: center;
      padding: 40px 20px;
    }
    .footer-cta h2 { font-size: 30px; margin-bottom: 15px; }
    .btn-enroll { background-color:rgb(199, 94, 138) !important; color: white; font-size: 18px; padding: 10px 25px; }
     .panel-title a { display: block; text-decoration: none; }
.panel-heading {
  background-color: #f8c8dc !important; /* Light pink background */
  border-color: #f48fb1 !important;     /* Deeper pink border */
  color: #880e4f;            /* Rich pink text */
  font-weight: 900;
  padding: 15px;
  font-size: 16px;
}

.panel-heading a {
  color: #880e4f;
  text-decoration: none;

}

.panel-heading a:hover {
  color: #ad1457; /* Slightly deeper on hover */
}

.panel-body {
  background-color: #fff0f5; /* Very light pink */
  color: #4a0033;
  padding: 15px;
  border: 1px solid #f48fb1 !important;
  font-size: 15px;
  line-height: 1.6;
}

.call {
    padding-top:20px;
}
.circle-text {
  padding:25%;
  background-color: #f8c8dc; /* Light pink */
  color: #880e4f;             /* Dark pink text */
  width: 80%;
  height: 10%;
 
  text-align: center;
  border-radius: 50%;
  font-weight: bold;
  font-size: 16px;
  
  display: inline-block;
}
  </style>
<div >
<!-- Hero -->

    <!-- Stats -->
    <div>
  <div class=" col-12 hero    row text-center ">
    <div class="col-sm-4">
      <img src='<?php echo get_template_directory_uri(); ?>/assets/training/back1.jpg' width="100%"/>
    </div>
    <div class="col-sm-4 " style="padding-top:8%">
      <h1>Fast track Makeup Mastery</h1>
    <p>Learn live with pros and get certified in 4 weeks</p>
    <a href="#enroll" class="btn btn-enroll">Enroll Now</a>
    
    <p class="call"><small>Call or Whatsapp +91 81480 64967  for next batch </small></p>
    </div>
    <div class="col-sm-4">
       <img src='<?php echo get_template_directory_uri(); ?>/assets/training/back2.jpg' width="100%"/>
    </div>
  </div>
</div>

  <!-- Stats -->



  <!-- Course Outline -->
  <div class="container" >
    <h2 class="section-title">Learn with Real People</h2>
    <p>We offer live sessions, real feedback, full kits, and certification in just 4 weeks. Not just theory — you practice and build real skills.</p>

   <div class="panel-group" id="accordion">

      <!-- Week 1 -->
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#week1">
              Week 1 – Learn Skin + Base
            </a>
          </h4>
        </div>
        <div id="week1" class="panel-collapse collapse in">
          <div class="panel-body">
            <ul>
              <li>Understanding skin types</li>
              <li>Prepping skin for makeup</li>
              <li>Foundation matching</li>
              <li>Concealing techniques</li>
              <li>Flawless base application</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Week 2 -->
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#week2">
              Week 2 – Practice on Mannequin
            </a>
          </h4>
        </div>
        <div id="week2" class="panel-collapse collapse">
          <div class="panel-body">
            <ul>
              <li>Basic eye looks</li>
              <li>Blending techniques</li>
              <li>Lipstick and lipliner practice</li>
              <li>Using brushes and tools</li>
              <li>Creating everyday looks</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Week 3 -->
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#week3">
              Week 3 – Feedback + Portfolio
            </a>
          </h4>
        </div>
        <div id="week3" class="panel-collapse collapse">
          <div class="panel-body">
            <ul>
              <li>Personalized trainer feedback</li>
              <li>Makeup on real models</li>
              <li>Capturing your work</li>
              <li>Building your portfolio</li>
              <li>Corrections and refinements</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Week 4 -->
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#week4">
              Week 4 – Certified + Client-Ready
            </a>
          </h4>
        </div>
        <div id="week4" class="panel-collapse collapse">
          <div class="panel-body">
            <ul>
              <li>Final assessment</li>
              <li>Client-ready look demo</li>
              <li>Certification ceremony</li>
              <li>Tips for professional success</li>
              <li>Q&A and career guidance</li>
            </ul>
          </div>
        </div>
      </div>
  </div>

  <div class="container circy">
  <div class=" col-12    stats row text-center padding40">
    <div class="col-sm-4">
        <div class="circle-text">
            <h3>50+</h3>
            <p>Students Trained</p>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="circle-text">
      <h3>4 Weeks</h3>
      <p>Certification</p>
</div>
    </div>
    <div class="col-sm-4">
        <div class="circle-text text-center">
      <h3>100%</h3>
      <p>Live Training</p>
</div>
    </div>
  </div>
</div>

  <!-- Hands-on and Trainers -->
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <h2 class="section-title">Only Hands-on Experience</h2>
        <p>Our training skips fluff and focuses on real skills you’ll use with clients.</p>
      </div>
      <div class="col-sm-6">
        <h2 class="section-title">Tools Provided</h2>
        <p>Get a full pro makeup kit and mannequin included — no extra purchases needed.</p>
      </div>
    </div>
  </div>

  <!-- Testimonials -->
  <div class="container">
    <h2 class="section-title">Hear from Our Students</h2>
    <div class="row">
      <div class="col-sm-4 testimonial">
        <p>“I was a beginner and now I’m doing makeup for real clients. The live sessions helped me stay motivated.”</p>
        <p><strong>– Kate M.</strong>, Chennai</p>
      </div>
      <div class="col-sm-4 testimonial">
        <p>“Everything was hands-on and real. I feel confident working professionally now.”</p>
        <p><strong>– Chloe K.</strong>, Nagercoil</p>
      </div>
      <div class="col-sm-4 testimonial">
        <p>“This course was different. I was really preparing for a career.”</p>
        <p><strong>– Milana J.</strong>, Nagercoil</p>
      </div>
    </div>
  </div>

</div>


<?php get_footer('home'); ?>