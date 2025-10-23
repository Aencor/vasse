<?php
/**
 * Archive para la taxonomía tipo
 */
get_header();
$term = get_queried_object();
?>
<main id="primary" class="site-main py-16 dark:bg-gray-900">
        <?php $portada = get_field('portada', $term); ?>
        <header class="mb-16 text-center overflow-hidden py-20 relative" style="<?php if(!empty($portada)) { ?>background-image: url('<?= esc_url($portada); ?>'); background-size:cover; background-position:center;<?php } ?>">
            <div class="absolute inset-0 bg-black opacity-50 pointer-events-none"></div>
            <div class="relative flex flex-col items-center px-10 max-w-2xl mx-auto">
                <h1 class="bts-title text-5xl md:text-7xl font-bold mb-2 text-white dark:text-white">
                    <?= esc_html($term->name); ?>
                </h1>
                <?php if (!empty($term->description)) : ?>
                <div class="subtitle-container">
                    <div class="subtitle text-xl md:text-2xl text-white dark:text-gray-300">
                        <?= esc_html($term->description); ?>
                    </div>
                </div>
                <?php endif; ?>
                <div class="w-24 h-1 bg-primary mx-auto mt-6 dark:bg-white"></div>
            </div>
        </header>
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-5xl mx-auto">
            <?php
            $args = array(
                'post_type' => 'servicios',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'tipo',
                        'field'    => 'term_id',
                        'terms'    => $term->term_id,
                    ),
                ),
                'posts_per_page' => -1,
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('group relative'); ?> >
    <?php 
        $tipo_video = get_field('carga_de_video_o_youtube');
        $video_url = '';
        $video_type = '';
        if ($tipo_video === 'youtube') {
            $video_url = get_field('url_youtube');
            $video_type = 'youtube';
        } elseif ($tipo_video === 'hosted') {
            $archivo_video = get_field('archivo_video');
            if ($archivo_video && !empty($archivo_video['url'])) {
                $video_url = $archivo_video['url'];
                $video_type = 'hosted';
            }
        }
    ?>

    <button type="button" class="block h-full w-full open-video-modal" 
        data-video-type="<?= esc_attr($video_type); ?>" 
        data-video-src="<?= esc_url($video_url); ?>"
        aria-label="Ver video"
        onclick="console.log('video_url:', '<?= esc_js($video_url); ?>', 'tipo:', '<?= esc_js($video_type); ?>')"
    >
        <div class="relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 h-full flex flex-col bg-white dark:bg-gray-800">
            <?php if ($featured_img_url) : ?>
                <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                    <img src="<?php echo esc_url($featured_img_url); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                </div>
            <?php endif; ?>
            <div class="p-6 flex-grow flex flex-col">
                <h2 class="h4 font-semibold mb-4 text-gray-900 dark:text-white group-hover:text-primary transition-colors">
                    <?php the_title(); ?>
                </h2>
                <span class="mt-auto text-primary font-medium inline-flex items-center group-hover:underline dark:text-blue-400">
                    Ver video
                    <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </div>
        </div>
    </button>
</article>

            <?php endwhile;
                // Paginación
                echo '<div class="col-span-full mt-12">';
                the_posts_pagination([
                    'mid_size' => 2,
                    'prev_text' => '&larr; Anterior',
                    'next_text' => 'Siguiente &rarr;',
                    'class' => 'flex justify-center dark:text-white'
                ]);
                echo '</div>';
            else : ?>
                <div class="col-span-full text-center py-12">
                    <p class="text-xl text-gray-900 dark:text-white">No se encontraron videos para esta categoría.</p>
                </div>
            <?php endif; wp_reset_postdata(); ?>
        </div>
    </div>
<!-- Modal de Video -->
<div id="video-modal-taxonomy" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-90 p-4">
    <div class="relative w-full max-w-[80vw] aspect-video">
        <button 
            type="button" 
            class="absolute -top-10 right-0 text-white hover:text-gray-300 focus:outline-none z-10"
            id="close-video-modal-taxonomy"
        >
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="w-full h-full modal-content-taxonomy"></div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('video-modal-taxonomy');
    const modalContent = modal?.querySelector('.modal-content-taxonomy');
    // Abrir modal
    document.querySelectorAll('.open-video-modal').forEach(btn => {
        btn.addEventListener('click', function() {
            const videoType = this.getAttribute('data-video-type');
            const videoSrc = this.getAttribute('data-video-src');
            if (modalContent) modalContent.innerHTML = '';
            if (videoType === 'youtube' && videoSrc) {
                let embedUrl = videoSrc;
                // Si el valor es un iframe, extraer el src
                if (videoSrc.includes('<iframe')) {
                    const srcMatch = videoSrc.match(/src=["']([^"']+)["']/);
                    if (srcMatch && srcMatch[1]) {
                        embedUrl = srcMatch[1];
                    }
                } else {
                    // Extraer ID si es URL normal
                    const match = videoSrc.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i);
                    if(match && match[1]) {
                        embedUrl = `https://www.youtube.com/embed/${match[1]}?autoplay=1&mute=1`;
                    }
                }
                // Agregar el iframe como HTML para depuración visual
                if (modalContent) {
                    modalContent.innerHTML += `<iframe class='w-full h-full aspect-video' src='${embedUrl}' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>`;
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
    document.getElementById('close-video-modal-taxonomy').addEventListener('click', function() {
        const videos = modal?.querySelectorAll('video, iframe');
        videos?.forEach(video => {
            if (video.tagName === 'VIDEO') video.pause();
            else if (video.tagName === 'IFRAME') video.src = video.src;
        });
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    });
});
</script>
</main>
<?php get_footer(); ?>
