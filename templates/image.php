<?php
/**
 * Template file for image field
 */

$thumb = '';
if ( $meta_val ) {
	$thumb = wp_get_attachment_url( $meta_val );
}

?>
<tr class="form-field">
	<th scope="row">
		<label for="cat-<?php echo esc_attr( $term_id ); ?>">Image</label>
	</th>
	<td>
		<input name="cat-<?php echo esc_attr( $meta_key ); ?>" type="hidden" value="<?php echo esc_attr( $meta_val ); ?>" size="40">
		<input id="cat-<?php echo esc_attr( $meta_key ); ?>" type="text" value="<?php echo esc_attr( $thumb ); ?>" size="40">
		<span class="description">Choose an image.</span>
		<div class="catcf-preview"<?php echo ( $thumb ) ? '' : ' style="display:none"'; ?>>
			<img src="<?php echo esc_url( $thumb ); ?>" alt="" width="200" />
			<a href="#" class="catcf-image-delete">Remove</a>
		</div>
		<a href="#" class="catcf-image-add"<?php echo ( ! $thumb ) ? '' : ' style="display:none"'; ?>>Add</a>
	</td>

</tr>
