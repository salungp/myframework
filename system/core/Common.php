<?php
if ( ! function_exists('base_url'))
{
	function base_url($url = null)
	{
		if (is_null(BASEURL))
		{
			return dirname( __FILE__ ).$url;
		} else {
			$uri = BASEURL.$url;
			$uri = filter_var($uri, FILTER_SANITIZE_URL);
			return $uri;
		}
	}	
}

if ( ! function_exists('redirect'))
{
	function redirect($url = null)
	{
		if (is_null(BASEURL))
		{
			header('location:'.dirname( __FILE__ ).$url);
			exit;
		} else {
			header('location:'.BASEURL.$url);
			exit;
		}
	}	
}

if ( ! function_exists('load'))
{
	function load($file, $dir = null)
	{
		if (file_exists($dir.'/'.$file.'.php'))
		{
			require_once $dir.'/'.$file.'.php';
		} else {
			die("Can't find file in ".$dir);
		}
	}
}