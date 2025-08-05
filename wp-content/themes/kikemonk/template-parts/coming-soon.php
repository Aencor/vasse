<div class="coming-soon-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300 min-h-screen">
  <div class="container mx-auto px-4 py-16 flex flex-col items-center justify-center h-screen">
    <!-- Contenedor del logo con dimensiones fijas -->
    <div class="mb-12 w-64 h-32 relative">
      <!-- Logo normal (se muestra en modo claro) -->
      <img 
        id="light-logo"
        class="w-full h-full object-contain transition-opacity duration-300 dark:opacity-0" 
        src="<?php echo get_template_directory_uri(); ?>/assets/img/logos/LOGO-VASSE.svg" 
        alt="Logo Vasse"
      >
      <!-- Logo invertido (se muestra en modo oscuro) -->
      <img 
        id="dark-logo"
        class="w-full h-full object-contain absolute top-0 left-0 opacity-0 dark:opacity-100 transition-opacity duration-300" 
        src="<?php echo get_template_directory_uri(); ?>/assets/img/logos/LOGO-VASSE-INVERTED.svg" 
        alt="Logo Vasse"
      >
    </div>
    
    <!-- Contenido de texto -->
    <div class="text-center mb-8">
      <h1 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900 dark:text-white">En Construcción</h1>
      <h4 class="text-xl text-gray-600 dark:text-gray-300">¡Estamos creando algo nuevo e impactante!</h4>
    </div>
    
    <!-- Botón para alternar modo oscuro -->
    <button 
      id="darkModeToggle" 
      class="mt-8 px-6 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-300 flex items-center gap-2"
      aria-label="Alternar modo oscuro"
    >
      <span id="darkModeIcon" class="dark:hidden">🌙 Modo oscuro</span>
      <span id="lightModeIcon" class="hidden dark:inline">☀️ Modo claro</span>
    </button>
  </div>
</div>
