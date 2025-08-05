<?php get_header(); ?>
<main class="global-main">
    <?php if (have_posts()) {
    	while (have_posts()) {
    		the_post(); ?>
        <div class="row">
            <div class="col-12">
                <div class="content-styled">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    <?php
    	}
    } ?>
</main>
<?php get_footer(); ?>
