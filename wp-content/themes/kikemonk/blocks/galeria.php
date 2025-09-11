<?php
/**
 * Block Name: Galería
 * Slug: galeria
 * Description: Bloque para mostrar una galería de imágenes.
 * Keywords: galería, imágenes, fotos, carrusel
 * Align: full
 */

$block_name = 'galeria';
$blockID = $block_name . '-' . $block['id'];
if (!empty(get_field('block_id'))) {
    $blockID = get_field('block_id');
}

$className = array($block_name);
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
$titulo = get_field('titulo');
$descripcion = get_field('descripcion');
$imagenes = get_field('imagenes');
$columnas = get_field('columnas') ?: 3;
$tipo_galeria = get_field('tipo_galeria') ?: 'grid'; // 'grid' o 'carrusel'
$mostrar_lightbox = get_field('mostrar_lightbox') ?: true;
?>

<section 
    id="<?= $blockID; ?>" 
    data-block="<?= $block_name; ?>" 
    class="<?php 
        echo implode(' ', $className); 
        echo ' galeria--' . esc_attr($tipo_galeria);
        echo ' galeria--columns-' . esc_attr($columnas);
    ?>"
    data-lightbox="<?= $mostrar_lightbox ? 'true' : 'false'; ?>"
>
    <div class="container">
        <?php if($titulo || $descripcion): ?>
            <div class="galeria__header">
                <?php if($titulo): ?>
                    <h2 class="galeria__title"><?= esc_html($titulo); ?></h2>
                <?php endif; ?>
                
                <?php if($descripcion): ?>
                    <div class="galeria__description">
                        <?= wp_kses_post($descripcion); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if($imagenes): ?>
            <div class="galeria__container">
                <?php foreach($imagenes as $imagen): ?>
                    <div class="galeria__item">
                        <?php if($mostrar_lightbox): ?>
                            <a href="<?= esc_url($imagen['url']); ?>" 
                               class="galeria__link" 
                               data-fancybox="galeria-<?= $blockID; ?>"
                               data-caption="<?= esc_attr($imagen['caption']); ?>"
                            >
                        <?php endif; ?>
                        
                        <img src="<?= esc_url($imagen['sizes']['large']); ?>" 
                             alt="<?= esc_attr($imagen['alt']); ?>" 
                             class="galeria__image"
                             loading="lazy">
                        
                        <?php if($mostrar_lightbox): ?>
                            </a>
                        <?php endif; ?>
                        
                        <?php if($imagen['caption']): ?>
                            <div class="galeria__caption">
                                <?= wp_kses_post($imagen['caption']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
