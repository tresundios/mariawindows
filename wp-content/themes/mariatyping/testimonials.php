<?php
/**
 * Template Name: Testimonials
 * Description: Testimonials
 */
    get_header('home');
    get_template_part('template-parts/banner','testimonials');
?>
<div id="content">
    <div class="container">
        <div class="row">
            <div class="masonry">


                <?php

                

                $testimonials = array();

                array_push($testimonials, array("client_name" => "Mini Vignesh", 
                                                "image_name" => "default.jpg" ,
                                                "review" => "I booked hairstyle for my baby shower function and the result was so good. And I had a great experience from Maria Beauty Care at affordable price."));
                array_push($testimonials, array("client_name" => "Gil Jose", 
                                                "image_name" => "default.jpg" , 
                                                "review" => "I got a layer cut recently, and I'm absolutely loving it! The stylist had such a nice and friendly character it made the whole experience really comfortable. They really knew what they were doing, gave helpful suggestions, and made sure I was happy with the look every step of the way. The layers added so much volume and movement to my hair it feels light, fresh, and stylish. Highly recommend!  "));
                array_push($testimonials, array("client_name" => "Raja Linda", 
                                                "image_name" => "default.jpg" , 
                                                "review" => "Really awesome service. She is so friendly and happy to be with. She is so professional and guide in everything when come to services. I recommend everyone to visit once to see that yourself."));        
                array_push($testimonials, array("client_name" => "Letisha Smith", 
                                                "image_name" => "default.jpg" , 
                                                "review" => "Had a very good service of pedicure and facial in recent times. Highly recommended."));       
                array_push($testimonials, array("client_name" => "M Gokul", 
                                                "image_name" => "default.jpg" , 
                                                "review" => "Tq so much maria Beauty care for. Your efforts in making my hair styling special. I had a great experience at your place very friendly atmosphere best place for ladies to visit and opt for all kinds of services tq so much for your huge efforts and perfection.hope to visit soon"));       
                array_push($testimonials, array("client_name" => "Vinusanthiya", 
                                                "image_name" => "default.jpg" , 
                                                "review" => "Just had the most amazing spa day, the facial, D-tan, eyebrow, services were top-notch. Highly recommend."));       
                array_push($testimonials, array("client_name" => "Berna Binu", 
                                                "image_name" => "default.jpg" , 
                                                "review" => "Best salon.... Top notch service.expert stylist very kind and good ambiance.fully satisified."));       
                                                
                array_push($testimonials, array("client_name" => "Jose Jenish", 
                                                "image_name" => "default.jpg" , 
                                                "review" => "Maria smoothing treatment was life changing my hair is now silky and frizz free for months!"));       
                
                array_push($testimonials, array("client_name" => "Bavithra S", 
                                                "image_name" => "default.jpg" , 
                                                "review" => "I'm very satisfied with her work. I've did my bridal makeup. Totally changed my appearance and its really awesome. Sis is very friendly & profesional. Keep rocking sisy"));
                
                array_push($testimonials, array("client_name" => "Aniginosweety A", 
                                                "image_name" => "default.jpg" , 
                                                "review" => "I'm very satisfied with her services. Felt very comfortable by her approach. I've did haircut.she did magic for me. Totally changed my appearance with a simple haircut. Highly recommended. She is friendly & Profesional."));

                array_push($testimonials, array("client_name" => "Kavitha Raj", 
                                                "image_name" => "default.jpg" , 
                                                "review" => "Really nice and good service. Good quality products are being used. Really satisfied with their service. Must recommended for their good service"));   
                                                
                array_push($testimonials, array("client_name" => "Pooja Malathi", 
                                                "image_name" => "default.jpg" , 
                                                "review" => "I'm very impressed with the service"));  

                array_push($testimonials, array("client_name" => "Sruthi V", 
                                                "image_name" => "default.jpg" , 
                                                "review" => "That was perfect find for an outsiders who come for the services.. i had an amazing session with them. Eyebrows threading, facial, hair massage and wash, bridal mehandi. Altogether in a reasonable rate and completely satisfied with the hospitality. Genuinely very much recommended for any services.. My mom had her hair coloring and facial too and she is looking stunning.... Thanks to the beautiful changeover")); 

                array_push($testimonials, array("client_name" => "Gayathri", 
                                                "image_name" => "default.jpg" , 
                                                "review" => "Superb service, perfect in work and satisfies customer's expectation.")); 


                array_push($testimonials, array("client_name" => "Brintha Lingam", 
                                                "image_name" => "default.jpg" , 
                                                "review" => "I am a person who will suggest everyone to go in the natural basics treatment but after coming here for the first time today I loved the way they treated me and maintained my hair with good care and I loved all their products. To be frank I loved my hair so much it was so soft and I loved my self so much. Also they suggested me many Hairstyles for my look and also had a front cut for my face look. I looked myself like a new person. Self love is increasing by the magic performed by their hand. Thank you mam and sir")); 

                array_push($testimonials, array("client_name" => "Preethi Jospeh", 
                                                "image_name" => "default.jpg" , 
                                                "review" => "Excellent service. I went for hair cut for my daughter. Professional cut ND shape.")); 

                array_push($testimonials, array("client_name" => "Rengeshz Hariharan", 
                                                "image_name" => "default.jpg" , 
                                                "review" => "Hello Maria- been quite busy- I never forget to leave you a review here - thanks to my friends who introduced you and brother - I'm flattered about ur passion towards makeup and you are doing really really well. Kudos to the team.  The reason for my visit was hair coloring that was a great work done I loved it and thanks again looking forward to visit the salon soon.")); 
                // Loop to show 11 gallery items
                // Loop to show 11 gallery items
                for ($i = 0; $i < count($testimonials); $i++) :
                    $client_name = $testimonials[$i]["client_name"];
                    $image_url = get_template_directory_uri() . "/assets/testimonial/".$testimonials[$i]["image_name"];
                    
                    $review =  $testimonials[$i]["review"];
                
                ?>
                    <?php get_template_part('template-parts/each-testimonial', null, ['client_name'=> $client_name,'image_url' => $image_url,'review' => $review]); ?>
                    <!-- close gallery item -->
                <?php endfor ?>


            </div>
        </div>
    </div>
    
</div>
     <!-- section begin -->
           <?php get_template_part('template-parts/offer-and-appointment'); ?>
            <!-- section close -->

<?php
// Include the footer
get_footer('home');
// Close the wrapper div
?>



