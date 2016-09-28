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

	public function getInterest($id)
	{
		$pdo = $this->app->db->prepare("SELECT * FROM users u 
										INNER JOIN users_usersInterest uui ON uui.id_users = u.id
										INNER JOIN usersInterest ui ON uui.id_interest = ui.id
										WHERE u.id = ? ");
		$pdo->execute(array($id));
		return $pdo->fetchAll();
	}

	public function getUsers($id)
    {
        $pdo = $this->app->prepare("SELECT * FROM users u WHERE id = ?");
        $pdo->execute(array($id));

        return $pdo->fetch();
    }

	public function getStringInterest($id)
	{
		$pdo = $this->app->db->prepare("SELECT ui.interest FROM users u 
										INNER JOIN users_usersInterest uui ON uui.id_users = u.id
										INNER JOIN usersInterest ui ON uui.id_interest = ui.id
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

    public function getImageProfil($id)
    {
        $pdo = $this->app->db->prepare("SELECT ui.url FROM users u 
										INNER JOIN usersImage ui ON u.id = ui.id_users
										WHERE u.id = ? AND ui.isprofil = 1");
        $pdo->execute(array($id));
        return $pdo->fetch();
    }

    public function getCity($id)
    {
        $pdo = $this->app->db->prepare("SELECT l.city FROM users u
                                    INNER JOIN usersLocation l ON l.id_users = u.id
                                    WHERE u.id = ?");
        $pdo->execute(array($id));
        return $pdo->fetch();
    }

    public function getOrientation($user)
    {
        $gender = $user['gender'];

        if($gender == "m" && $user['orientation'] == "hetero")
        {

        }
    }

    /*
     *  SUGGESTION
     */

    public function findSuggest($id)
    {
        $pdo = $this->app->db;

        $users = $this->getUsers($id);
        $users->getOrientation($user);
        if ($users['orientation'] == "hetero")
            $genderWant = "";
        $users = $pdo->prepare("SELECT * FROM users u
                                INNER JOIN usersLocation l ON l.id_users = u.id");

    }
	public function updatedLocation($id)
	{

	}

}

?>