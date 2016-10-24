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

    public function testpassword($mdp)
    {
        $longueur = strlen($mdp);

        for ($i = 0; $i < $longueur; $i++)
        {
            $lettre = $mdp[$i];
            if ($lettre >= 'a' && $lettre <= 'z')
            {
                $point = $point + 1;
                $point_min = 1;
            } else if ($lettre >= 'A' && $lettre <= 'Z')
            {
                $point = $point + 2;
                $point_maj = 2;
            } else if ($lettre >= '0' && $lettre <= '9')
            {
                $point = $point + 3;
                $point_chiffre = 3;
            } else
            {
                $point = $point + 5;
                $point_caracteres = 5;
            }
        }
        $etape1 = $point / $longueur;
        $etape2 = $point_min + $point_maj + $point_chiffre + $point_caracteres;
        $resultat = $etape1 * $etape2;
        $final = $resultat * $longueur;

        return $final;
    }

	public function check($name, $conditions)
	{
		$var = $_POST[$name];
		foreach ($conditions as $value) 
		{
			switch ($value)
			{
			    case 'date';

                    $date = new \DateTime('now');
                    $dateBirth = DateTime::createFromFormat('d/m/Y', $var);
                    $diff = $dateBirth->diff($date);
                    if($diff->y < 18)
                        $this->error[$name][] = "Vous devez etre majeur pour vous inscrire";
                    break;
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
				    $point = $this->testpassword($var);
					if ($point < 80)
                        $this->error[$name][] = "Mot de passe non sécurisée (Essayez avec une majuscule, des chiffres et + de six caracteres)";
					break;
				case 'isNumeric';
					if (!is_numeric($var))
						$this->error[$name][] = "Pas un age valide";
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