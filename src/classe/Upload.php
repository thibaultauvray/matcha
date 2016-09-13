<?php 


Class Upload{ 

	private $extension = ['image/jpg', 'image/jpeg', 'image/bmp', 'image/png'];

	private $files;

	public $baseUrl;

	public $error;

	public function __construct($files)
	{
		$this->files = $files;
	}

	public function upload($count)
	{
		foreach ($this->files as $file) {
			if (in_array($file->getType(), $this->extension) && $file->getSize() < 500000)
			{
				$name = uniqid();
				$uploaddir = __DIR__ . "/../../public/img/";
				$onlyType = explode("/", $file->getType())[1];
				$uploadfile = $uploaddir . basename($name) . "." . $onlyType;
				if (move_uploaded_file($file->getFile(), $uploadfile) && $count <= 4) {
					$this->baseUrl[] = basename($name) . "." . $onlyType;
					$count++;
				} else if ($count >= 5) {
					$this->error[] = "Trop d'image (max 5)";
				}
				else
				{
					$this->error[] = "Une erreur inconnu est arrivé";
				}
			}
			else
			{
				$this->error[] = "Fichier trop lourd ou non pris en charge (jpg, bmp, png)";
			}
		}
		if ($this->error)
			$this->error = array_unique($this->error);
	}
}
?>