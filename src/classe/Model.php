<?php

class Model
{

	protected $app;
	public $name;

	public function __construct($app)
	{
		$this->app = $app;
		$this->name = strtolower(get_called_class());
	}

	/*
	*	INSERT / UPDATE / DELETE FUNCTION
	*/

	public function insert($values)
	{
		foreach ($values as $key => $v) {
			$table[] = $key;
			$int = $int . "?,";
			$val[] = $v;
		}
		$col = implode(',', $table);
		$int = substr($int, 0, -1);
		$pdo = $this->app->db->prepare("INSERT INTO $this->name($col) VALUES($int)");
		$pdo->execute($val);
	}

	public function update($id, $values)
	{
		foreach ($values as $key => $v) {
			$table[] = $key . " = ?";
			$val[] = $v;
		}
		$val[] = $id;
		$col = implode(',', $table);
		$pdo = $this->app->db->prepare("UPDATE $this->name SET $col WHERE id = ?");
		$pdo->execute($val);
	}

	public function delete($id)
	{
		$pdo = $this->app->db->prepare("DELETE FROM $this->name WHERE id = :id");
		$pdo->execute(array(
				'id' => $id
			));

	}

	/*
	*	FIND FUNCTIONS
	*/
	public function find($col, $id)
	{
		$pdo = $this->app->db->prepare("SELECT * FROM $this->name WHERE $col = :id");
		$pdo->execute(array(
				'id'	=> $id
			));
		return $pdo->fetchAll();
	}

	public function findAll()
	{
		$pdo = $this->app->db->prepare("SELECT * FROM $this->name" );
		$pdo->execute();
		return $pdo->fetchAll();
	}

	public function findLast()
	{
		$pdo = $this->app->db->prepare("SELECT * FROM $this->name ORDER BY id DESC LIMIT 1" );
		$pdo->execute();
		return $pdo->fetch();
	}
}

?>