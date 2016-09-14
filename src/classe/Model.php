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
		$int = $int . "?,";
		$int = $int . "?,";
		$table[] = "created_at";
		$table[] = "updated_at";
		$val[] = date("d/m/Y H:i:s");
		$val[] = date("d/m/Y H:i:s");
		$col = implode(',', $table);
		$int = substr($int, 0, -1);
		$pdo = $this->app->db->prepare("INSERT INTO $this->name($col) VALUES($int)");
		$pdo->execute($val);
		return $this->app->db->lastInsertId();
	}

	public function update($id, $values)
	{
		foreach ($values as $key => $v) {
			$table[] = $key . " = ?";
			$val[] = $v;
		}
		$table[] = "updated_at = ?";
		$val[] = date("d/m/Y H:i:s");
		$val[] = $id;
		$col = implode(',', $table);
		$pdo = $this->app->db->prepare("UPDATE $this->name SET $col WHERE id = ?");
		$pdo->execute($val);
	}

	public function deleteSpecial($col, $id)
	{
		$pdo = $this->app->db->prepare("DELETE FROM $this->name WHERE $col = :id");
		$pdo->execute(array(
				'id' => $id
			));
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

	public function findById($id)
	{
		$pdo = $this->app->db->prepare("SELECT * FROM $this->name WHERE id = :id");
		$pdo->execute(array(
				'id'	=> $id
			));
		return $pdo->fetch();
		
	}
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

	/*
	*  USEFULL FUNCTION
	*/

	public function isUnique($col, $value)
	{
		$pdo = $this->app->db->prepare("SELECT $col FROM $this->name WHERE $col = ?");
		$pdo->execute(array($value));
		if (empty($pdo->fetchAll()))
			return true;
		return false;
	}
}

?>