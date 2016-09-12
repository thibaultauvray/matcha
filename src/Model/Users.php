<?php

class Users extends Model
{

	public function checkLog($val)
	{
		$pdo = $this->app->db->prepare("SELECT * FROM users WHERE mail = ? AND passwd = ?");
		$pdo->execute(array($val['mail'], hash('whirlpool',$val['passwd'])));
		$us = $pdo->fetch();
		if (empty($us))
			return false;
		return $us;
	}

	public function getInfo($id)
	{
		$pdo = $this->app->db->prepare("SELECT * FROM users u 
										INNER JOIN usersImage ui ON u.id = ui.id_users
										WHERE u.id = ? ");
		$pdo->execute(array($id));
		$arr['img'] = $pdo->fetchAll();
		$pdo = $this->app->db->prepare("SELECT * FROM users u 
										INNER JOIN usersInterest ui ON u.id = ui.id_users
										WHERE u.id = ? ");
		$pdo->execute(array($id));
		$arr['interet'] = $pdo->fetchAll();
		return $pdo->fetchAll();
	}
}

?>