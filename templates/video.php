<?php
/**
 * Template file for video field
 */
$video_thumb = '';
if ( false !== strpos( $meta_val, 'youtube.com' ) || false !== strpos( $meta_val, 'youtu.be' ) ) {

	$video_id = '';
	if ( preg_match( '/watch\?v=(.+)/i', $meta_val, $match ) ) {
		$video_id = $match[1];
		$video_id = explode( '&', $video_id );
		$video_id = $video_id[0];
	} else {
		$video_id = explode( '?', $meta_val );
		$video_id = explode( '/', $video_id[0] );
		$video_id = end( $video_id );
	}

	if ( $video_id ) {
		$video_thumb = 'https://i.ytimg.com/vi/' . $video_id . '/hqdefault.jpg';
	}
} elseif ( false !== strpos( $meta_val, 'vimeo.com' ) ) {
	$video_id = explode( '?', $meta_val );
	$video_id = explode( 'player.vimeo.com/video/', $video_id[0] );
	if ( false !== strpos( $video_id[0], 'vimeo.com' ) ) {
		$video_id = explode( 'vimeo.com/', $video_id[0] );
	}
	if ( ! empty( $video_id[1] ) ) {
		$data = file_get_contents( "http://vimeo.com/api/v2/video/{$video_id[1]}.json" );
		if ( $data ) {
			$data = json_decode( $data );
			if ( ! empty( $data[0]->thumbnail_medium ) ) {
				$video_thumb = $data[0]->thumbnail_medium;
			}
		}
	}
}
?>
<tr class="form-field">
	<th scope="row">
		<label for="cat-<?php echo esc_attr( $term_id ); ?>">Video</label>
	</th>
	<td>
		<input name="cat-<?php echo esc_attr( $meta_key ); ?>" id="cat-<?php echo esc_attr( $meta_key ); ?>" type="text" value="<?php echo esc_attr( $meta_val ); ?>" size="40">
		<div class="description">Insert Youtube or Vimeo video link.</div>
		<div class="catcf-preview"<?php echo ( $video_thumb ) ? '' : ' style="display:none"'; ?>>
			<img src="<?php echo esc_url( $video_thumb ); ?>" alt="" width="200" />
			<a href="#" class="catcf-video-delete">Remove</a>
		</div>
	</td>

</tr>
