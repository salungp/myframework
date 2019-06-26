<?php
class Flasher
{
	public $_message;

	public static function set($m)
	{
		$_SESSION['flasher'] = array('m' => $m);
	}

	public static function get()
	{
		if (isset($_SESSION['flasher']))
		{
			echo $_SESSION['flasher']['m'];
			unset($_SESSION['flasher']);
		}
	}
}