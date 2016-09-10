<?php

class Users extends Model
{

	public function checkLog($val)
	{
		$pdo = $this->app->db->prepare("SELECT * FROM users WHERE mail = ? AND passwd = ?");
		$pdo->execute(array($val['mail'], hash('whirlpool',$val['passwd'])));
		if (empty($pdo->fetch()))
			return false;
		return true;
	}
}

?>