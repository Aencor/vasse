<?php
/**
 * Template Name: Archivo BTS
 * Template Post Type: bts
 */
get_header();
?>

<main id="primary" class="site-main py-16 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <!-- En la sección del header, cambia el título a: -->
        <header class="mb-16 text-center overflow-hidden py-20">
            <div class="flex flex-col items-center">
                <h1 class="bts-title text-5xl md:text-7xl font-bold mb-2 dark:text-white">
                    <span class="inline-block opacity-0" id="letter-b">B</span>
                    <span class="inline-block opacity-0" id="letter-t">T</span>
                    <span class="inline-block opacity-0" id="letter-s">S</span>
                </h1>
                <div class="subtitle-container h-8 overflow-hidden">
                    <div class="subtitle text-xl md:text-2xl text-gray-600 dark:text-gray-300 transform translate-y-full" id="behind-scenes-text">
                        Behind The Scenes
                    </div>
                </div>
                <div class="w-24 h-1 bg-primary mx-auto mt-6 transform scale-x-0 origin-left dark:bg-white" id="header-line"></div>
            </div>
        </header>

        <!-- Grid de posts 2x2 -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-5xl mx-auto">
            <?php if (have_posts()) : 
                while (have_posts()) : the_post(); 
                    $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
            ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('group relative'); ?>>
                        <a href="<?php the_permalink(); ?>" class="block h-full">
                            <div class="relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 h-full flex flex-col bg-white dark:bg-gray-800">
                                <?php if ($featured_img_url) : ?>
                                    <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                                        <img src="<?php echo esc_url($featured_img_url); ?>" 
                                             alt="<?php the_title_attribute(); ?>" 
                                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="p-6 flex-grow flex flex-col">
                                    <h2 class="h4 font-semibold mb-4 text-gray-900 dark:text-white group-hover:text-primary transition-colors">
                                        <?php the_title(); ?>
                                    </h2>
                                    <span class="mt-auto text-primary font-medium inline-flex items-center group-hover:underline dark:text-blue-400">
                                        Ver más
                                        <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
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
                    <p class="text-xl text-gray-900 dark:text-white">No se encontraron entradas de BTS.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof gsap !== 'undefined') {
        const tl = gsap.timeline({ defaults: { ease: "power3.out" } });
        
        // Animación de las letras B, T, S
        tl.to('#letter-b', {
            opacity: 1,
            y: 0,
            duration: 0.5,
            ease: "back.out(1.7)"
        })
        .to('#letter-t', {
            opacity: 1,
            y: 0,
            duration: 0.5,
            ease: "back.out(1.7)"
        }, "+=0.2")
        .to('#letter-s', {
            opacity: 1,
            y: 0,
            duration: 0.5,
            ease: "back.out(1.7)"
        }, "+=0.2")
        .to('.subtitle', {
            y: 0,
            duration: 0.8,
            ease: "power3.out"
        }, "-=0.2")
        .to('#header-line', {
            scaleX: 1,
            duration: 0.8,
            ease: "power2.out"
        }, "-=0.4");

        // Animación de escritura de "Behind The Scenes"
        const text = "Behind The Scenes";
        const element = document.getElementById("behind-scenes-text");
        let i = 0;
        
        function typeWriter() {
            if (i < text.length) {
                element.innerHTML = text.substring(0, i+1) + '<span class="opacity-0">' + text.substring(i+1) + '</span>';
                i++;
                setTimeout(typeWriter, 50); // Velocidad de escritura
            }
        }
        
        // Iniciar la animación de escritura cuando la línea del título esté completa
        setTimeout(typeWriter, 1800);

        // Animación de las tarjetas
        const cards = document.querySelectorAll('article');
        gsap.from(cards, {
            opacity: 0,
            y: 50,
            duration: 0.8,
            stagger: {
                each: 0.5,
                from: "start",
                ease: "power2.out"
            },
            delay: 2.5
        });
    }
});
</script>
<?php
get_footer();
?>