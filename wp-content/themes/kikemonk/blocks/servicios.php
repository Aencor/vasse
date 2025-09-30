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
$servicios = get_field('servicios');
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
		<?php foreach ($servicios as $servicio) { ?>
			<div class="servicio-item" style="<?php if(!empty($servicio['image'])) { ?>background-image: url('<?= $servicio['image']; ?>');<?php } ?>">
				<div class="servicio-content">
					<h3><?= $servicio['title']; ?></h3>
					<p><?= $servicio['descripcion']; ?></p>
				</div>
			</div>
		<?php } ?>
	</div>
</section>