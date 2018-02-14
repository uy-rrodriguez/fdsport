<?php

class context
{

	private $data;

	private $name;

	private static $instance = null;

	/**
	* @return context
	*/
	public static function getInstance()
	{

		if (self::$instance == null)
		{

			self::$instance = new context();

		}

		return self::$instance;

	}

	private function __construct() {}

	public function init($name)
	{

		$this->name = $name;

	}

	public function getSessionAttribute($attribute)
	{

		if(array_key_exists($attribute, $_SESSION))
		{

			return $_SESSION[$attribute];

		}
		else
		{

			return null;

		}

	}
	
	public function setSessionAttribute($attribute, $value)
	{

		$_SESSION[$attribute] = $value;

	}

	public function __get($prop)
	{

		if (array_key_exists($prop, $this->data))
		{

			return $this->data[$prop];

		}
		else
		{

			return null;

		}

	}

	public function __set($prop, $value)
	{

		$this->data[$prop] = $value;

	}

}

?>