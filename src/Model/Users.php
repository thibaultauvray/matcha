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

	public function getStringInterest($id)
	{
		$pdo = $this->app->db->prepare("SELECT ui.interest FROM users u 
										INNER JOIN usersInterest ui ON ui.id_users = u.id
										WHERE u.id = ? ");
		$pdo->execute(array($id));
		foreach ($pdo->fetchAll() as $k => $v)
			$arr[] = $v['interest'];
		if (empty($arr))
			return false;
		return implode(',', $arr);
	}

	public function getCountImage($id)
	{
		$pdo = $this->app->db->prepare("SELECT ui.url FROM users u 
										INNER JOIN usersImage ui ON u.id = ui.id_users
										WHERE u.id = ? ");
		$pdo->execute(array($id));
		return count($pdo->fetchAll());
	}

	public function getImage($id)
	{
		$pdo = $this->app->db->prepare("SELECT ui.url FROM users u 
										INNER JOIN usersImage ui ON u.id = ui.id_users
										WHERE u.id = ? ");
		$pdo->execute(array($id));
		return $pdo->fetchAll();
	}
}

?>