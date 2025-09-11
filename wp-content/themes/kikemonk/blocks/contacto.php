<?php
/**
 * Block Name: Contacto
 * Slug: contacto
 * Description: Bloque para mostrar información de contacto y formulario.
 * Keywords: contacto, formulario, email, teléfono
 * Align: full
 */

$block_name = 'contacto';
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
$titulo = get_field('titulo') ?: 'Contáctanos';
$descripcion = get_field('descripcion');
$form_shortcode = get_field('formulario_shortcode');
$info_contacto = get_field('informacion_contacto');
?>

<section 
    id="<?= $blockID; ?>" 
    data-block="<?= $block_name; ?>" 
    class="<?php echo implode(' ', $className); ?>"
>
    <div class="container">
        <div class="contacto__grid">
            <div class="contacto__info">
                <h2 class="contacto__title"><?= esc_html($titulo); ?></h2>
                
                <?php if($descripcion): ?>
                    <div class="contacto__description">
                        <?= wp_kses_post($descripcion); ?>
                    </div>
                <?php endif; ?>

                <?php if($info_contacto): ?>
                    <div class="contacto__details
                        <?php foreach($info_contacto as $item): ?>
                            <div class="contacto__detail-item">
                                <?php if($item['icono']): ?>
                                    <span class="contacto__icon"><?= $item['icono']; ?></span>
                                <?php endif; ?>
                                <div class="contacto__text">
                                    <?php if($item['titulo']): ?>
                                        <h4 class="contacto__detail-title"><?= esc_html($item['titulo']); ?></h4>
                                    <?php endif; ?>
                                    <?php if($item['contenido']): ?>
                                        <div class="contacto__detail-content">
                                            <?= wp_kses_post($item['contenido']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($form_shortcode): ?>
                <div class="contacto__form">
                    <?php echo do_shortcode($form_shortcode); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
