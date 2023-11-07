<?php get_header(); ?>

<main role="main">
    <!-- section -->



    <?php
    if (!true) include 'includes/carousel.php';
    else echo do_shortcode('[smartslider3 slider=1]');

    
    echo do_shortcode('[widgets_on_pages id="1"]');
    // include 'includes/brands.php';
    include 'includes/updates.php';
    include 'includes/media.php';
    include 'includes/agenda.php';

    // echo do_shortcode( '[slide-anything id="75"]' );
    // echo do_shortcode( '[slick-carousel-slider centermode="true"]' );
    // echo do_shortcode('[metaslider id="81"]');
    // echo do_shortcode('[Rich_Web_Slider id="1"]');
    // echo do_shortcode("[carousel_slide id='89']");
    // nivo_slider( 92 );
    
    include 'includes/partners.php';
    
    include 'includes/community.php';

    ?>
</main>


<?php get_footer(); ?>