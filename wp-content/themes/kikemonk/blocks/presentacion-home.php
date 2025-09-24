<?php
/**
 * Block Name: Presentación Home
 * Slug: presentacion-home
 * Description: Bloque principal de presentación con layout alternado.
 * Keywords: presentación, home, alternado, video
 * Align: full
 */

$block_name = 'presentacion-home';
$blockID = $block_name . '-' . $block['id'];
if (!empty(get_field('block_id'))) {
    $blockID = get_field('block_id');
}

$className = array($block_name, 'py-16 md:py-24');
$editBG = get_field('edit_background_options');
$editPadding = get_field('edit_padding_options');

if($editBG){
    $bgColor = get_field('background_color');
    array_push($className, $bgColor);
}

if($editPadding){
    $topP = get_field('padding_top');
    $bottomP = get_field('padding_bottom');
    array_push($className, 'pt-' . $topP);
    array_push($className, 'pb-' . $bottomP);
}

// Local Variables
$secciones = get_field('secciones'); // Repeater field
?>

<section 
    id="<?= $blockID; ?>" 
    data-block="<?= $block_name; ?>" 
    class="<?php echo esc_attr(implode(' ', $className)); ?> dark:bg-gray-900 w-full"
>
    <div class="w-full max-w-screen-full mx-auto">
        <?php if($secciones): 
            $count = 0;
            foreach($secciones as $seccion): 
                $es_par = $count % 2 === 0;
                $imagen = $seccion['imagen'];
                $titulo = $seccion['titulo'];
                $descripcion = $seccion['descripcion'];
                $boton = $seccion['boton'];
                $categoria = $seccion['categoria'];
                $enlace_bts = $seccion['enlace_bts'];

                $tipo_video = $seccion['carga_de_video_o_youtube'];
                $video_mp4 = $seccion['archivo_video'];
                $youtube_embed = $seccion['url_youtube']; 
        ?>
            <div class="flex my-16 flex-col md:flex-row items-stretch mb-0 last:mb-0 presentation-item">
                <!-- Imagen (izquierda en escritorio si es par, derecha si es impar) -->
                <div class="w-full md:w-3/5 <?= $es_par ? 'md:pr-0 order-1' : 'md:pl-0 order-1 md:order-2'; ?> mb-8 md:mb-0">
                    <?php if($imagen): ?>
                        <div class="relative w-full h-full overflow-hidden">
                            <?php echo wp_get_attachment_image($imagen['ID'], 'large', false, ['class' => 'w-full h-full object-cover']); ?>
                            
                            <?php if($tipo_video === 'hosted' && $video_mp4 || $tipo_video === 'youtube' && $youtube_embed): ?>
                                <button 
                                    class="absolute inset-0 w-full h-full flex items-center justify-center group"
                                    data-video-type="<?php echo esc_attr($tipo_video); ?>"
                                    data-video-src="<?php 
                                        if ($tipo_video === 'youtube') {
                                            // Si es un iframe embed, extraer solo la URL
                                            if (strpos($youtube_embed, '<iframe') !== false) {
                                                preg_match('/src="([^"]+)"/', $youtube_embed, $match);
                                                echo $match ? esc_url($match[1]) : '';
                                            } else {
                                                // Si es una URL normal de YouTube
                                                echo esc_url($youtube_embed);
                                            }
                                        } else {
                                            echo esc_url($video_mp4['url']);
                                        }
                                    ?>"
                                    data-modal-target="video-modal-<?= $blockID; ?>"
                                    aria-label="Reproducir video"
                                >
                                <div class="border border-white bg-transparent group-hover:bg-white transition-all duration-300 px-6 py-3 flex items-center">
                                        <span class="font-light text-white group-hover:text-black transition-colors duration-300">PLAY</span>
                                        <svg class="ml-2 w-4 h-4 text-white group-hover:text-black transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Contenido (derecha en escritorio si es par, izquierda si es impar) -->
                <div class="w-full md:w-2/5 px-6 lg:px-0 <?= $es_par ? 'md:pl-8 lg:pl-16 order-2' : 'md:pr-8 lg:pr-16 order-2 md:order-1'; ?> flex items-center">
                    <div class="w-full max-w-lg mx-auto py-8 md:py-0">
                        
                        <?php if($titulo): ?>
                            <h2 class="h3 uppercase text-gray-900 dark:text-white mb-4">   
                                <?php 
                                    // Remove any <p> tags while keeping the content
                                    $clean_description = strip_tags($descripcion, '<strong><em><span><br>');
                                    echo wp_kses($clean_description, array(
                                        'strong' => array(),
                                        'em' => array(),
                                        'span' => array('class' => array()),
                                        'br' => array(),
                                    ));
                                ?>
                            </h2>
                        <?php endif; ?>
                        <?php if($categoria): ?>
                            <div class="inline-block">
                                <h4 class="text-sm font-regular text-gray-600 dark:text-gray-300 mb-2 typewriter-element">
                                <?php echo esc_html($titulo); ?> / <?php echo esc_html($categoria); ?>
                        </h4>
                            </div>
                        <?php endif; ?>
                        
                        <div class="flex flex-wrap gap-4" data-animate="fadeInUp" data-delay="0.3">
                            <?php if($boton && !empty($boton['url'])): ?>
                                <a 
                                    href="<?php echo esc_url($boton['url']); ?>" 
                                    target="<?php echo esc_attr($boton['target'] ?: '_self'); ?>"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-700 dark:hover:bg-indigo-600 transition-colors duration-200"
                                >
                                    <?php echo esc_html($boton['title'] ?: 'Ver más'); ?>
                                    <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1.5 0 011.414 0l4 4a1 1.5 0 010 1.414l-4 4a1 1.5 0 01-1.414-1.414L12.586 11H5a1 1.5 0 110-3h7.586l-2.293-2.293a1 1.5 0 010-2.12z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                            
                            <?php if($enlace_bts && !empty($enlace_bts['url'])): ?>
                                <a 
                                    href="<?php echo esc_url($enlace_bts['url']); ?>" 
                                    target="<?php echo esc_attr($enlace_bts['target'] ?: '_self'); ?>"
                                    class="group inline-flex items-center font-bold text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200"
                                >
                                    BTS
                                    <svg class="ml-2 w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
            $count++;
            endforeach; 
        endif; 
        ?>
    </div>
</section>

<!-- Video Modal -->
<div id="video-modal-<?= $blockID; ?>" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-90 p-4">
    <div class="relative w-full max-w-[80vw] aspect-video">
        <button 
            type="button" 
            class="absolute -top-10 right-0 text-white hover:text-gray-300 focus:outline-none z-10"
            data-modal-close
        >
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="w-full h-full modal-content">
            <?php  
            if($tipo_video === 'youtube' && $youtube_embed):
                // Usar el campo oEmbed directamente
                echo '<div class="w-full h-full aspect-video">' . $youtube_embed . '</div>';
                
            elseif($tipo_video === 'hosted' && $video_mp4): ?>
                <video 
                    class="w-full h-full" 
                    controls 
                    autoplay 
                    muted 
                    playsinline
                >
                    <source src="<?php echo esc_url($video_mp4['url']); ?>" type="video/mp4">
                    Tu navegador no soporta el elemento de video.
                </video>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('video-modal-<?= $blockID; ?>');
    const modalContent = modal?.querySelector('.modal-content');
    let currentVideoType = '';

    // Abrir modal
    document.querySelectorAll('[data-modal-target="video-modal-<?= $blockID; ?>"]').forEach(button => {
        button.addEventListener('click', function() {
            const videoType = this.getAttribute('data-video-type');
            const videoSrc = this.getAttribute('data-video-src');
            
            // Limpiar contenido anterior
            if (modalContent) {
                modalContent.innerHTML = '';
            }

            if (videoType === 'youtube' && videoSrc) {
                // Extraer el ID del video de YouTube
                const videoId = videoSrc.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i);
                if (videoId && videoId[1]) {
                    const iframe = document.createElement('iframe');
                    iframe.className = 'w-full h-full aspect-video';
                    iframe.src = `https://www.youtube.com/embed/${videoId[1]}?autoplay=1&mute=1`;
                    iframe.setAttribute('frameborder', '0');
                    iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
                    iframe.setAttribute('allowfullscreen', '');
                    modalContent?.appendChild(iframe);
                }
            } else if (videoType === 'hosted' && videoSrc) {
                const video = document.createElement('video');
                video.className = 'w-full h-full';
                video.controls = true;
                video.autoplay = true;
                video.muted = true;
                video.playsInline = true;
                
                const source = document.createElement('source');
                source.src = videoSrc;
                source.type = 'video/mp4';
                
                video.appendChild(source);
                video.appendChild(document.createTextNode('Tu navegador no soporta el elemento de video.'));
                modalContent?.appendChild(video);
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        });
    });

    // Cerrar modal
    const closeButtons = modal?.querySelectorAll('[data-modal-close]');
    closeButtons?.forEach(button => {
        button.addEventListener('click', function() {
            // Detener cualquier video que se esté reproduciendo
            const videos = modal?.querySelectorAll('video, iframe');
            videos?.forEach(video => {
                if (video.tagName === 'VIDEO') {
                    video.pause();
                } else if (video.tagName === 'IFRAME') {
                    // Para iframes de YouTube, reemplazar el src para detener la reproducción
                    video.src = video.src;
                }
            });
            
            modal?.classList.add('hidden');
            modal?.classList.remove('flex');
            document.body.style.overflow = '';
        });
    });
});
</script>