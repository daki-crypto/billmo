<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('format_user_id')) {
	function format_user_id($id): string
	{
		return format_six_digit_id($id);
	}
}

if (! function_exists('format_six_digit_id')) {
	function format_six_digit_id($id): string
	{
		return str_pad((string) $id, 6, '0', STR_PAD_LEFT);
	}
}
