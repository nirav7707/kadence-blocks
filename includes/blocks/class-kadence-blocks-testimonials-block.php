<?php
/**
 * Class to Build the Testimonial Block.
 *
 * @package Kadence Blocks
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class to Build the Testimonials Block.
 *
 * @category class
 */
class Kadence_Blocks_Testimonials_Block extends Kadence_Blocks_Abstract_Block {

	/**
	 * Instance of this class
	 *
	 * @var null
	 */
	private static $instance = null;

	/**
	 * Block name within this namespace.
	 *
	 * @var string
	 */
	protected $block_name = 'testimonials';

	/**
	 * Block determines in scripts need to be loaded for block.
	 *
	 * @var string
	 */
	protected $has_script = true;

	/**
	 * Instance Control
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Builds CSS for block.
	 *
	 * @param array $attributes the blocks attributes.
	 * @param Kadence_Blocks_CSS $css the css class for blocks.
	 * @param string $unique_id the blocks attr ID.
	 */
	public function build_css( $attributes, $css, $unique_id ) {

		$css->set_style_id( 'kb-' . $this->block_name . $unique_id );

		/* Load any Google fonts that are needed */
		$attributes_with_fonts = array( 'titleFont', 'contentFont', 'nameFont', 'occupationFont' );
		foreach ( $attributes_with_fonts as $attribute_font_key ) {
			if ( isset( $attributes[ $attribute_font_key ][0] ) && isset( $attributes[ $attribute_font_key ][0]['google'] ) && ( ! isset( $attributes[ $attribute_font_key ][0]['loadGoogle'] ) || true === $attributes[ $attribute_font_key ][0]['loadGoogle'] ) && isset( $attributes[ $attribute_font_key ][0]['family'] ) ) {
				$title_font = $attributes[ $attribute_font_key ][0];

				$font_variant = isset( $title_font['variant'] ) ? $title_font['variant'] : null;
				$font_subset  = isset( $title_font['subset'] ) ? $title_font['subset'] : null;

				$css->maybe_add_google_font( $title_font['family'], $font_variant, $font_subset );
			}
		}

		/* Tiny slider is required if we're using a carousel layout */
		if ( isset( $attributes['layout'] ) && 'carousel' === $attributes['layout'] ) {
			$this->enqueue_style( 'kadence-blocks-tiny-slider' );
			$this->enqueue_script( 'kadence-blocks-tiny-slider-init' );
		}

		/*
		 *  Wrapper padding
		 */
		$wrapper_padding_type = ! empty( $attributes['wrapperPaddingType'] ) ? $attributes['wrapperPaddingType'] : 'px';

		$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id );

		// Desktop wrapper padding L/R
		if ( isset( $attributes['wrapperPadding'][1] ) && is_numeric( $attributes['wrapperPadding'][1] ) ) {
			$css->add_property( 'padding-right', $attributes['wrapperPadding'][1] . $wrapper_padding_type );
		}
		if ( isset( $attributes['wrapperPadding'][3] ) && is_numeric( $attributes['wrapperPadding'][3] ) ) {
			$css->add_property( 'padding-left', $attributes['wrapperPadding'][3] . $wrapper_padding_type );
		}

		// Tablet wrapper padding L/R
		$css->set_media_state( 'tablet' );
		if ( isset( $attributes['wrapperTabletPadding'][1] ) && is_numeric( $attributes['wrapperTabletPadding'][1] ) ) {
			$css->add_property( 'padding-right', $attributes['wrapperTabletPadding'][1] . $wrapper_padding_type );
		}
		if ( isset( $attributes['wrapperTabletPadding'][3] ) && is_numeric( $attributes['wrapperTabletPadding'][3] ) ) {
			$css->add_property( 'padding-left', $attributes['wrapperTabletPadding'][3] . $wrapper_padding_type );
		}

		// Mobile wrapper padding L/R
		$css->set_media_state( 'mobile' );
		if ( isset( $attributes['wrapperMobilePadding'][1] ) && is_numeric( $attributes['wrapperMobilePadding'][1] ) ) {
			$css->add_property( 'padding-right', $attributes['wrapperMobilePadding'][1] . $wrapper_padding_type );
		}
		if ( isset( $attributes['wrapperMobilePadding'][3] ) && is_numeric( $attributes['wrapperMobilePadding'][3] ) ) {
			$css->add_property( 'padding-left', $attributes['wrapperMobilePadding'][3] . $wrapper_padding_type );
		}
		$css->set_media_state( 'desktop' );
		/*
		 * If the layout style is carousel, we set the top & bottom wrapper padding on the carousel item instead of the wrapper
		 */
		if ( isset( $attributes['layout'] ) && 'carousel' === $attributes['layout'] ) {
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-blocks-carousel .kt-blocks-testimonial-carousel-item' );
		}

		// Desktop wrapper padding T/B
		if ( isset( $attributes['wrapperPadding'][0] ) && is_numeric( $attributes['wrapperPadding'][0] ) ) {
			$css->add_property( 'padding-top', $attributes['wrapperPadding'][0] . $wrapper_padding_type );
		}
		if ( isset( $attributes['wrapperPadding'][2] ) && is_numeric( $attributes['wrapperPadding'][2] ) ) {
			$css->add_property( 'padding-bottom', $attributes['wrapperPadding'][2] . $wrapper_padding_type );
		}

		// Tablet wrapper padding T/B
		$css->set_media_state( 'tablet' );
		if ( isset( $attributes['wrapperTabletPadding'][0] ) && is_numeric( $attributes['wrapperTabletPadding'][0] ) ) {
			$css->add_property( 'padding-top', $attributes['wrapperTabletPadding'][0] . $wrapper_padding_type );
		}
		if ( isset( $attributes['wrapperTabletPadding'][2] ) && is_numeric( $attributes['wrapperTabletPadding'][2] ) ) {
			$css->add_property( 'padding-bottom', $attributes['wrapperTabletPadding'][2] . $wrapper_padding_type );
		}

		// Mobile wrapper padding T/B
		$css->set_media_state( 'mobile' );
		if ( isset( $attributes['wrapperMobilePadding'][0] ) && is_numeric( $attributes['wrapperMobilePadding'][0] ) ) {
			$css->add_property( 'padding-top', $attributes['wrapperMobilePadding'][0] . $wrapper_padding_type );
		}
		if ( isset( $attributes['wrapperMobilePadding'][2] ) && is_numeric( $attributes['wrapperMobilePadding'][2] ) ) {
			$css->add_property( 'padding-bottom', $attributes['wrapperMobilePadding'][2] . $wrapper_padding_type );
		}
		$css->set_media_state( 'desktop' );


		/*
		 * columnGap
		 */
		if ( isset( $attributes['layout'] ) && 'carousel' === $attributes['layout'] && isset( $attributes['columnGap'] ) && ! empty( $attributes['columnGap'] ) ) {
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-blocks-carousel .kt-blocks-testimonial-carousel-item' );
			$css->add_property( 'padding', '0 ' . ( $attributes['columnGap'] / 2 ) . 'px' );
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-blocks-carousel' );
			$css->add_property( 'margin', '0 -' . ( $attributes['columnGap'] / 2 ) . 'px' );
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-blocks-carousel .slick-prev' );
			$css->add_property( 'left', ( $attributes['columnGap'] / 2 ) . 'px' );
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-blocks-carousel .slick-next' );
			$css->add_property( 'right', ( $attributes['columnGap'] / 2 ) . 'px' );
		}


		if ( isset( $attributes['style'] ) && ( 'bubble' === $attributes['style'] || 'inlineimage' === $attributes['style'] ) ) {
			$css->set_selector( '.wp-block-kadence-testimonials.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-text-wrap:after' );
			if ( isset( $attributes['containerBorderWidth'] ) && is_array( $attributes['containerBorderWidth'] ) && ! empty( $attributes['containerBorderWidth'][2] ) ) {
				$css->add_property( 'margin-top', $attributes['containerBorderWidth'][2] . 'px' );
			}
			if ( isset( $attributes['containerBorder'] ) && ! empty( $attributes['containerBorder'] ) ) {
				$alpha = ( isset( $attributes['containerBorderOpacity'] ) && is_numeric( $attributes['containerBorderOpacity'] ) ? $attributes['containerBorderOpacity'] : 1 );
				$css->add_property( 'border-top-color', $css->render_color( $attributes['containerBorder'], $alpha ) );
			}
		}


		$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-item-wrap' );

		/* Container Padding */
		$css->render_measure_output( $attributes, 'containerPadding', 'padding' );

		/* Container min-height */
		$css->render_responsive_range( $attributes, 'containerMinHeight', 'min-height' );

		if ( ( isset( $attributes['titleFont'] ) && is_array( $attributes['titleFont'] ) && is_array( $attributes['titleFont'][0] ) ) || ( isset( $attributes['titleMinHeight'] ) && is_array( $attributes['titleMinHeight'] ) && isset( $attributes['titleMinHeight'][0] ) && is_numeric( $attributes['titleMinHeight'][0] ) ) ) {
			$title_font = $attributes['titleFont'][0];
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-item-wrap .kt-testimonial-title' );
			if ( isset( $title_font['color'] ) && ! empty( $title_font['color'] ) ) {
				$css->add_property( 'color', $css->render_color( $title_font['color'] ) );
			}
			if ( isset( $title_font['size'] ) && is_array( $title_font['size'] ) && ! empty( $title_font['size'][0] ) ) {
				$css->add_property( 'font-size', $title_font['size'][0] . ( ! isset( $title_font['sizeType'] ) ? 'px' : $title_font['sizeType'] ) );
			}
			if ( isset( $title_font['lineHeight'] ) && is_array( $title_font['lineHeight'] ) && ! empty( $title_font['lineHeight'][0] ) ) {
				$css->add_property( 'line-height', $title_font['lineHeight'][0] . ( ! isset( $title_font['lineType'] ) ? 'px' : $title_font['lineType'] ) );
			}
			if ( isset( $title_font['letterSpacing'] ) && ! empty( $title_font['letterSpacing'] ) ) {
				$css->add_property( 'letter-spacing', $title_font['letterSpacing'] . 'px' );
			}
			if ( isset( $title_font['textTransform'] ) && ! empty( $title_font['textTransform'] ) ) {
				$css->add_property( 'text-transform', $title_font['textTransform'] );
			}
			if ( isset( $title_font['family'] ) && ! empty( $title_font['family'] ) ) {
				$css->add_property( 'font-family', $css->render_font_family( $title_font['family'] ) );
			}
			if ( isset( $title_font['style'] ) && ! empty( $title_font['style'] ) ) {
				$css->add_property( 'font-style', $title_font['style'] );
			}
			if ( isset( $title_font['weight'] ) && ! empty( $title_font['weight'] ) && 'regular' !== $title_font['weight'] ) {
				$css->add_property( 'font-weight', $css->render_font_weight( $title_font['weight'] ) );
			}
			if ( isset( $title_font['margin'] ) && is_array( $title_font['margin'] ) && isset( $title_font['margin'][0] ) && is_numeric( $title_font['margin'][0] ) ) {
				$css->add_property( 'margin-top', $title_font['margin'][0] . 'px' );
			}
			if ( isset( $title_font['margin'] ) && is_array( $title_font['margin'] ) && isset( $title_font['margin'][1] ) && is_numeric( $title_font['margin'][1] ) ) {
				$css->add_property( 'margin-right', $title_font['margin'][1] . 'px' );
			}
			if ( isset( $title_font['margin'] ) && is_array( $title_font['margin'] ) && isset( $title_font['margin'][2] ) && is_numeric( $title_font['margin'][2] ) ) {
				$css->add_property( 'margin-bottom', $title_font['margin'][2] . 'px' );
			}
			if ( isset( $title_font['margin'] ) && is_array( $title_font['margin'] ) && isset( $title_font['margin'][3] ) && is_numeric( $title_font['margin'][3] ) ) {
				$css->add_property( 'margin-left', $title_font['margin'][3] . 'px' );
			}
			if ( isset( $title_font['padding'] ) && is_array( $title_font['padding'] ) && isset( $title_font['padding'][0] ) && is_numeric( $title_font['padding'][0] ) ) {
				$css->add_property( 'padding-top', $title_font['padding'][0] . 'px' );
			}
			if ( isset( $title_font['padding'] ) && is_array( $title_font['padding'] ) && isset( $title_font['padding'][1] ) && is_numeric( $title_font['padding'][1] ) ) {
				$css->add_property( 'padding-right', $title_font['padding'][1] . 'px' );
			}
			if ( isset( $title_font['padding'] ) && is_array( $title_font['padding'] ) && isset( $title_font['padding'][2] ) && is_numeric( $title_font['padding'][2] ) ) {
				$css->add_property( 'padding-bottom', $title_font['padding'][2] . 'px' );
			}
			if ( isset( $title_font['padding'] ) && is_array( $title_font['padding'] ) && isset( $title_font['padding'][3] ) && is_numeric( $title_font['padding'][3] ) ) {
				$css->add_property( 'padding-left', $title_font['padding'][3] . 'px' );
			}
			if ( isset( $attributes['titleMinHeight'] ) && is_array( $attributes['titleMinHeight'] ) && isset( $attributes['titleMinHeight'][0] ) && is_numeric( $attributes['titleMinHeight'][0] ) ) {
				$css->add_property( 'min-height', $attributes['titleMinHeight'][0] . 'px' );
			}
		}


		if ( ( isset( $attributes['titleFont'] ) && is_array( $attributes['titleFont'] ) && isset( $attributes['titleFont'][0] ) && is_array( $attributes['titleFont'][0] ) && ( ( isset( $attributes['titleFont'][0]['size'] ) && is_array( $attributes['titleFont'][0]['size'] ) && isset( $attributes['titleFont'][0]['size'][1] ) && ! empty( $attributes['titleFont'][0]['size'][1] ) ) || ( isset( $attributes['titleFont'][0]['lineHeight'] ) && is_array( $attributes['titleFont'][0]['lineHeight'] ) && isset( $attributes['titleFont'][0]['lineHeight'][1] ) && ! empty( $attributes['titleFont'][0]['lineHeight'][1] ) ) ) ) || ( isset( $attributes['titleMinHeight'] ) && is_array( $attributes['titleMinHeight'] ) && isset( $attributes['titleMinHeight'][1] ) && is_numeric( $attributes['titleMinHeight'][1] ) ) ) {
			$css->set_media_state( 'tablet' );
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-item-wrap .kt-testimonial-title' );
			if ( isset( $attributes['titleFont'][0]['size'][1] ) && ! empty( $attributes['titleFont'][0]['size'][1] ) ) {
				$css->add_property( 'font-size', $attributes['titleFont'][0]['size'][1] . ( ! isset( $attributes['titleFont'][0]['sizeType'] ) ? 'px' : $attributes['titleFont'][0]['sizeType'] ) );
			}
			if ( isset( $attributes['titleFont'][0]['lineHeight'][1] ) && ! empty( $attributes['titleFont'][0]['lineHeight'][1] ) ) {
				$css->add_property( 'line-height', $attributes['titleFont'][0]['lineHeight'][1] . ( ! isset( $attributes['titleFont'][0]['lineType'] ) ? 'px' : $attributes['titleFont'][0]['lineType'] ) );
			}
			if ( isset( $attributes['titleMinHeight'] ) && is_array( $attributes['titleMinHeight'] ) && isset( $attributes['titleMinHeight'][1] ) && is_numeric( $attributes['titleMinHeight'][1] ) ) {
				$css->add_property( 'min-height', $attributes['titleMinHeight'][1] . 'px' );
			}
			$css->set_media_state( 'desktop' );
		}

		if ( ( isset( $attributes['titleFont'] ) && is_array( $attributes['titleFont'] ) && isset( $attributes['titleFont'][0] ) && is_array( $attributes['titleFont'][0] ) && ( ( isset( $attributes['titleFont'][0]['size'] ) && is_array( $attributes['titleFont'][0]['size'] ) && isset( $attributes['titleFont'][0]['size'][2] ) && ! empty( $attributes['titleFont'][0]['size'][2] ) ) || ( isset( $attributes['titleFont'][0]['lineHeight'] ) && is_array( $attributes['titleFont'][0]['lineHeight'] ) && isset( $attributes['titleFont'][0]['lineHeight'][2] ) && ! empty( $attributes['titleFont'][0]['lineHeight'][2] ) ) ) ) || ( isset( $attributes['titleMinHeight'] ) && is_array( $attributes['titleMinHeight'] ) && isset( $attributes['titleMinHeight'][1] ) && is_numeric( $attributes['titleMinHeight'][1] ) ) ) {
			$css->set_media_state( 'mobile' );
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-item-wrap .kt-testimonial-title' );
			if ( isset( $attributes['titleFont'][0]['size'][2] ) && ! empty( $attributes['titleFont'][0]['size'][2] ) ) {
				$css->add_property( 'font-size', $attributes['titleFont'][0]['size'][2] . ( ! isset( $attributes['titleFont'][0]['sizeType'] ) ? 'px' : $attributes['titleFont'][0]['sizeType'] ) );
			}
			if ( isset( $attributes['titleFont'][0]['lineHeight'][2] ) && ! empty( $attributes['titleFont'][0]['lineHeight'][2] ) ) {
				$css->add_property( 'line-height', $attributes['titleFont'][0]['lineHeight'][2] . ( ! isset( $attributes['titleFont'][0]['lineType'] ) ? 'px' : $attributes['titleFont'][0]['lineType'] ) );
			}
			if ( isset( $attributes['titleMinHeight'] ) && is_array( $attributes['titleMinHeight'] ) && isset( $attributes['titleMinHeight'][2] ) && is_numeric( $attributes['titleMinHeight'][2] ) ) {
				$css->add_property( 'min-height', $attributes['titleMinHeight'][2] . 'px' );
			}
			$css->set_media_state( 'desktop' );
		}
		if ( ( isset( $attributes['contentFont'] ) && is_array( $attributes['contentFont'] ) && is_array( $attributes['contentFont'][0] ) ) || ( isset( $attributes['contentMinHeight'] ) && is_array( $attributes['contentMinHeight'] ) && isset( $attributes['contentMinHeight'][0] ) && is_numeric( $attributes['contentMinHeight'][0] ) ) ) {
			$content_font = $attributes['contentFont'][0];
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-content' );
			if ( isset( $content_font['color'] ) && ! empty( $content_font['color'] ) ) {
				$css->add_property( 'color', $css->render_color( $content_font['color'] ) );
			}
			if ( isset( $content_font['size'] ) && is_array( $content_font['size'] ) && ! empty( $content_font['size'][0] ) ) {
				$css->add_property( 'font-size', $content_font['size'][0] . ( ! isset( $content_font['sizeType'] ) ? 'px' : $content_font['sizeType'] ) );
			}
			if ( isset( $content_font['lineHeight'] ) && is_array( $content_font['lineHeight'] ) && ! empty( $content_font['lineHeight'][0] ) ) {
				$css->add_property( 'line-height', $content_font['lineHeight'][0] . ( ! isset( $content_font['lineType'] ) ? 'px' : $content_font['lineType'] ) );
			}
			if ( isset( $content_font['letterSpacing'] ) && ! empty( $content_font['letterSpacing'] ) ) {
				$css->add_property( 'letter-spacing', $content_font['letterSpacing'] . 'px' );
			}
			if ( isset( $content_font['textTransform'] ) && ! empty( $content_font['textTransform'] ) ) {
				$css->add_property( 'text-transform', $content_font['textTransform'] );
			}
			if ( isset( $content_font['family'] ) && ! empty( $content_font['family'] ) ) {
				$css->add_property( 'font-family', $css->render_font_family( $content_font['family'] ) );
			}
			if ( isset( $content_font['style'] ) && ! empty( $content_font['style'] ) ) {
				$css->add_property( 'font-style', $content_font['style'] );
			}
			if ( isset( $content_font['weight'] ) && ! empty( $content_font['weight'] ) && 'regular' !== $content_font['weight'] ) {
				$css->add_property( 'font-weight', $css->render_font_weight( $content_font['weight'] ) );
			}
			if ( isset( $content_font['margin'] ) && is_array( $content_font['margin'] ) && isset( $content_font['margin'][0] ) && is_numeric( $content_font['margin'][0] ) ) {
				$css->add_property( 'margin-top', $content_font['margin'][0] . 'px' );
			}
			if ( isset( $content_font['margin'] ) && is_array( $content_font['margin'] ) && isset( $content_font['margin'][1] ) && is_numeric( $content_font['margin'][1] ) ) {
				$css->add_property( 'margin-right', $content_font['margin'][1] . 'px' );
			}
			if ( isset( $content_font['margin'] ) && is_array( $content_font['margin'] ) && isset( $content_font['margin'][2] ) && is_numeric( $content_font['margin'][2] ) ) {
				$css->add_property( 'margin-bottom', $content_font['margin'][2] . 'px' );
			}
			if ( isset( $content_font['margin'] ) && is_array( $content_font['margin'] ) && isset( $content_font['margin'][3] ) && is_numeric( $content_font['margin'][3] ) ) {
				$css->add_property( 'margin-left', $content_font['margin'][3] . 'px' );
			}
			if ( isset( $content_font['padding'] ) && is_array( $content_font['padding'] ) && isset( $content_font['padding'][0] ) && is_numeric( $content_font['padding'][0] ) ) {
				$css->add_property( 'padding-top', $content_font['padding'][0] . 'px' );
			}
			if ( isset( $content_font['padding'] ) && is_array( $content_font['padding'] ) && isset( $content_font['padding'][1] ) && is_numeric( $content_font['padding'][1] ) ) {
				$css->add_property( 'padding-right', $content_font['padding'][1] . 'px' );
			}
			if ( isset( $content_font['padding'] ) && is_array( $content_font['padding'] ) && isset( $content_font['padding'][2] ) && is_numeric( $content_font['padding'][2] ) ) {
				$css->add_property( 'padding-bottom', $content_font['padding'][2] . 'px' );
			}
			if ( isset( $content_font['padding'] ) && is_array( $content_font['padding'] ) && isset( $content_font['padding'][3] ) && is_numeric( $content_font['padding'][3] ) ) {
				$css->add_property( 'padding-left', $content_font['padding'][3] . 'px' );
			}
			if ( isset( $attributes['contentMinHeight'] ) && is_array( $attributes['contentMinHeight'] ) && isset( $attributes['contentMinHeight'][0] ) && is_numeric( $attributes['contentMinHeight'][0] ) ) {
				$css->add_property( 'min-height', $attributes['contentMinHeight'][0] . 'px' );
			}
		}
		if ( ( isset( $attributes['contentFont'] ) && is_array( $attributes['contentFont'] ) && isset( $attributes['contentFont'][0] ) && is_array( $attributes['contentFont'][0] ) && ( ( isset( $attributes['contentFont'][0]['size'] ) && is_array( $attributes['contentFont'][0]['size'] ) && isset( $attributes['contentFont'][0]['size'][1] ) && ! empty( $attributes['contentFont'][0]['size'][1] ) ) || ( isset( $attributes['contentFont'][0]['lineHeight'] ) && is_array( $attributes['contentFont'][0]['lineHeight'] ) && isset( $attributes['contentFont'][0]['lineHeight'][1] ) && ! empty( $attributes['contentFont'][0]['lineHeight'][1] ) ) ) ) || ( isset( $attributes['contentMinHeight'] ) && is_array( $attributes['contentMinHeight'] ) && isset( $attributes['contentMinHeight'][1] ) && is_numeric( $attributes['contentMinHeight'][1] ) ) ) {
			$css->set_media_state( 'tablet' );
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-content' );
			if ( isset( $attributes['contentFont'][0]['size'][1] ) && ! empty( $attributes['contentFont'][0]['size'][1] ) ) {
				$css->add_property( 'font-size', $attributes['contentFont'][0]['size'][1] . ( ! isset( $attributes['contentFont'][0]['sizeType'] ) ? 'px' : $attributes['contentFont'][0]['sizeType'] ) );
			}
			if ( isset( $attributes['contentFont'][0]['lineHeight'][1] ) && ! empty( $attributes['contentFont'][0]['lineHeight'][1] ) ) {
				$css->add_property( 'line-height', $attributes['contentFont'][0]['lineHeight'][1] . ( ! isset( $attributes['contentFont'][0]['lineType'] ) ? 'px' : $attributes['contentFont'][0]['lineType'] ) );
			}
			if ( isset( $attributes['contentMinHeight'] ) && is_array( $attributes['contentMinHeight'] ) && isset( $attributes['contentMinHeight'][1] ) && is_numeric( $attributes['contentMinHeight'][1] ) ) {
				$css->add_property( 'min-height', $attributes['contentMinHeight'][1] . 'px' );
			}
			$css->set_media_state( 'desktop' );
		}
		if ( ( isset( $attributes['contentFont'] ) && is_array( $attributes['contentFont'] ) && isset( $attributes['contentFont'][0] ) && is_array( $attributes['contentFont'][0] ) && ( ( isset( $attributes['contentFont'][0]['size'] ) && is_array( $attributes['contentFont'][0]['size'] ) && isset( $attributes['contentFont'][0]['size'][2] ) && ! empty( $attributes['contentFont'][0]['size'][2] ) ) || ( isset( $attributes['contentFont'][0]['lineHeight'] ) && is_array( $attributes['contentFont'][0]['lineHeight'] ) && isset( $attributes['contentFont'][0]['lineHeight'][2] ) && ! empty( $attributes['contentFont'][0]['lineHeight'][2] ) ) ) ) || ( isset( $attributes['contentMinHeight'] ) && is_array( $attributes['contentMinHeight'] ) && isset( $attributes['contentMinHeight'][2] ) && is_numeric( $attributes['contentMinHeight'][2] ) ) ) {
			$css->set_media_state( 'mobile' );
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-content' );
			if ( isset( $attributes['contentFont'][0]['size'][2] ) && ! empty( $attributes['contentFont'][0]['size'][2] ) ) {
				$css->add_property( 'font-size', $attributes['contentFont'][0]['size'][2] . ( ! isset( $attributes['contentFont'][0]['sizeType'] ) ? 'px' : $attributes['contentFont'][0]['sizeType'] ) );
			}
			if ( isset( $attributes['contentFont'][0]['lineHeight'][2] ) && ! empty( $attributes['contentFont'][0]['lineHeight'][2] ) ) {
				$css->add_property( 'line-height', $attributes['contentFont'][0]['lineHeight'][2] . ( ! isset( $attributes['contentFont'][0]['lineType'] ) ? 'px' : $attributes['contentFont'][0]['lineType'] ) );
			}
			if ( isset( $attributes['contentMinHeight'] ) && is_array( $attributes['contentMinHeight'] ) && isset( $attributes['contentMinHeight'][2] ) && is_numeric( $attributes['contentMinHeight'][2] ) ) {
				$css->add_property( 'min-height', $attributes['contentMinHeight'][2] . 'px' );
			}
			$css->set_media_state( 'desktop' );
		}
		if ( isset( $attributes['nameFont'] ) && is_array( $attributes['nameFont'] ) && is_array( $attributes['nameFont'][0] ) ) {
			$name_font = $attributes['nameFont'][0];
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-name' );
			if ( isset( $name_font['color'] ) && ! empty( $name_font['color'] ) ) {
				$css->add_property( 'color', $css->render_color( $name_font['color'] ) );
			}
			if ( isset( $name_font['size'] ) && is_array( $name_font['size'] ) && ! empty( $name_font['size'][0] ) ) {
				$css->add_property( 'font-size', $name_font['size'][0] . ( ! isset( $name_font['sizeType'] ) ? 'px' : $name_font['sizeType'] ) );
			}
			if ( isset( $name_font['lineHeight'] ) && is_array( $name_font['lineHeight'] ) && ! empty( $name_font['lineHeight'][0] ) ) {
				$css->add_property( 'line-height', $name_font['lineHeight'][0] . ( ! isset( $name_font['lineType'] ) ? 'px' : $name_font['lineType'] ) );
			}
			if ( isset( $name_font['letterSpacing'] ) && ! empty( $name_font['letterSpacing'] ) ) {
				$css->add_property( 'letter-spacing', $name_font['letterSpacing'] . 'px' );
			}
			if ( isset( $name_font['textTransform'] ) && ! empty( $name_font['textTransform'] ) ) {
				$css->add_property( 'text-transform', $name_font['textTransform'] );
			}
			if ( isset( $name_font['family'] ) && ! empty( $name_font['family'] ) ) {
				$css->add_property( 'font-family', $css->render_font_family( $name_font['family'] ) );
			}
			if ( isset( $name_font['style'] ) && ! empty( $name_font['style'] ) ) {
				$css->add_property( 'font-style', $name_font['style'] );
			}
			if ( isset( $name_font['weight'] ) && ! empty( $name_font['weight'] ) && 'regular' !== $name_font['weight'] ) {
				$css->add_property( 'font-weight', $css->render_font_weight( $name_font['weight'] ) );
			}
		}
		if ( isset( $attributes['nameFont'] ) && is_array( $attributes['nameFont'] ) && isset( $attributes['nameFont'][0] ) && is_array( $attributes['nameFont'][0] ) && ( ( isset( $attributes['nameFont'][0]['size'] ) && is_array( $attributes['nameFont'][0]['size'] ) && isset( $attributes['nameFont'][0]['size'][1] ) && ! empty( $attributes['nameFont'][0]['size'][1] ) ) || ( isset( $attributes['nameFont'][0]['lineHeight'] ) && is_array( $attributes['nameFont'][0]['lineHeight'] ) && isset( $attributes['nameFont'][0]['lineHeight'][1] ) && ! empty( $attributes['nameFont'][0]['lineHeight'][1] ) ) ) ) {
			$css->set_media_state( 'tablet' );
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-name' );
			if ( isset( $attributes['nameFont'][0]['size'][1] ) && ! empty( $attributes['nameFont'][0]['size'][1] ) ) {
				$css->add_property( 'font-size', $attributes['nameFont'][0]['size'][1] . ( ! isset( $attributes['nameFont'][0]['sizeType'] ) ? 'px' : $attributes['nameFont'][0]['sizeType'] ) );
			}
			if ( isset( $attributes['nameFont'][0]['lineHeight'][1] ) && ! empty( $attributes['nameFont'][0]['lineHeight'][1] ) ) {
				$css->add_property( 'line-height', $attributes['nameFont'][0]['lineHeight'][1] . ( ! isset( $attributes['nameFont'][0]['lineType'] ) ? 'px' : $attributes['nameFont'][0]['lineType'] ) );
			}
			$css->set_media_state( 'desktop' );
		}
		if ( isset( $attributes['nameFont'] ) && is_array( $attributes['nameFont'] ) && isset( $attributes['nameFont'][0] ) && is_array( $attributes['nameFont'][0] ) && ( ( isset( $attributes['nameFont'][0]['size'] ) && is_array( $attributes['nameFont'][0]['size'] ) && isset( $attributes['nameFont'][0]['size'][2] ) && ! empty( $attributes['nameFont'][0]['size'][2] ) ) || ( isset( $attributes['nameFont'][0]['lineHeight'] ) && is_array( $attributes['nameFont'][0]['lineHeight'] ) && isset( $attributes['nameFont'][0]['lineHeight'][2] ) && ! empty( $attributes['nameFont'][0]['lineHeight'][2] ) ) ) ) {
			$css->set_media_state( 'mobile' );
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-name' );
			if ( isset( $attributes['nameFont'][0]['size'][2] ) && ! empty( $attributes['nameFont'][0]['size'][2] ) ) {
				$css->add_property( 'font-size', $attributes['nameFont'][0]['size'][2] . ( ! isset( $attributes['nameFont'][0]['sizeType'] ) ? 'px' : $attributes['nameFont'][0]['sizeType'] ) );
			}
			if ( isset( $attributes['nameFont'][0]['lineHeight'][2] ) && ! empty( $attributes['nameFont'][0]['lineHeight'][2] ) ) {
				$css->add_property( 'line-height', $attributes['nameFont'][0]['lineHeight'][2] . ( ! isset( $attributes['nameFont'][0]['lineType'] ) ? 'px' : $attributes['nameFont'][0]['lineType'] ) );
			}
			$css->set_media_state( 'desktop' );
		}
		if ( isset( $attributes['occupationFont'] ) && is_array( $attributes['occupationFont'] ) && is_array( $attributes['occupationFont'][0] ) ) {
			$occupation_font = $attributes['occupationFont'][0];
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-occupation' );
			if ( isset( $occupation_font['color'] ) && ! empty( $occupation_font['color'] ) ) {
				$css->add_property( 'color', $css->render_color( $occupation_font['color'] ) );
			}
			if ( isset( $occupation_font['size'] ) && is_array( $occupation_font['size'] ) && ! empty( $occupation_font['size'][0] ) ) {
				$css->add_property( 'font-size', $occupation_font['size'][0] . ( ! isset( $occupation_font['sizeType'] ) ? 'px' : $occupation_font['sizeType'] ) );
			}
			if ( isset( $occupation_font['lineHeight'] ) && is_array( $occupation_font['lineHeight'] ) && ! empty( $occupation_font['lineHeight'][0] ) ) {
				$css->add_property( 'line-height', $occupation_font['lineHeight'][0] . ( ! isset( $occupation_font['lineType'] ) ? 'px' : $occupation_font['lineType'] ) );
			}
			if ( isset( $occupation_font['letterSpacing'] ) && ! empty( $occupation_font['letterSpacing'] ) ) {
				$css->add_property( 'letter-spacing', $occupation_font['letterSpacing'] . 'px' );
			}
			if ( isset( $occupation_font['textTransform'] ) && ! empty( $occupation_font['textTransform'] ) ) {
				$css->add_property( 'text-transform', $occupation_font['textTransform'] );
			}
			if ( isset( $occupation_font['family'] ) && ! empty( $occupation_font['family'] ) ) {
				$css->add_property( 'font-family', $css->render_font_family( $occupation_font['family'] ) );
			}
			if ( isset( $occupation_font['style'] ) && ! empty( $occupation_font['style'] ) ) {
				$css->add_property( 'font-style', $occupation_font['style'] );
			}
			if ( isset( $occupation_font['weight'] ) && ! empty( $occupation_font['weight'] ) && 'regular' !== $occupation_font['weight'] ) {
				$css->add_property( 'font-weight', $css->render_font_weight( $occupation_font['weight'] ) );
			}
		}
		if ( isset( $attributes['occupationFont'] ) && is_array( $attributes['occupationFont'] ) && isset( $attributes['occupationFont'][0] ) && is_array( $attributes['occupationFont'][0] ) && ( ( isset( $attributes['occupationFont'][0]['size'] ) && is_array( $attributes['occupationFont'][0]['size'] ) && isset( $attributes['occupationFont'][0]['size'][1] ) && ! empty( $attributes['occupationFont'][0]['size'][1] ) ) || ( isset( $attributes['occupationFont'][0]['lineHeight'] ) && is_array( $attributes['occupationFont'][0]['lineHeight'] ) && isset( $attributes['occupationFont'][0]['lineHeight'][1] ) && ! empty( $attributes['occupationFont'][0]['lineHeight'][1] ) ) ) ) {
			$css->set_media_state( 'tablet' );
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-occupation' );
			if ( isset( $attributes['occupationFont'][0]['size'][1] ) && ! empty( $attributes['occupationFont'][0]['size'][1] ) ) {
				$css->add_property( 'font-size', $attributes['occupationFont'][0]['size'][1] . ( ! isset( $attributes['occupationFont'][0]['sizeType'] ) ? 'px' : $attributes['occupationFont'][0]['sizeType'] ) );
			}
			if ( isset( $attributes['occupationFont'][0]['lineHeight'][1] ) && ! empty( $attributes['occupationFont'][0]['lineHeight'][1] ) ) {
				$css->add_property( 'line-height', $attributes['occupationFont'][0]['lineHeight'][1] . ( ! isset( $attributes['occupationFont'][0]['lineType'] ) ? 'px' : $attributes['occupationFont'][0]['lineType'] ) );
			}
			$css->set_media_state( 'desktop' );
		}
		if ( isset( $attributes['occupationFont'] ) && is_array( $attributes['occupationFont'] ) && isset( $attributes['occupationFont'][0] ) && is_array( $attributes['occupationFont'][0] ) && ( ( isset( $attributes['occupationFont'][0]['size'] ) && is_array( $attributes['occupationFont'][0]['size'] ) && isset( $attributes['occupationFont'][0]['size'][2] ) && ! empty( $attributes['occupationFont'][0]['size'][2] ) ) || ( isset( $attributes['occupationFont'][0]['lineHeight'] ) && is_array( $attributes['occupationFont'][0]['lineHeight'] ) && isset( $attributes['occupationFont'][0]['lineHeight'][2] ) && ! empty( $attributes['occupationFont'][0]['lineHeight'][2] ) ) ) ) {
			$css->set_media_state( 'mobile' );
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-occupation' );
			if ( isset( $attributes['occupationFont'][0]['size'][2] ) && ! empty( $attributes['occupationFont'][0]['size'][2] ) ) {
				$css->add_property( 'font-size', $attributes['occupationFont'][0]['size'][2] . ( ! isset( $attributes['occupationFont'][0]['sizeType'] ) ? 'px' : $attributes['occupationFont'][0]['sizeType'] ) );
			}
			if ( isset( $attributes['occupationFont'][0]['lineHeight'][2] ) && ! empty( $attributes['occupationFont'][0]['lineHeight'][2] ) ) {
				$css->add_property( 'line-height', $attributes['occupationFont'][0]['lineHeight'][2] . ( ! isset( $attributes['occupationFont'][0]['lineType'] ) ? 'px' : $attributes['occupationFont'][0]['lineType'] ) );
			}
			$css->set_media_state( 'desktop' );
		}

		/*
		 * Global styles to apply to all testimonial items
		 */
		if( isset($attributes['style']) && ( 'bubble' === $attributes['style'] || 'inlineimage' === $attributes['style'] ) ){
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-item-wrap' );

			$css->add_property( 'max-width', isset( $attributes['containerMaxWidth'] ) ? $attributes['containerMaxWidth'] : 500 . 'px');
			$css->add_property('padding-top', ( isset( $attributes['displayIcon'] ) && $attributes['displayIcon'] && $attributes['iconStyles'][ 0 ]['icon'] && $attributes['iconStyles'][ 0 ]['margin'] && $attributes['iconStyles'][ 0 ]['margin'][ 0 ] && ( $attributes['iconStyles'][ 0 ]['margin'][ 0 ] < 0 ) ? abs( $attributes['iconStyles'][ 0 ]['margin'][ 0 ] ) . 'px' : 'undefined' ));
		}

		// See if container styles are applied to the item or text
		if( !isset( $attributes['style'] ) || ( isset( $attributes['style'] ) && 'bubble' !== $attributes['style'] && 'inlineimage' !== $attributes['style'] ) ){
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-item-wrap' );

		} else {
			$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-item-wrap .kt-testimonial-text-wrap' );
		}

		if( isset( $attributes['displayShadow'] ) && $attributes['displayShadow'] ){
			$default_shadow = array(
				'color' => '#000000',
				'opacity' => 0.2,
				'spread' => 0,
				'blur' => 14,
				'hOffset' => 4,
				'vOffset' => 2,

			);
			$shadow = isset( $attributes['shadow'][0] ) ? $attributes['shadow'][0] : $default_shadow;

			$css->add_property( 'box-shadow', $shadow['hOffset'] .'px '. $shadow['vOffset'] .'px '. $shadow['blur'] . 'px '. $shadow['spread'] . 'px ' . $css->render_color( $shadow['color'], $shadow['opacity'] ) );
		}

		$css->render_measure_range( $attributes, 'containerBorderWidth', 'border-width' );

		if( !isset( $attributes['containerBorder'] )){
			$attributes['containerBorder'] = '#eeeeee';
		}

		$css->render_color_output( $attributes, 'containerBorder', 'border-color', 'containerBorderOpacity' );
		$css->render_color_output( $attributes, 'containerBackground', 'background', 'containerBackgroundOpacity' );
		$css->render_range( $attributes, 'containerBorderRadius', 'border-radius' );

		$css->render_range( $attributes, 'containerPadding', 'padding' );

		if( !isset( $attributes['style'] ) || ( isset( $attributes['style'] ) && in_array( $attributes['style'], array('inlineimage', 'bubble') ) ) ){
			$css->add_property( 'max-width', isset( $attributes['containerMaxWidth'] ) ? $attributes['containerMaxWidth'] . 'px' : '500px' );
		}

		/*
		 * Global Media styles
		 */
		$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-media-inner-wrap' );

		if( isset( $attributes['style'], $attributes['mediaStyles'][0]['width'] ) && $attributes['style'] !== 'card' ) {
			$css->add_property( 'width', $attributes['mediaStyles'][0]['width'] . 'px' );
		}

		if( isset( $attributes['mediaStyles'][0] ) ) {
			if( !isset( $attributes['mediaStyles'][0]['border'] ) ){
				$attributes['mediaStyles'][0]['border'] = '#555555';
			}
			$css->render_color_output( $attributes['mediaStyles'][0], 'border', 'border-color' );

			$css->render_range( $attributes['mediaStyles'][0], 'padding', 'padding' );
			$css->render_range( $attributes['mediaStyles'][0], 'margin', 'margin' );
			$css->render_range( $attributes['mediaStyles'][0], 'borderRadius', 'border-radius' );
			$css->render_color_output( $attributes['mediaStyles'][0], 'background', 'border-color', 'backgroundOpacity' );
			$css->render_measure_range( $attributes['mediaStyles'][0], 'borderWidth', 'border-width' );
		}

		/*
		 * Global Rating Styles
		 */
		$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-rating-wrap' );
		$css->render_range( isset( $attributes['ratingStyles'][0] ) ? $attributes['ratingStyles'][0] : array( 'margin' => array( 10, 0, 10, 0) ), 'margin', 'margin' );

		$css->set_selector( '.kt-blocks-testimonials-wrap' . $unique_id . ' .kt-testimonial-rating-wrap .kt-svg-testimonial-rating-icon' );
		$css->render_color_output( isset( $attributes['ratingStyles'][0] ) ? $attributes['ratingStyles'][0] : array( 'color' => '#ffd700'), 'color', 'color' );

		return $css->css_output();
	}

	/**
	 * Registers scripts and styles.
	 */
	public function register_scripts() {
		parent::register_scripts();
		// If in the backend, bail out.
		if ( is_admin() ) {
			return;
		}
		if ( apply_filters( 'kadence_blocks_check_if_rest', false ) && kadence_blocks_is_rest() ) {
			return;
		}

		wp_register_style( 'kadence-blocks-tiny-slider', KADENCE_BLOCKS_URL . 'includes/assets/css/tiny-slider.min.css', array(), KADENCE_BLOCKS_VERSION );
		wp_register_script( 'kadence-blocks-tiny-slider', KADENCE_BLOCKS_URL . 'includes/assets/js/tiny-slider.min.js', array(), KADENCE_BLOCKS_VERSION, true );
		wp_register_script( 'kadence-blocks-tiny-slider-init', KADENCE_BLOCKS_URL . 'includes/assets/js/kb-tiny-init.min.js', array( 'kadence-blocks-tiny-slider' ), KADENCE_BLOCKS_VERSION, true );
	}
}

Kadence_Blocks_Testimonials_Block::get_instance();
