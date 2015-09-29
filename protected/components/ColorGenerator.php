<?php 

/**
* ColorGenerator
*/
class ColorGenerator
{
	public static function generateHexColor()
	{
		 return "3c" . self::random_color_part() . self::random_color_part();
	}
	private static function random_color_part() {
    	return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
	}
}