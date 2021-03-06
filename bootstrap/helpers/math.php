<?php

if (!function_exists('percent')) {
	/**
	 * Get the percentage one number is of another number.
	 *
	 * @param int $num_amount
	 * @param int $num_total
	 *
	 * @return int|string
	 */
	function percent($num_amount, $num_total) {
		if ($num_amount == 0 || $num_total == 0) {
			return 0;
		} else {
			$count1 = $num_amount / $num_total;
			$count2 = $count1 * 100;
			$count  = number_format($count2, 0);

			return $count;
		}
	}
}

if (!function_exists('decimal')) {
	/**
	 * Get the percentage represented as a decimal.
	 *
	 * @param int $num_amount
	 * @param int $num_total
	 * @param int $round
	 *
	 * @return string
	 */
	function decimal($num_amount, $num_total, $round = 2) {
		if ($num_amount == 0) {
			return number_format(-($num_total * 1), 2);
		} elseif ($num_total == 0) {
			return number_format($num_amount * 1, 2);
		} else {
			$count1 = $num_amount / $num_total;
			$count  = number_format($count1, $round);

			return $count;
		}
	}
}

if (!function_exists('ordinal')) {
	/**
	 * Return a number and it's ordinal suffix.  (1st, 2nd, 3rd, etc)
	 *
	 * @param $cardinal
	 *
	 * @return string
	 */
	function ordinal($cardinal) {
		$test_c    = abs($cardinal) % 10;
		$extension = ((abs($cardinal) % 100 < 21 && abs($cardinal) % 100 > 4) ? 'th' : (($test_c < 4) ? ($test_c < 3) ? ($test_c < 2) ? ($test_c < 1) ? 'th' : 'st' : 'nd' : 'rd' : 'th'));

		return $cardinal . $extension;
	}
}
