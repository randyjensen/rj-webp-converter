<?php

/**
 * Delete WebP images when deleting regular images
 */
function delete_post_attachments($post_id) {
	global $post_type;

	if (!$post_type) {
  	$p = get_post($post_id);
  	$post_type = $p->post_type;
	}

	$p = get_post($post_id);
	$guid = $p->guid;
	$guid_parts = explode('/', $guid);

	$intermediate_sizes = array();
		foreach ( get_intermediate_image_sizes() as $size ) {
			if ( $intermediate = image_get_intermediate_size( $post_id, $size ) )
		$intermediate_sizes[] = $intermediate;
	}

	if ($post_type == 'attachment') {
		$filename = end($guid_parts);

		// Make sure we only delete images that are jpg || png
		if (preg_match('/\.(jpe?g|png)$/i', $filename) === 1) {
			$filename = preg_replace('/\.(jpe?g|png)$/i', '', $filename);
			$month = $guid_parts[count($guid_parts)-2];
			$year = $guid_parts[count($guid_parts)-3];

			$dir = wp_upload_dir()['path'];
			$file = $dir . '/' . $filename;

			// Delete initial file
			if (file_exists($file . '.webp')) unlink($file . '.webp');

			// Start looping to delete other sizes
			if ($intermediate_sizes) {
				foreach ($intermediate_sizes as $size) {
					$filename = $size['file'];
					$filename = preg_replace('/\.(jpe?g|png)$/i', '', $filename);

					$file = $dir . '/' . $filename;
					if (file_exists($file . '.webp')) unlink($file . '.webp');
				}
			}
		}
	}
}
add_action('delete_post', 'delete_post_attachments');
add_action('delete_attachment', 'delete_post_attachments');

/**
 * Create WebP image on image upload
 */
function create_webp_images_on_upload($metadata, $attachment_id) {
	$dir = wp_upload_dir();
	$dir = $dir['basedir'] . '/' . $metadata['file'];

	// Create the initial images webp counterpart
	create_webp($dir, $metadata);

	$new_dir = explode('/', $dir);
	array_pop($new_dir);
	$new_path = implode('/', $new_dir);

	// Now create webp images for all the custom sizes
	foreach ($metadata['sizes'] as $size) {
		$full_new_path = $new_path . '/' . $size['file'];
		create_webp($full_new_path, $metadata);
	}

	return $metadata;
}
add_filter('wp_generate_attachment_metadata', 'create_webp_images_on_upload', 9999, 2);

/**
 * Create WebP images
 *
 * @params
 *
 * $dir : pass full path to image, eg. /Users/user/Sites/thesite/wp-content/uploads/family-guy.jpg
 * $metadata : image metadata
 */
function create_webp($dir, $metadata) {
  $cwebp = plugin_dir_path( __FILE__ );
  $cwebp = str_replace('includes/lib/', '', $cwebp);
  $cwebp = $cwebp . 'libs/libwebp-0.4.1-rc1-linux-x86-32/bin/cwebp';

	if (strpos($metadata['file'], '.png') !== false) {
		$webp_dir = str_replace('.png', '.webp', $dir);
		$output = exec($cwebp . ' -q 80 ' . $dir.' -o ' . $webp_dir . ' 2>&1 &');
		if (WP_DEBUG) echo "<pre>$output</pre>";
	}
	if (strpos($metadata['file'], '.jpg') !== false) {
		$webp_dir = str_replace('.jpg', '.webp', $dir);
		$output = exec($cwebp . ' -q 80 ' . $dir . ' -o ' . $webp_dir . ' 2>&1 &');
		if (WP_DEBUG) echo "<pre>$output</pre>";
	}
}
