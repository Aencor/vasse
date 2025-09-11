<?php
/**
 * Block Name: Texto
 * Slug: texto
 * Description: Bloque para mostrar contenido de texto enriquecido.
 * Keywords: texto, contenido, editor, html
 * Align: full
 */

$block_name = 'texto';
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
$contenido = get_field('contenido');
$ancho = get_field('ancho_contenido') ?: 'normal'; // 'normal' o 'ancho-completo'
$alineacion = get_field('alineacion_texto') ?: 'izquierda'; // 'izquierda', 'centro', 'derecha'
?>

<section 
    id="<?= $blockID; ?>" 
    data-block="<?= $block_name; ?>" 
    class="<?php 
        echo implode(' ', $className); 
        echo ' texto--' . esc_attr($ancho);
        echo ' texto--align-' . esc_attr($alineacion);
    ?>"
>
    <div class="container">
        <div class="texto__content">
            <?php if($contenido): ?>
                <div class="texto__editor">
                    <?= $contenido; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
