<?php
/**
 * The template for displaying single BTS posts
 */
get_header();
?>

<main id="primary" class="site-main dark:bg-gray-900">
    <?php while (have_posts()) : the_post(); 
        // Obtener los campos personalizados
        $cliente = get_field('cliente');
        $descripcion = get_field('descripcion');
        $tipo_video = get_field('video_cargado_o_youtube');
        $video = get_field('video');
        $video_youtube = get_field('video_youtube');
        $galeria = get_field('galeria_de_fotos');
        $fotografias = get_field('fotografia'); // Campo de imagen simple
        $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    ?>

    <!-- Header con imagen de fondo -->
    <header class="relative h-screen flex items-center justify-center bg-cover bg-center" 
            style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?php echo esc_url($featured_img_url); ?>');">
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="inline-block bg-black bg-opacity-70 px-8 py-6 rounded-lg">
                <h1 class="text-4xl md:text-6xl font-bold mb-2 text-white"><?php the_title(); ?></h1>
                <?php if ($cliente) : ?>
                    <p class="text-xl md:text-2xl text-gray-300"><?php echo esc_html($cliente); ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Flecha de scroll posicionada al final del header -->
        <div class="absolute bottom-10 left-0 w-full flex justify-center">
            <a href="#contenido" class="text-white animate-bounce">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
                <span class="sr-only">Desplazarse hacia abajo</span>
            </a>
        </div>
    </header>

    <!-- Sección de contenido -->
    <section id="contenido" class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4 max-w-4xl">
            <!-- Descripción -->
            <?php if ($descripcion) : ?>
                <div class="prose dark:prose-invert max-w-none mb-16 text-gray-800 dark:text-gray-200">
                    <?php echo wp_kses_post($descripcion); ?>
                </div>
            <?php endif; ?>
           <!-- Video -->
          <?php if ($tipo_video && ($video || $video_youtube)) : ?>
              <div class="mb-16">
                  <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Video</h2>
                  <div class="relative pb-[56.25%] h-0 overflow-hidden rounded-xl shadow-xl bg-black"> <!-- 16:9 Aspect Ratio -->
                      <?php if ($tipo_video === 'hosted' && $video) : 
                          // Asegurarse de que $video sea un array y tenga 'url'
                          $video_url = is_array($video) ? ($video['url'] ?? '') : $video;
                          if (!empty($video_url)) :
                      ?>
                          <video controls class="absolute top-0 left-0 w-full h-full" playsinline>
                              <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                              Tu navegador no soporta el elemento de video.
                          </video>
                      <?php 
                          endif;
                      elseif ($tipo_video === 'youtube' && $video_youtube) : 
                          // Extraer el ID del video de YouTube
                          $video_id = '';
                          if (is_string($video_youtube)) {
                              if (preg_match('%(?:youtube(?:nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $video_youtube, $matches)) {
                                  $video_id = $matches[1];
                              }
                          }
                          
                          if ($video_id) : 
                      ?>
                          <iframe class="absolute top-0 left-0 w-full h-full" 
                                  src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>?rel=0" 
                                  title="Video de YouTube" 
                                  frameborder="0" 
                                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                  allowfullscreen>
                          </iframe>
                      <?php 
                          else : 
                              // Fallback para código de inserción personalizado
                              echo '<div class="absolute top-0 left-0 w-full h-full">' . $video_youtube . '</div>';
                          endif;
                      endif; 
                      ?>
                  </div>
              </div>
          <?php endif; ?>

                      <!-- Galería de fotos -->
          <?php 
          // Obtener la galería de fotos
          $galeria = get_field('galeria_de_fotos');

          if ($galeria && is_array($galeria) && !empty($galeria)) : 
              $fotografias = array();
              
              // Recorrer cada entrada de la galería
              foreach ($galeria as $entrada) {
                  // Obtener la imagen del campo 'fotografia' de cada entrada
                  $foto = $entrada['fotografia'] ?? null;
                  
                  if ($foto) {
                      if (is_array($foto) && isset($foto['url'])) {
                          // Formato de imagen ACF
                          $fotografias[] = array(
                              'url' => $foto['url'],
                              'alt' => $foto['alt'] ?? get_the_title()
                          );
                      } 
                      elseif (is_numeric($foto)) {
                          // Es un ID de imagen
                          $fotografias[] = array(
                              'url' => wp_get_attachment_url($foto),
                              'alt' => get_post_meta($foto, '_wp_attachment_image_alt', true) ?: get_the_title()
                          );
                      }
                      elseif (is_string($foto) && !empty($foto)) {
                          // Es una URL directa
                          $fotografias[] = array(
                              'url' => $foto,
                              'alt' => get_the_title()
                          );
                      }
                  }
              }

              if (!empty($fotografias)) : 
          ?>
              <div class="mb-16">
                  <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Galería de Fotos</h2>
                  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                      <?php foreach ($fotografias as $foto) : ?>
                          <div class="group overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                              <a href="<?php echo esc_url($foto['url']); ?>" data-fslightbox="galeria">
                                  <img src="<?php echo esc_url($foto['url']); ?>" 
                                      alt="<?php echo esc_attr($foto['alt']); ?>" 
                                      class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-105"
                                      loading="lazy">
                              </a>
                          </div>
                      <?php endforeach; ?>
                  </div>
              </div>
              <?php endif; ?>
          <?php endif; ?>
          
        </div>
    </section>

    <?php endwhile; ?>
</main>

<!-- Lightbox JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fslightbox@3.3.0/index.min.css">
<script src="https://cdn.jsdelivr.net/npm/fslightbox@3.3.0/index.min.js"></script>

<?php
get_footer();
?>