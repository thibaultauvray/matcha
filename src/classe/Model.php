<?php

class Model
{

	protected $app;

	public function __construct($app)
	{
		$this->app = $app;
	}

	public function find($table, $col, $id)
	{
		$pdo = $this->app->db->prepare('SELECT * FROM users');
		$pdo->execute();
		return $pdo->fetchAll();
	}
}

?>