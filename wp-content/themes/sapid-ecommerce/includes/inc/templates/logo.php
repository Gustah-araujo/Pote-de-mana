<?php
/**
 * Logo template.
 *
 * @author     Sapid
 * @copyright  (c) Copyright by oozeit
 * @link       https://itooze.com
 * @package    Sapid
 * @subpackage Core
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$logo_opening_markup = '<div class="';
$logo_closing_markup = '</div>';

echo $logo_opening_markup; // phpcs:ignore WordPress.Security.EscapeOutput ?>sapid-logo">
<?php
	/**
	 * The sapid_logo_prepend hook.
	 */
	do_action( 'sapid_logo_prepend' );

	$logo_anchor_tag_attributes       = '';
	$custom_link                      = sapid_get_theme_option( 'logo-custom-link' );
	$logo_anchor_tag_attributes_array = apply_filters(
		'sapid_logo_anchor_tag_attributes',
		[
			'class' => 'sapid-logo-link navbar-brand',
			'href'  => $custom_link ? esc_url( $custom_link ) : esc_url( home_url( '/' ) ), // phpcs:ignore WordPress.CodeAnalysis.AssignmentInCondition.FoundInTernaryCondition
		]
	);

	foreach ( $logo_anchor_tag_attributes_array as $attribute => $value ) {
		if ( 'href' === $attribute ) {
			$value = esc_url( $value );
		} else {
			$value = esc_attr( $value );
		}

		$logo_anchor_tag_attributes .= ' ' . $attribute . '="' . $value . '" ';
	}

	$logo_alt_attribute = apply_filters( 'sapid_logo_alt_tag', get_bloginfo( 'name', 'display' ) . ' ' . __( 'Logo', 'Sapid' ) );
	?>
	<?php if ( ( sapid_get_theme_option( 'logo' ) && '' !== sapid_get_theme_option( 'logo' ) ) || ( sapid_get_theme_option( 'logo_retina' ) && '' !== sapid_get_theme_option( 'logo_retina' ) ) ) : ?>
		<a<?php echo $logo_anchor_tag_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
			<?php $standard_logo = get_sapid_logo_image_srcset( 'logo', 'logo-retina' ); ?>
			<!-- standard logo -->
			<img  src="<?php echo esc_url_raw( $standard_logo['url'] ); ?>" srcset="<?php echo esc_attr( $standard_logo['srcset'] ); ?>" width="<?php echo esc_attr( $standard_logo['width'] ); ?>" height="<?php echo esc_attr( $standard_logo['height'] ); ?>"<?php echo $standard_logo['style']; // phpcs:ignore WordPress.Security.EscapeOutput ?> alt="<?php echo esc_attr( $logo_alt_attribute ); ?>" data-retina_logo_url="<?php echo esc_url_raw( $standard_logo['is_retina'] ); ?>" class="sapid-standard-logo" />
		</a>
	<?php else: 
		$logo_url = get_template_directory_uri().'/assets/images/logo.png';
		$logo_retina_url = get_template_directory_uri().'/assets/images/logo@2x.png';
		?> 
		<a<?php echo $logo_anchor_tag_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
			<img src="<?php echo esc_url_raw( $logo_url ); ?>" srcset="<?php echo esc_url_raw( $logo_url ); ?> 1x, <?php echo esc_url_raw( $logo_retina_url ); ?> 2x" width="192" height="26" style="max-height:28px;height:auto;" alt="<?php echo esc_attr( $logo_alt_attribute ); ?>" data-retina_logo_url="<?php echo esc_url_raw( $logo_retina_url ); ?>" class="sapid-standard-logo">
		</a>
	<?php endif; ?>
	<?php
	/**
	 * The sapid_logo_append hook.
	 *
	 * @hooked sapid_header_content_3 - 10.
	 */
	do_action( 'sapid_logo_append' );

	?>
<?php
echo $logo_closing_markup; // phpcs:ignore WordPress.Security.EscapeOutput