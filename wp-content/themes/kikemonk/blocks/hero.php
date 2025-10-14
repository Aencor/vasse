<?php
/**
 * Block Name: Hero
 * Slug: hero
 * Description: Hero section with autoplaying video carousel and overlay text
 * Keywords: hero, video, carousel, overlay
 * Align: full
 */

// Block ID
$block_id = 'hero-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'hero-block relative w-full';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// ACF Fields
$titulo = get_field('titulo') ?: 'Título del Hero';
$descripcion = get_field('descripcion') ?: '';
$videos = get_field('videos') ?: [];
$text_color = get_field('text_color') ?: '#ffffff';
$overlay_opacity = get_field('overlay_opacity') ?: 30;
?>

<section 
    id="<?php echo esc_attr($block_id); ?>" 
    class="<?php echo esc_attr($class_name); ?>"
    style="
        --text-color: <?php echo esc_attr($text_color); ?>;
        --header-height: 80px; /* Match this with the header height in header.php */
    "
>
    <!-- Video Carousel -->
    <div class="relative w-full h-screen overflow-hidden">
        <?php if (!empty($videos)): ?>
            <div class="hero-video-container">
                <?php foreach ($videos as $index => $video): 
                    $video_url = $video['video']['url'] ?? '';
                    if (empty($video_url)) continue;
                ?>
                    <video 
                        class="hero-video <?php echo $index === 0 ? 'active' : ''; ?>" 
                        <?php echo $index === 0 ? '' : 'style="display: none;"'; ?>
                        autoplay 
                        muted 
                        loop
                        playsinline
                        preload="auto"
                    >
                        <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                        <?php _e('Your browser does not support the video tag.', 'kikemonk'); ?>
                    </video>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <!-- Overlay with dynamic opacity -->
        <div 
            class="absolute inset-0 bg-black" 
            style="opacity: <?php echo esc_attr($overlay_opacity / 100); ?>;"
        ></div>

        <!-- Content Overlay -->
        <div class="relative z-10 h-full flex flex-col justify-between">
            <div class="pt-[calc(var(--header-height)+2rem)] px-4 md:px-8">
                <div class="max-w-screen-xl mx-auto">
                    <!--
                    <?php if (!empty($descripcion)): ?>
                        <div class="prose hero-text text-white dark:text-white max-w-2xl">
                            <div class="typewriter-text text-uppercase">
                                <?php echo wp_kses_post($descripcion); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    -->
                </div>
            </div>

            <!-- Video Navigation -->
            <?php if (count($videos) > 1): ?>
                <div class="container max-w-xl px-8 pb-12">
                    <div class="flex items-center">
                        <!-- Left Arrow -->
                        <button id="prev-video" class="text-white dark:text-white hover:text-gray-200 dark:hover:text-gray-300 focus:outline-none mr-2" aria-label="<?php esc_attr_e('Previous video', 'kikemonk'); ?>">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        
                        <!-- Right Arrow -->
                        <button id="next-video" class="text-white dark:text-white hover:text-gray-200 dark:hover:text-gray-300 focus:outline-none ml-2" aria-label="<?php esc_attr_e('Next video', 'kikemonk'); ?>">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        
                        <!-- Counter and Title -->
                        <div class="flex-1 ml-5">
                            <div class="flex items-center mb-2">
                                <span class="text-white dark:text-white text-sm font-medium video-counter">01</span>
                                <span class="text-white dark:text-white text-sm font-medium mx-1">/</span>
                                <span class="text-white dark:text-white text-sm font-medium" id="total-videos"><?php echo str_pad(count($videos), 2, '0', STR_PAD_LEFT); ?></span>
                                <?php if (!empty($videos[0]['titulo_del_video'])): ?>
                                    <span class="text-white dark:text-white text-sm font-medium ml-4 video-title"><?php echo esc_html($videos[0]['titulo_del_video']); ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="h-4 bg-white dark:bg-white bg-opacity-30 w-full">
                                <div class="h-full bg-white dark:bg-white transition-all duration-1000 ease-out" style="width: 0%" id="progress-bar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Flecha scroll hacia abajo -->
    <div class="absolute left-1/2 bottom-32 lg:bottom-10 z-50 -translate-x-1/2 animate-bounce">
        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="18" cy="18" r="17" fill="rgba(0,0,0,0.2)"/>
            <path d="M12 16l6 6 6-6" />
        </svg>
    </div>
</section>

<style>
.hero-block {
    position: relative;
    width: 100%;
    height: 100vh;
    overflow: hidden;
}

.hero-video-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.hero-video-container video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.hero-content {
    position: relative;
    z-index: 10;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

/* Asegurarse de que el overlay no tape los videos */
.absolute.inset-0.bg-black {
    z-index: 2;
    pointer-events: none;
}

/* Asegurar que los controles sean clickeables */
#video-dots,
#prev-video,
#next-video {
    position: relative;
    z-index: 20;
}
</style>

<script>
// Reemplaza todo el contenido del script actual por este:

document.addEventListener('DOMContentLoaded', function() {
    const block = document.querySelector('.hero-block');
    if (!block) return;

    const videos = Array.from(block.querySelectorAll('video'));
    const prevBtn = block.querySelector('#prev-video');
    const nextBtn = block.querySelector('#next-video');
    const progressBar = block.querySelector('#progress-bar');
    
    if (videos.length === 0) {
        console.error('No se encontraron videos en el hero');
        return;
    }

    console.log('Videos encontrados:', videos.length);
    videos.forEach((video, i) => {
        console.log(`Video ${i + 1}:`, video.src);
        video.load(); // Forzar carga de los videos
    });
    
    let currentVideoIndex = 0;
    let progressInterval;
    const VIDEO_DURATION = 5000;

    // Función para reproducir un video
    async function playVideo(index) {
    if (index < 0 || index >= videos.length) return false;
    
    console.log('Intentando reproducir video:', index);
    
    // Pausar todos los videos primero
    videos.forEach((v, i) => {
        v.pause();
        v.style.display = 'none';
        v.classList.remove('active');
    });
    
    const video = videos[index];
    video.style.display = 'block';
    video.classList.add('active');
    video.currentTime = 0;
    
    try {
        // Forzar un pequeño retraso para asegurar que el DOM se actualice
        await new Promise(resolve => setTimeout(resolve, 50));
        await video.play();
        console.log('Video reproducido con éxito:', index);
        return true;
    } catch (error) {
        console.error('Error al reproducir video:', error);
        console.log('Estado del video:', {
            readyState: video.readyState,
            error: video.error,
            networkState: video.networkState
        });
        return false;
    }
}

    // Actualizar la interfaz de usuario
    function updateUI() {
        // Actualizar contador
        const counter = block.querySelector('.video-counter');
        if (counter) {
            counter.textContent = String(currentVideoIndex + 1).padStart(2, '0');
        }
        
        // Actualizar título del video
        const videoTitle = block.querySelector('.video-title');
        if (videoTitle) {
            const currentVideoData = <?php echo json_encode($videos); ?>[currentVideoIndex];
            if (currentVideoData && currentVideoData.titulo_del_video) {
                videoTitle.textContent = currentVideoData.titulo_del_video;
            }
        }
    }

    // Iniciar barra de progreso
    function startProgressBar() {
        clearInterval(progressInterval);
        let width = 0;
        
        progressInterval = setInterval(() => {
            width += 1;
            if (progressBar) {
                progressBar.style.width = width + '%';
            }
            
            if (width >= 100) {
                nextVideo();
            }
        }, VIDEO_DURATION / 100);
    }

    // Navegación entre videos
    function nextVideo() {
        const nextIndex = (currentVideoIndex + 1) % videos.length;
        if (playVideo(nextIndex)) {
            currentVideoIndex = nextIndex;
            updateUI();
            startProgressBar();
        }
    }

    function prevVideo() {
        const prevIndex = (currentVideoIndex - 1 + videos.length) % videos.length;
        if (playVideo(prevIndex)) {
            currentVideoIndex = prevIndex;
            updateUI();
            startProgressBar();
        }
    }

    // Event Listeners
    if (nextBtn) nextBtn.addEventListener('click', nextVideo);
    if (prevBtn) prevBtn.addEventListener('click', prevVideo);

    // Iniciar con el primer video
    playVideo(0).then(success => {
        if (success) {
            updateUI();
            startProgressBar();
        }
    });


    // Manejar visibilidad
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                videos[currentVideoIndex].play().catch(console.error);
            } else {
                videos[currentVideoIndex].pause();
            }
        });
    }, { threshold: 0.5 });
    
    observer.observe(block);
});
</script>