<div class="section updates">
    <div class="container">
        <div class="row headline">
            <h1 class="uppercase">Actualités</h1>
            <hr>
            <hr>
        </div>
        <div class="row latest-articles" id="latest-articles">

            <?php $the_query = new WP_Query('posts_per_page=9');
            $args = array( 'posts_per_page' => 9, 'offset'=> 0, 'category_name' => 'actualites');
            $posts = get_posts( $args );
            foreach ( $posts as $post ) {
                setup_postdata( $post );
            // Start our WP Query
            // while ($the_query->have_posts()) {
            //     $the_query->the_post();

                ?><div class="col-md-4 col-xs-12 article">
                    <div class="card">
                        <img class="card-img-top" src="<?php echo get_the_post_thumbnail_url(get_the_ID()) ?>" alt="Card image cap">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-xs-3">
                                    <div class="article-date">
                                        <span class="day bold"><?php echo get_the_date('d'); ?></span>
                                        <hr>
                                        <span class="month"><?php echo get_the_date('F Y'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-9 col-xs-9">
                                    <div class="article-content">
                                        <h3 class="uppercase article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <p class="article-body"><?php the_excerpt(); ?></p>
                                        <span class="read-more"><i class="fas fa-long-arrow-alt-right"></i><a href="<?php the_permalink(); ?>" class="uppercase bold">Lire plus</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><?php } ?>
        


            <ol class="updates-indicators">
                <li class="active" data-slide='0'></li>
                <li data-slide='1'></li>
                <li class="" data-slide='2'></li>
            </ol>
        </div>
    </div>
</div>