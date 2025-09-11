<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <link rel="icon" type="image/png" href="<?php bloginfo("template_directory"); ?>/assets/img/favicon.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/fontawesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/brands.min.css">
  <?php wp_head(); ?>
  <style>
    /* Smooth scroll behavior */
    html {
      scroll-behavior: smooth;
    }
    
    /* Fixed header styles */
    #masthead {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      transition: all 0.3s ease-in-out;
      background-color: transparent;
      backdrop-filter: blur(0px);
      -webkit-backdrop-filter: blur(0px);
    }
    
    /* Scrolled state for header */
    #masthead.scrolled {
      background-color: rgba(255, 255, 255, 0.95);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }
    
    .dark #masthead.scrolled {
      background-color: rgba(17, 24, 39, 0.95);
    }
    
    /* Adjust content padding to account for fixed header */
    .site-content {
      padding-top: 80px;
    }
  </style>
</head>

<body <?php body_class('bg-white dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300'); ?>>
  <header id="masthead" class="py-4">
    <div class="container max-w-screen-xl mx-auto px-4">
      <div class="flex justify-between items-center">
        <div class="logo w-32 relative">
          <a href="<?php echo home_url(); ?>">
            <img 
              id="light-logo"
              class="w-full h-full object-contain transition-opacity duration-300 dark:opacity-0" 
              src="<?php echo get_template_directory_uri(); ?>/assets/img/logos/LOGO-VASSE.svg" 
              alt="<?php bloginfo('name'); ?>"
            >
            <img 
              id="dark-logo"
              class="w-full h-full object-contain absolute top-0 left-0 opacity-0 dark:opacity-100 transition-opacity duration-300" 
              src="<?php echo get_template_directory_uri(); ?>/assets/img/logos/LOGO-VASSE-INVERTED.svg" 
              alt="<?php bloginfo('name'); ?>"
            >
          </a>
        </div>
        
        <div class="flex items-center space-x-4">
          <button 
            id="darkModeToggle" 
            class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-300"
            aria-label="<?php esc_attr_e('Toggle dark mode', 'kikemonk'); ?>"
          >
            <span id="darkModeIcon" class="text-xl dark:hidden">🌙</span>
            <span id="lightModeIcon" class="text-xl hidden dark:inline">☀️</span>
          </button>
          
          <button class="p-2 relative w-8 h-8 focus:outline-none" id="mobile-menu-button">
            <span class="block absolute h-0.5 w-6 bg-current transform transition duration-300 ease-in-out" id="hamburger-top"></span>
            <span class="block absolute h-0.5 w-6 bg-current transform transition duration-300 ease-in-out" id="hamburger-middle"></span>
            <span class="block absolute h-0.5 w-6 bg-current transform transition duration-300 ease-in-out" id="hamburger-bottom"></span>
          </button>
        </div>
      </div>
    </div>
  </header>

  <div id="mobile-menu" class="fixed inset-0 bg-white dark:bg-gray-900 z-50 p-4 pt-20 opacity-0 invisible transition-opacity duration-300">
    <?php
    wp_nav_menu(array(
      'menu' => 'Primary Menu',
      'theme_location' => 'primary',
      'menu_class'     => 'space-y-6',
      'container'      => 'nav',
      'link_before'    => '<span class="block py-2 text-2xl font-medium text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">',
      'link_after'     => '</span>',
      'items_wrap'     => '<div class="container mx-auto px-4"><ul class="max-w-2xl mx-auto">%3$s</ul></div>',
    ));
    ?>
  </div>

  <script>
  // Toggle mobile menu
  document.getElementById('mobile-menu-button').addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.toggle('active-menu');
  });
  
  // Header scroll effect
  window.addEventListener('scroll', function() {
    const header = document.getElementById('masthead');
    if (window.scrollY > 50) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  });
  
  // Trigger scroll event on load in case page is loaded with scroll position
  window.dispatchEvent(new Event('scroll'));
  </script>