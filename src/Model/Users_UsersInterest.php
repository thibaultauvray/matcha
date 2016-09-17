<?php
	
class Users_UsersInterest extends Model
{
	public function interestExist($id, $id_int)
	{
		$pdo = $this->app->db->prepare("SELECT * FROM users_usersInterest WHERE id_users = ? AND id_interest = ?");
		$pdo->execute(array($id, $id_int));
		return $pdo->fetchAll();
	}

	public function deleteAllInterest($id)
	{
		$pdo = $this->app->db->prepare("SELECT uui.id FROM users_usersInterest uui
										INNER JOIN users u ON uui.id_users = u.id
										INNER JOIN usersInterest ui ON uui.id_interest = ui.id
										WHERE u.id = ? ");
		$pdo->execute(array($id));
		foreach ($pdo->fetchAll() as $value) {
			$this->delete($value['id']);
		}
	}
}

?>