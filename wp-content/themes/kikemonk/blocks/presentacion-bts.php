<?php
/**
 * Block Name: Presentación BTS
 * Slug: presentacion-bts
 * Description: Bloque para mostrar contenido detrás de cámaras.
 * Keywords: bts, behind the scenes, video, galería
 * Align: full
 */

$block_name = 'presentacion-bts';
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
$titulo = get_field('titulo') ?: 'Detrás de cámaras';
$descripcion = get_field('descripcion');
$media = get_field('tipo_media'); // 'video' o 'imagen'
$video_url = get_field('video_url');
$imagen = get_field('imagen');
?>

<section 
    id="<?= $blockID; ?>" 
    data-block="<?= $block_name; ?>" 
    class="<?php echo implode(' ', $className); ?>"
>
    <div class="container">
        <div class="presentacion-bts__header">
            <h2 class="presentacion-bts__title"><?= esc_html($titulo); ?></h2>
            <?php if($descripcion): ?>
                <div class="presentacion-bts__description">
                    <?= wp_kses_post($descripcion); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="presentacion-bts__media">
            <?php if($media === 'video' && $video_url): ?>
                <div class="video-container">
                    <?php echo wp_oembed_get($video_url); ?>
                </div>
            <?php elseif($media === 'imagen' && $imagen): ?>
                <div class="image-container">
                    <img src="<?= esc_url($imagen['url']); ?>" 
                         alt="<?= esc_attr($imagen['alt']); ?>" 
                         class="presentacion-bts__image">
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
