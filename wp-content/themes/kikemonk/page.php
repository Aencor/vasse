<?php get_header(); ?>
<main class="global-main pt-5 dark:bg-gray-900 transition-colors duration-300">
  <div class="container mx-auto px-4">
    <div class="row justify-center">
      <div class="w-full">
        <article class="page-content w-full flex h-[calc(100vh-80px)] flex-col justify-center items-center h-full text-center gap-8 bg-white dark:bg-gray-900 transition-colors duration-300">
          <?php 
          if (have_posts()) {
            while (have_posts()) {
              the_post();
              echo '<div class="prose dark:prose-invert max-w-none w-full prose-lg text-gray-700 dark:text-gray-300 transition-colors duration-300">';
              the_content();
              echo '</div>';
            }
          }
          ?>
        </article>
      </div>
    </div>
  </div>
</main>
<?php get_footer(); ?>
