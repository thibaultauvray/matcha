<?php

class Users extends Model
{

    public function checkLog($val)
    {
        $pdo = $this->app->db->prepare("SELECT * FROM users WHERE mail = ? AND passwd = ?");
        $pdo->execute(array($val['mail'], hash('whirlpool', $val['passwd'])));
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
        $pdo = $this->app->db->prepare("SELECT * FROM users u INNER JOIN usersLocation ul ON ul.id_users = u.id WHERE u.id = ?");
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


    /*
     *  SUGGESTION
     */


    public function isCompatible($user, $user2)
    {
        if($user['orientation'] == "hetero")
        {
            if (($user['gender'] == $user2['gender']) || ($user['gender'] != $user2['gender'] && $user2['orientation'] == "homosexuel"))
                return false;

        }
        else if($user['orientation'] == "homosexuel")
        {
            if ($user['gender'] != $user2['gender'] || ($user['gender'] == $user2['gender'] && $user2['orientation'] == "hetero"))
                return false;
        }
        else if($user['orientation'] == "bisexuel")
        {
            if ($user['gender'] == $user2['gender'] && $user2['orientation'] == "hetero")
                return false;
            if ($user['gender'] != $user2['gender'] && $user2['orientation'] == "homosexuel")
                return false;
        }
        return true;
    }

    public function removeOrientation($listUsers, $users)
    {
        foreach ($listUsers as $key => $value)
        {
            if (!$this->isCompatible($users, $value))
            {
                unset($listUsers[$key]);
            }
        }
        return $listUsers;
    }

    public function findSuggest($id)
    {
        $pdo = $this->app->db;


        $users = $this->getUsers($id);
        $orientation = $users['orientation'];
        $gender = $users['gender'];
        $lat = $users['latitude'];
        $long = $users['longitude'];

        $sql = "SELECT u.*, img.url, (ABS($lat - ul.longitude) + ABS($long  - ul.latitude)) AS distance,  COUNT(up.id_interest) as commonInterest
        FROM users u
        LEFT JOIN users_usersInterest ui ON ui.id_users = u.id
        LEFT JOIN (SELECT id_interest FROM `users_usersInterest` WHERE id_users = $id) up on up.id_interest = ui.id_interest
        LEFT JOIN usersLocation ul ON ul.id_users = u.id
        LEFT JOIN usersImage img ON img.id_users = u.id AND img.isprofil = 1
        WHERE u.gender LIKE (CASE '$gender'
                             WHEN 'f' THEN (
                                CASE '$orientation'
                                   WHEN 'hetero' THEN 'm'
                                   WHEN 'homosexuel' THEN 'f'
                                   ELSE '%%'
                                 END)
                             WHEN '$gender' THEN (
                                CASE '$orientation'
                                   WHEN 'hetero' THEN 'f'
                                   WHEN 'homosexuel' THEN 'm'
                                   ELSE '%%'
                                END)
                       END)
        AND u.id <> $id
        GROUP BY u.id, ui.id_users, distance, img.id
        ORDER BY distance ASC, commonInterest DESC";
        $usersL = $pdo->prepare($sql);
        $usersL->execute();
        $listUsers = $usersL->fetchAll();
        $listUsers = $this->removeOrientation($listUsers, $users);
        return $listUsers;
    }

    public function updatedLocation($id)
    {

    }

}

?>