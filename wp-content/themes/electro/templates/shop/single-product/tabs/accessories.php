<?php
/**
 * Single Product Accessories
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$columns = apply_filters( 'electro_accessories_loop_columns', 3 );
if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.3', '<' ) ) {
	global $woocommerce_loop;
	$woocommerce_loop['columns'] = $columns;
} else {
	wc_set_loop_prop( 'columns', $columns );
}

$accessories = Electro_WC_Helper::get_accessories( $product );

if ( sizeof( $accessories ) === 0 && !array_filter( $accessories ) ) {
	return;
}

$meta_query = WC()->query->get_meta_query();

$args = apply_filters( 'electro_accessories_query_args', array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => 2,
	'orderby'             => 'post__in',
	'post__in'            => $accessories,
	'meta_query'          => $meta_query
) );

unset( $args['meta_query'] );

$products = new WP_Query( $args );

$add_to_cart_checkbox 	= '';
$total_price 			= 0;
$count 					= 0;

if ( $products->have_posts() ) : ?>

	<div class="accessories">

		<div class="electro-wc-message"></div>
		<div class="row">
			<div class="col-xs-12 col-sm-9 col-left">

				<?php woocommerce_product_loop_start(); ?>

					<li class="post-<?php echo esc_attr( electro_wc_get_product_id( $product ) ); ?> product first">
						<div class="product-outer">
							<div class="product-inner">
								<?php electro_template_loop_categories(); ?>
								<a href="<?php echo esc_url( $product->get_permalink() );?>">
									<h3><?php echo wp_kses_post( $product->get_title() ); ?></h3>
									<div class="product-thumbnail">
										<?php echo wp_kses_post( $product->get_image( 'shop_catalog' ) ); ?>
									</div>
								</a>
								<div class="price-add-to-cart"><p class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p></div>
							</div>
						</div>					
					</li>

					<?php
						$count++;
						$price_html = '';
						$display_price = 0;

						if ( $price_html = $product->get_price_html() ) {
							if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.7', '<' ) ) {
								$display_price = $product->get_display_price();
							} else {
								$display_price = wc_get_price_to_display( $product );
							}
							$price_html = '<span class="accessory-price">' . wc_price( $display_price ) . $product->get_price_suffix() . '</span>';
						}

						$total_price += $display_price;
						
						$add_to_cart_checkbox = '<div class="checkbox accessory-checkbox"><label><input checked disabled type="checkbox" class="product-check" data-price="'  . $display_price . '" data-product-id="' . electro_wc_get_product_id( $product ) . '" data-product-type="' . electro_wc_get_product_type( $product ) . '" /> <span class="product-title"><strong>' . esc_html__( 'This product: ', 'electro' ) . '</strong>' . get_the_title() . '</span> - ' . $price_html . '</label></div>';
					?>

					<?php
						// Set to 1 because we have already displayed the single product just above
						if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.3', '<' ) ) {
							$woocommerce_loop['loop'] = 1;
						} else {
							wc_set_loop_prop( 'loop', 1 );
						}
					?>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>

						<?php wc_get_template_part( 'content', 'product' ); ?>

						<?php 
							global $product;
							
							$price_html = '';
							$display_price = 0;

							if ( $price_html = $product->get_price_html() ) {
								if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.7', '<' ) ) {
									$display_price = $product->get_display_price();
								} else {
									$display_price = wc_get_price_to_display( $product );
								}
								$price_html = '<span class="accessory-price">' . wc_price( $display_price ) . $product->get_price_suffix() . '</span>';
							}

							$total_price += $display_price;

							$prefix = '';

							$count++;

							$add_to_cart_checkbox .= '<div class="checkbox accessory-checkbox"><label><input checked type="checkbox" class="product-check" data-price="'  . $display_price . '" data-product-id="' . electro_wc_get_product_id( $product ) . '" data-product-type="' . electro_wc_get_product_type( $product ) . '" /> <span class="product-title">' . $prefix . get_the_title() . '</span> - ' . $price_html . '</label></div>';
						?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>
				
				<div class="check-products">
					<?php echo $add_to_cart_checkbox; ?>
				</div>

			</div>

			<div class="col-xs-12 col-sm-3 col-right">
				<div class="total-price">
					<?php
						$total_price_html = '<span class="total-price-html">' . wc_price( $total_price ) . $product->get_price_suffix() . '</span>';
						$total_products_html = '<span class="total-products">' . $count . '</span>';
						$total_price = sprintf( __( '%s for %s item(s)', 'electro' ), $total_price_html, $total_products_html );
						echo wp_kses_post( $total_price );
					?>
				</div>
				<div class="accessories-add-all-to-cart">
					<button type="button" class="button btn btn-primary add-all-to-cart"><?php echo esc_html__( 'Add all to cart', 'electro' ); ?></button>
				</div>
			</div>
		</div>
		<?php
			$alert_message = apply_filters( 'electro_accessories_product_cart_alert_message', array(
				'success'		=> sprintf( '<div class="woocommerce-message">%s <a class="button wc-forward" href="%s">%s</a></div>', esc_html__( 'Products was successfully added to your cart.', 'electro' ), wc_get_cart_url(), esc_html__( 'View Cart', 'electro' ) ),
				'empty'			=> sprintf( '<div class="woocommerce-error">%s</div>', esc_html__( 'No Products selected.', 'electro' ) ),
				'no_variation'	=> sprintf( '<div class="woocommerce-error">%s</div>', esc_html__( 'Product Variation does not selected.', 'electro' ) ),
				'not_available'	=> sprintf( '<div class="woocommerce-error">%s</div>', esc_html__( 'Sorry, this product is unavailable.', 'electro' ) ),
			) );
		
			ob_start(); ?>
			jQuery(document).ready(function($) {

				/**
				 * Check if a node is blocked for processing.
				 *
				 * @param {JQuery Object} $node
				 * @return {bool} True if the DOM Element is UI Blocked, false if not.
				 */
				var is_blocked = function( $node ) {
					return $node.is( '.processing' ) || $node.parents( '.processing' ).length;
				};

				/**
				 * Block a node visually for processing.
				 *
				 * @param {JQuery Object} $node
				 */
				var block = function( $node ) {
					if ( ! is_blocked( $node ) ) {
						$node.addClass( 'processing' ).block( {
							message: null,
							overlayCSS: {
								background: '#fff url( "<?php echo get_template_directory_uri() . '/assets/images/ajax-loader.gif'; ?>" ) no-repeat center',
								opacity: 0.6
							}
						} );
					}
				};

				/**
				 * Unblock a node after processing is complete.
				 *
				 * @param {JQuery Object} $node
				 */
				var unblock = function( $node ) {
					$node.removeClass( 'processing' ).unblock();
				};

				function accessory_checked_count(){
					var product_count = 0;
					$('.accessory-checkbox .product-check').each(function() {
						if( $(this).is(':checked') ) {
							if( $(this).data( 'price' ) !== '' ) {
								product_count++;
							}
						}
					});
					return product_count;
				}

				function accessory_checked_total_price(){
					var total_price = 0;
					$('.accessory-checkbox .product-check').each(function() {
						if( $(this).is(':checked') ) {
							if( $(this).data( 'price' ) !== '' ) {
								total_price += parseFloat( $(this).data( 'price' ) );
							}
						}
					});
					return total_price;
				}

				function accessory_checked_product_ids(){
					var product_ids = [];
					$('.accessory-checkbox .product-check').each(function() {
						if( $(this).is(':checked') ) {
							product_ids.push( $(this).data( 'product-id' ) );
						}
					});
					return product_ids;
				}

				function accessory_unchecked_product_ids(){
					var product_ids = [];
					$('.accessory-checkbox .product-check').each(function() {
						if( ! $(this).is(':checked') ) {
							product_ids.push( $(this).data( 'product-id' ) );
						}
					});
					return product_ids;
				}

				function accessory_checked_variable_product_ids(){
					var variable_product_ids = [];
					$('.accessory-checkbox .product-check').each(function() {
						if( $(this).is(':checked') && $(this).data( 'product-type' ) == 'variable' ) {
							variable_product_ids.push( $(this).data( 'product-id' ) );
						}
					});
					return variable_product_ids;
				}

				function accessory_is_variation_selected(){
					if( $(".single_add_to_cart_button").is(":disabled") ) {
						return false;
					}
					return true;
				}

				function accessory_is_variation_available(){
					if( $(".single_add_to_cart_button").length === 0 || $(".single_add_to_cart_button").hasClass("disabled") || $(".single_add_to_cart_button").hasClass("wc-variation-is-unavailable") ) {
						return false;
					}
					return true;
				}

				function accessory_is_product_available(){
					if( $(".single_add_to_cart_button").length === 0 || $(".single_add_to_cart_button").hasClass("disabled") ) {
						return false;
					}
					return true;
				}

				function accessory_refresh_fragments( response ){
					var this_page = window.location.toString();
					var fragments = response.fragments;
					var cart_hash = response.cart_hash;

					// Block fragments class
					if ( fragments ) {
						$.each( fragments, function( key ) {
							$( key ).addClass( 'updating' );
						});
					}

					// Replace fragments
					if ( fragments ) {
						$.each( fragments, function( key, value ) {
							$( key ).replaceWith( value );
						});
					}

					// Cart page elements
					$( '.shop_table.cart' ).load( this_page + ' .shop_table.cart:eq(0) > *', function() {

						$( '.shop_table.cart' ).stop( true ).css( 'opacity', '1' ).unblock();

						$( document.body ).trigger( 'cart_page_refreshed' );
					});

					$( '.cart_totals' ).load( this_page + ' .cart_totals:eq(0) > *', function() {
						$( '.cart_totals' ).stop( true ).css( 'opacity', '1' ).unblock();
					});
				}

				$( 'body' ).on( 'found_variation', function( event, variation ) {
					$('.accessory-checkbox .product-check').each(function() {
						if( $(this).is(':checked') && $(this).data( 'product-type' ) == 'variable' ) {
							$(this).data( 'price', variation.display_price );
							$(this).siblings( 'span.accessory-price' ).html( $(variation.price_html).html() );
						}
					});
				});

				$( 'body' ).on( 'woocommerce_variation_has_changed', function( event ) {
					block( $( 'div.accessories' ) );
					var total_price = accessory_checked_total_price();
					$.post( "<?php echo admin_url( 'admin-ajax.php' ); ?>", { 'action': "electro_accessories_total_price", 'price': total_price  } )
						.done( function( response ) {
							$( 'span.total-price-html .amount' ).html( response );
							$( 'span.total-products' ).html( accessory_checked_count() );
							unblock( $( 'div.accessories' ) );
						})
						.fail(function() {
							unblock( $( 'div.accessories' ) );
						})
						.always(function() {
							unblock( $( 'div.accessories' ) );
						});
				});

				$( '.accessory-checkbox .product-check' ).on( "click", function() {
					block( $( 'div.accessories' ) );
					var total_price = accessory_checked_total_price();
					$.ajax({
						type: "POST",
						async: false,
						url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
						data: { 'action': "electro_accessories_total_price", 'price': total_price  },
						success : function( response ) {
							$( 'span.total-price-html .amount' ).html( response );
							$( 'span.total-products' ).html( accessory_checked_count() );

							var unchecked_product_ids = accessory_unchecked_product_ids();
							$( '.accessories ul.products > li' ).each(function() {
								$(this).show();
								for (var i = 0; i < unchecked_product_ids.length; i++ ) {
									if( $(this).hasClass( 'post-'+unchecked_product_ids[i] ) ) {
										$(this).hide();
									}
								}
							});
						},
						complete: function() {
							unblock( $( 'div.accessories' ) );
						}
					})
				});

				$('.accessories-add-all-to-cart .add-all-to-cart').click(function() {
					var accerories_all_product_ids = accessory_checked_product_ids();
					var accerories_variable_product_ids = accessory_checked_variable_product_ids();
					if( accerories_all_product_ids.length === 0 ) {
						var accerories_alert_msg = '<?php echo wp_kses_post( $alert_message['empty'] ); ?>';
					} else if( accerories_variable_product_ids.length > 0 && accessory_is_variation_selected() === false ) {
						var accerories_alert_msg = '<?php echo wp_kses_post( $alert_message['no_variation'] ); ?>';
					} else if( accerories_variable_product_ids.length > 0 && accessory_is_variation_available() === false ) {
						var accerories_alert_msg = '<?php echo wp_kses_post( $alert_message['not_available'] ); ?>';
					} else if( accerories_variable_product_ids.length === 0 && accessory_is_product_available() === false ) {
						var accerories_alert_msg = '<?php echo wp_kses_post( $alert_message['not_available'] ); ?>';
					} else {
						for (var i = 0; i < accerories_all_product_ids.length; i++ ) {
							if( ! $.inArray( accerories_all_product_ids[i], accerories_variable_product_ids ) ) {
								var variation_id  = $('.variations_form .variations_button').find('input[name^=variation_id]').val();
								var variation = {};
								if( $( '.variations_form' ).find('select[name^=attribute]').length ) {
									$( '.variations_form' ).find('select[name^=attribute]').each(function() {
										var attribute = $(this).attr("name");
										var attributevalue = $(this).val();
										variation[attribute] = attributevalue;
									});

								} else {

									$( '.variations_form' ).find('.select').each(function() {
										var attribute = $(this).attr("data-attribute-name");
										var attributevalue = $(this).find('.selected').attr('data-name');
										variation[attribute] = attributevalue;
									});

								}
								$.ajax({
									type: "POST",
									async: false,
									url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
									data: { 'action': "electro_variable_add_to_cart", 'product_id': accerories_all_product_ids[i], 'variation_id': variation_id, 'variation': variation  },
									success : function( response ) {
										accessory_refresh_fragments( response );
									}
								})
							} else {
								$.ajax({
									type: "POST",
									async: false,
									url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
									data: { 'action': "woocommerce_add_to_cart", 'product_id': accerories_all_product_ids[i]  },
									success : function( response ) {
										accessory_refresh_fragments( response );
									}
								})
							}
						}
						var accerories_alert_msg = '<?php echo wp_kses_post( $alert_message['success'] ); ?>';
					}
					$( '.electro-wc-message' ).html(accerories_alert_msg);
				});

			});
			<?php
			$custom_script = ob_get_clean();
			wp_add_inline_script( 'electro-js', $custom_script );
		?>

	</div>

<?php endif;

wp_reset_postdata();