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
                $archivo_video = $seccion['archivo_video'];
                $categoria = $seccion['categoria'];
                $enlace_bts = $seccion['enlace_bts'];
        ?>
            <div class="flex flex-col md:flex-row items-stretch mb-0 last:mb-0 presentation-item">
                <!-- Imagen (izquierda en escritorio si es par, derecha si es impar) -->
                <div class="w-full md:w-1/2 <?= $es_par ? 'md:pr-0 order-1' : 'md:pl-0 order-1 md:order-2'; ?> mb-8 md:mb-0">
                    <?php if($imagen): ?>
                        <div class="relative w-full h-full overflow-hidden">
                            <?php echo wp_get_attachment_image($imagen['ID'], 'large', false, ['class' => 'w-full h-full object-cover']); ?>
                            
                            <?php if($archivo_video): ?>
                                <button 
                                    class="absolute inset-0 w-full h-full flex items-center justify-center group"
                                    data-video-src="<?php echo esc_url($archivo_video['url']); ?>"
                                    data-modal-target="video-modal-<?= $blockID; ?>"
                                    aria-label="Reproducir video"
                                >
                                    <div class="w-30 h-30 flex items-center justify-center">
                                        <svg class="w-24 h-24 text-white dark:text-white opacity-80 group-hover:opacity-100 transition-opacity duration-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11v11.78a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                        </svg>
                                    </div>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Contenido (derecha en escritorio si es par, izquierda si es impar) -->
                <div class="w-full md:w-1/2 px-6 lg:px-0 <?= $es_par ? 'md:pl-8 lg:pl-16 order-2' : 'md:pr-8 lg:pr-16 order-2 md:order-1'; ?> flex items-center">
                    <div class="w-full max-w-lg mx-auto py-8 md:py-0">
                        <?php if($categoria): ?>
                            <div class="inline-block">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2 typewriter-element">
                                    <?php echo esc_html($categoria); ?>
                                </span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($titulo): ?>
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                                <span class="typewriter-element" data-delay="0.1">
                                    <?php echo esc_html($titulo); ?>
                                </span>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if($descripcion): ?>
                            <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-white mb-6 [&_p]:dark:text-white [&_p]:text-gray-600">
                                <p class="typewriter-element" data-delay="0.2">
                                    <?php echo wp_kses_post($descripcion); ?>
                                </p>
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
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1.5 0 011.414 0l4 4a1 1.5 0 010 1.414l-4 4a1 1.5 0 01-1.414-1.414L12.586 11H5a1 1.5 0 110-3h7.586l-2.293-2.293a1 1.5 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                            
                            <?php if($enlace_bts && !empty($enlace_bts['url'])): ?>
                                <a 
                                    href="<?php echo esc_url($enlace_bts['url']); ?>" 
                                    target="<?php echo esc_attr($enlace_bts['target'] ?: '_self'); ?>"
                                    class="btn btn-primary btn-medium"
                                >
                                    <span>BTS</span>
                                    <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
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
        <div class="w-full h-full">
            <video 
                id="video-player-<?= $blockID; ?>" 
                class="w-full h-full" 
                controls 
                playsinline
            >
                Tu navegador no soporta la reproducción de video.
            </video>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('video-modal-<?= $blockID; ?>');
    const videoPlayer = document.getElementById('video-player-<?= $blockID; ?>');
    let currentVideoSrc = '';

    // Abrir modal y cargar video
    document.querySelectorAll('[data-modal-target="video-modal-<?= $blockID; ?>"]').forEach(button => {
        button.addEventListener('click', function() {
            const videoSrc = this.getAttribute('data-video-src');
            if (videoSrc && videoSrc !== currentVideoSrc) {
                videoPlayer.src = videoSrc;
                currentVideoSrc = videoSrc;
            }
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            videoPlayer.play().catch(e => console.error('Error al reproducir el video:', e));
            document.body.style.overflow = 'hidden';
        });
    });

    // Cerrar modal
    const closeButtons = modal.querySelectorAll('[data-modal-close]');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            videoPlayer.pause();
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        });
    });

    // Cerrar al hacer clic fuera del contenido
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            videoPlayer.pause();
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
    });

    // Cerrar con tecla Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            videoPlayer.pause();
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
    });
});
</script>
