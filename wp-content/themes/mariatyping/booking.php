<?php
/**
 * Template Name: Appointment Booking
 * Description: Appointment Booking
 */
    get_header('home');
 ?>
          <!-- subheader -->
        <section id="subheader" class="subh-center" data-stellar-background-ratio=".2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Appointment</h1>
                        <h4>Services Booking</h4>
                    </div>
                </div>
            </div>
        </section>
        <!-- subheader close -->



        <!-- content begin -->
        <div id="content" class="no-bottom no-top">
            <section >
               
                <div class="container">
                    <?php echo do_shortcode('[booking resource_id=1]'); ?>
                </div>
            </section>

            
        </div>
<?php
// Include the footer
get_footer('home');
// Close the wrapper div
?>




