<?php
class Controller
{
	public $_input;

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
			if ($property == 'required')
			{
				if ($_GET[$data] === null)
				{
					Flasher::set('Your input is empty!');
					$this->_input = false;
				}
			} else {
				return htmlspecialchars($_GET[$data]);
			}
		} else if (isset($_POST))
		{
			if ($property == 'required')
			{
				if ($_POST[$data] === null)
				{
					Flasher::set('Your input is empty!');
					$this->_input = false;
				}
			} else {
				return htmlspecialchars($_POST[$data]);
			}
		}
	}
}