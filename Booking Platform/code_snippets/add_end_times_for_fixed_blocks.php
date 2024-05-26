function add_end_times_for_fixed_blocks ( $block_html, $available_blocks, $blocks, $product_object ) {
	// ONLY FOR FIXED BLOCKS, NOT CUSTOMER DEFINED BLOCKS
	if ($product_object->get_duration_type()!=='customer') {
		foreach ( $available_blocks as $block => $quantity ) {
			if ( $quantity['available'] > 0 ) {
				$block_duration			= $product_object->get_duration();
				$block_duration_unit	= $product_object->get_duration_unit();
				
				$start_time = $block;
				$end_time = strtotime( '+' . $block_duration . ' ' . $block_duration_unit, $start_time );
                if ( $quantity['booked'] ) {
					$new_block_html .= '<li class="block" data-block="' . esc_attr( date( 'Hi', $block ) ) . '" data-remaining="' . esc_attr( $quantity['available'] ) . '" ><a href="#" data-value="' . get_time_as_iso8601( $block ) . '" data-remaining="' . sprintf( _n( '%d left', '%d left', $quantity['available'], 'woocommerce-bookings' ), absint( $quantity['available'] ) ) . '">' . date_i18n( wc_bookings_time_format(), $block ) . ' - ' . date_i18n( wc_bookings_time_format(), $end_time ) . ' <small class="booking-spaces-left">(' . sprintf( _n( '%d left', '%d left', $quantity['available'], 'woocommerce-bookings' ), absint( $quantity['available'] ) ) . ')</small></a></li>';
                } else {
                    $new_block_html .= '<li class="block" data-block="' . esc_attr( date( 'Hi', $block ) ) . '"><a href="#" data-value="' . get_time_as_iso8601( $block ) . '">' . date_i18n( wc_bookings_time_format(), $block ) . ' - ' . date_i18n( wc_bookings_time_format(), $end_time ) . '</a></li>';
                }
            }
        }
		return $new_block_html;
    }
	return $block_html;
}

add_filter( 'wc_bookings_get_time_slots_html', 'add_end_times_for_fixed_blocks', 10, 4);
