<?php
class Controller
{
	public function view($view, $data = array())
	{
		require_once 'aplication/views/'.$view.'.php';
	}

	public function model($model)
	{
		require_once 'aplication/models/'.$model.'.php';
		return new $model;
	}

	public function input($data = null, $property = null)
	{
		if (isset($_GET))
		{
			if ($property = 'required')
			{
				Flasher::set('Your input is empty!');
				return false;
			} else {
				return $_GET[$data];
			}
		} else if (isset($_POST))
		{
			if ($property = 'required')
			{
				Flasher::set('Your input is empty!');
				return false;
			} else {
				return $_POST[$data];
			}
		}
	}
}