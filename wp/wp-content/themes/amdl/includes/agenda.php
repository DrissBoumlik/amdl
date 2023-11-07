<div class="section agenda">
    <div class="container">
        <div class="row headline">
            <h1 class="uppercase">agenda</h1>
            <hr>
            <hr>
        </div>
        <div class="row agenda-articles" id="agenda-articles">
            <div class="timeline timeline-indicators" id="timeline">
                <?php

                $args = array('posts_per_page' => 3, 'offset' => 0, 'category_name' => 'agenda');
                $posts = get_posts($args);
                $index = 0;
                foreach ($posts as $post) {
                    setup_postdata($post);
                ?>
                <div data-slide='<?php echo $index; ?>' data-date='<?php echo date('Y-m-d', strtotime(get_post_meta($post->ID, 'date_event', true))); ?>' class="uppercase <?php echo $index++ == 0 ? 'active' : '' ?> "><span></span><span><?php echo get_the_date('d') . ' ' . get_the_date('F'); ?></span></div>
                <?php } ?>
            </div>
            <?php
            $index = 0;
            foreach ($posts as $post) {
                setup_postdata($post);
                ?>
                <div class="col-md-12 agenda-article animated <?php echo $index++ == 0 ? 'fadeIn' : 'fadeOut hidden' ?> ">
                    <div class="row">
                        <div class="col-md-7 col-md-offset-1 col-xs-12">
                            <h2 class="article-title uppercase"><?php the_title(); ?></h2>
                            <p class="article-body">Lorem Ipsum is simply dummy text of the printing and typesetting
                                industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when
                                an
                                unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem
                                Ipsum is
                                simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                                industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                                of type and
                                scrambled it to make a type specimen book.</p>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()) ?>" alt="">
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>