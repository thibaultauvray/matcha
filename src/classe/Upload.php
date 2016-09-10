<?php 


Class Upload{ 

	private $extension = ['image/jpg', 'image/jpeg', 'image/bmp', 'image/png'];

	private $files;

	public function __construct($files)
	{
		$this->files = $files;
	}

	public function upload()
	{
		if (count($this->files) > 5)
		{
			return "Trop de fichiers";
		}
		foreach ($this->files as $file) {
			if (in_array($file->getType(), $this->extension) && $file->getSize() < 500000)
			{
				$name = uniqid();
				$uploaddir = __DIR__ . "/../../public/img/";
				$uploadfile = $uploaddir . basename($name);
				echo $file->getFile();
				if (move_uploaded_file($file->getFile(), $uploadfile)) {
				    echo "Le fichier est valide, et a été téléchargé
				           avec succès. Voici plus d'informations :\n";
				} else {
				    echo "Attaque potentielle par téléchargement de fichiers.
				          Voici plus d'informations :\n";
				}
			}
		}
	}
}
?>