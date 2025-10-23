<?php
/**
 * Block Name: Servicios
 * Slug: servicios
 * Description: Block Description.
 * Keywords: block tags
 * Align: full
 */

$block_name = 'servicios-block';
$blockID = $block_name . '-' . $block['id'];
if (!empty(get_field('block_id'))) {
	$blockID = get_field('block_id');
}
$className   = array( $block_name );
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
$title = get_field('title');

// Obtener los términos de la taxonomía 'tipo'
$terms = get_terms(array(
    'taxonomy' => 'tipo',
    'hide_empty' => false,
));
?>

<section 
id="<?= $blockID; ?>" 
data-block="servicios-block" 
class="w-full <?php echo implode( ' ', $className ); ?>"
>	
	<div class="block-hero">
		<h1><?= $title; ?></h1>
	</div>
	<div class="servicios-grid">
<?php
if (!empty($terms) && !is_wp_error($terms)) :
    foreach ($terms as $term) :
        $term_name = $term->name;
        $term_desc = $term->description;
        $term_link = get_term_link($term);
        $term_portada = get_field('portada', $term); // ACF: portada en la taxonomía
        $term_count = $term->count;
?>
        <div class="servicio-item" style="<?php if(!empty($term_portada)) { ?>background-image: url('<?= esc_url($term_portada); ?>');<?php } ?>">
            <div class="servicio-content">
                <h3><?= esc_html($term_name); ?></h3>
                <p><?= esc_html($term_desc); ?></p>
                <?php if ($term_count > 0 && !is_wp_error($term_link)) : ?>
                    <a class="btn btn-medium btn-secondary" href="<?= esc_url($term_link); ?>">Ver Producciones</a>
                <?php endif; ?>
            </div>
        </div>
<?php
    endforeach;
endif;
?>
</div>
</section>