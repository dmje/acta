<?php
/**
 * Admin ajax functionality.
 *
 * @link       http://codexin.com
 * @since      1.0.0
 *
 * @package    Codexin\ImageMetadataSettings
 * @subpackage Codexin\ImageMetadataSettings/admin
 */

namespace Codexin\ImageMetadataSettings\Admin;

/**
 * Admin ajax functionality.
 */
class Admin_Ajax {
	/**
	 * Image metadata ajax action
	 *
	 * @return jsonstring
	 */
	public function image_metadata() {
		if (
			isset( $_POST['cx_nonce'] )
			&& isset( $_POST['type'] )
			&& isset( $_POST['value'] )
			&& isset( $_POST['image_id'] )
		) {
			$ajax_nonce = sanitize_text_field( wp_unslash( $_POST['cx_nonce'] ) );
			if ( ! wp_verify_nonce( $ajax_nonce, 'ajax-nonce' ) ) {
				return false;
			}
			$type         = sanitize_text_field( wp_unslash( $_POST['type'] ) );
			$image_id     = intval( $_POST['image_id'] );
			$update_value = '';
			if ( 'alt' === $type ) {
				$value = sanitize_text_field( wp_unslash( $_POST['value'] ) );
				update_post_meta( $image_id, '_wp_attachment_image_alt', $value );
				$update_value = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			}
			if ( 'description' === $type ) {
				$postarr = array(
					'ID'           => $image_id,
					'post_content' => wp_kses(
						wp_unslash( $_POST['value'] ),
						$this->content_allow_html()
					),
				);
				wp_update_post( $postarr );
				$attachment   = get_post( $image_id );
				$update_value = $attachment->post_content;
			}
			if ( 'caption' === $type ) {
				$postarr = array(
					'ID'           => $image_id,
					'post_excerpt' => wp_kses(
						wp_unslash( $_POST['value'] ),
						$this->content_allow_html()
					),
				);
				wp_update_post( $postarr );
				$attachment   = get_post( $image_id );
				$update_value = $attachment->post_excerpt;
			}
			wp_send_json( $update_value );
			wp_die();
		}
	}
	/**
	 * Bulk edit option.
	 */
	public function attachment_save_bulk_edit() {
		if (
			isset( $_POST['cx_nonce'] )
			&& isset( $_POST['alt'] )
			&& isset( $_POST['caption'] )
			&& isset( $_POST['description'] )
			&& isset( $_POST['text_change'] )
		) {
			$ajax_nonce = sanitize_text_field( wp_unslash( $_POST['cx_nonce'] ) );
			if ( ! wp_verify_nonce( $ajax_nonce, 'ajax-nonce' ) ) {
				return false;
			}
			if ( empty( $_POST['post_ids'] ) ) {
				die();
			}
			$alt         = sanitize_text_field( wp_unslash( $_POST['alt'] ) );
			$caption     = wp_kses(
				wp_unslash( $_POST['caption'] ),
				$this->content_allow_html()
			);
			$description = wp_kses(
				wp_unslash( $_POST['description'] ),
				$this->content_allow_html()
			);
			$post_ids    = sanitize_text_field( wp_unslash( $_POST['post_ids'] ) );
			$post_ids    = explode( ',', $post_ids );
			$text_change = trim( sanitize_text_field( wp_unslash( $_POST['text_change'] ) ) );

			if ( ucwords( $text_change ) !== ucwords( trim( $caption ) ) ) {
				$my_post['post_excerpt'] = $caption;
			}
			if ( ucwords( $text_change ) !== ucwords( trim( $description ) ) ) {
				$my_post['post_content'] = $description;
			}
			foreach ( $post_ids as $id ) {
				if ( ucwords( $text_change ) !== ucwords( trim( $alt ) ) ) {
					update_post_meta( $id, '_wp_attachment_image_alt', $alt );
				}
				$my_post['ID'] = $id;
				if ( 1 < count( $my_post ) ) {
					wp_update_post( $my_post );
				}
			}
		}
		$return = array(
			'message' => 'Saved',
			'status'  => true,
		);
		wp_send_json( $return );
	}
	/**
	 * Content Validation.
	 *
	 * @return array
	 */
	public function content_allow_html() {
		return array(
			'a'          => array(
				'href'   => array(),
				'title'  => array(),
				'target' => array(),
			),
			'br'         => array(),
			'em'         => array(),
			'strong'     => array(),
			'blockquote' => array(),
			'del'        => array(
				'datetime' => array(),
			),
			'ins'        => array(
				'datetime' => array(),
			),
			'img'        => array(
				'src' => array(),
				'alt' => array(),
			),
			'ul'         => array(),
			'ol'         => array(),
			'li'         => array(),
			'code'       => array(),
		);
	}
}
