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
        $pdo = $this->app->db->prepare("SELECT * FROM users u WHERE id = ?");
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

        SET @lat = 0.000 ; SET @long = 0.000; SET @myGender = 'm'; SET @myOrientation = 'hetero'; SET @myUserId = 7;

SELECT u.*,(ABS(@long - ul.longitude) + ABS(@lat - ul.latitude)) AS distance,  COUNT(up.id_interest) as commonInterest
FROM users u
INNER JOIN users_usersInterest ui ON ui.id_users = u.id
LEFT JOIN (SELECT id_interest FROM `users_usersInterest` WHERE id_users = @myUserId) up on up.id_interest = ui.id_interest
INNER JOIN usersLocation ul ON ul.id_users = u.id
WHERE u.gender LIKE (CASE @myGender
                     WHEN 'f' THEN (
                        CASE @myOrientation
                           WHEN 'hetero' THEN 'm'
                           WHEN 'homosexuel' THEN 'f'
                           ELSE '%%'
                         END)
                     WHEN 'm' THEN (
                        CASE @myOrientation
                           WHEN 'hetero' THEN 'f'
                           WHEN 'homosexuel' THEN 'm'
                           ELSE '%%'
                        END)
               END)
AND u.orientation LIKE (CASE @myOrientation
                        WHEN 'bisexuel' THEN '%%'
                        ELSE @myOrientation
                        END)

GROUP BY u.id, ui.id_users, distance
ORDER BY distance ASC, commonInterest DESC

        $users = $this->getUsers($id);
        var_dump($users['orientation']);
//        $users = $pdo->prepare("SELECT DISTINCT u.*, (ABS(@long - ul.longitude) + ABS(@lat - ul.latitude)) AS distance
//FROM users u
//INNER JOIN usersLocation ul ON ul.id_users = u.id
//WHERE u.gender LIKE (CASE @myGender
//                     WHEN 'f' THEN (
//                     	CASE @myOrientation
//                           WHEN 'hetero' THEN 'm'
//                           WHEN 'homosexuel' THEN 'f'
//                           ELSE '%%'
//                         END)
//                     WHEN 'm' THEN (
//                     	CASE @myOrientation
//                           WHEN 'hetero' THEN 'f'
//                           WHEN 'homosexuel' THEN 'm'
//                           ELSE '%%'
//                        END)
//				   END)
//AND u.orientation LIKE (CASE @myOrientation
//                        WHEN 'bisexuel' THEN '%%'
//                        ELSE @myOrientation
//                        END)
//
//ORDER BY distance ASC");

    }
	public function updatedLocation($id)
	{

	}

}

?>