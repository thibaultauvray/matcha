<?php

class Validator
{

	public $form;

	public $error;

	private $app;

	public function __construct($form, $c)
	{
		$this->form = $form;
		$this->app = $c;
	}

	public function check($name, $conditions)
	{
		$var = $_POST[$name];
		foreach ($conditions as $value) 
		{
			switch ($value)
			{
				case 'required':
					if (!$var)
						$this->error[$name][] = "Ce champs est requis";
					break;
				case 'isMail':
					if (!filter_var($var, FILTER_VALIDATE_EMAIL)) 
						$this->error[$name][] = "Mail non correct";
					break;
				case 'visible':
					if (strlen($var) > 30)
						$this->error[$name][] = "Ce champs est trop longs, voyons !";
					break;
				case 'isPasswd':
					if (strlen($var) < 6)
						$this->error[$name][] = "Mot de passe non sécurisée";
					break;
				case 'isUnique':
					$user = new Users($this->app);
					if ($user->isUnique($name, $var) == false)
						$this->error[$name][] = "Email déja pris";
					break;
			}
		}
	}



}

?>