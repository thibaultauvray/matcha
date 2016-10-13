<?php

class Users extends Model
{
    public function __construct($app)
    {
        parent::__construct($app);
        echo $cc;
    }

    public function updatedLogin($id)
    {
        echo $id;
        $date = date("d/m/Y H:i:s");
        $us = $this->app->db->prepare("UPDATE users SET last_seen = ?, isConnected = ? WHERE id = ?");
        $us->execute(array($date, 1, $id));
    }

    public function setDisconnected($id)
    {
        $date = date("d/m/Y H:i:s");
        $us = $this->app->db->prepare("UPDATE users SET last_seen = ?, isConnected = ? WHERE id = ?");
        $us->execute(array($date, 0, $id));
    }

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

    public function addInteretList($listUser)
    {
        foreach ( $listUser as $key => $value)
        {
            $listUser[$key]['interestString'] = $this->getStringInterest($value['id_users']);
        }
        return $listUser;
    }

    public function findSuggest($id)
    {
        $pdo = $this->app->db;

        $block = new usersBlocked($this->app);
        $block = $block->getListBlock($id);
        $users = $this->getUsers($id);
        $orientation = $users['orientation'];
        $gender = $users['gender'];
        $lat = $users['latitude'];
        $long = $users['longitude'];
        $sql = "SELECT u.*, u.id AS id_users, ul.city, img.url, (ABS($ong - ul.longitude) + ABS($lat  - ul.latitude)) AS distance,  COUNT(up.id_interest) as commonInterest
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
        AND u.id NOT IN($block)
        GROUP BY u.id, ui.id_users, distance, img.id, ul.city
        ORDER BY distance ASC, commonInterest DESC, u.popularity DESC";
        $usersL = $pdo->prepare($sql);
        $usersL->execute();
        $listUsers = $usersL->fetchAll();
        $listUsers = $this->removeOrientation($listUsers, $users);
        $listUsers = $this->addInteretList($listUsers);
        return $listUsers;
    }



    public function findSearch($string, $id)
    {
        $pdo = $this->app->db;
        $usersL = $pdo->prepare("SELECT u.*, u.id AS id_users, ul.city, img.url, COUNT(up.id_interest) as commonInterest
        FROM users u
        LEFT JOIN users_usersInterest ui ON ui.id_users = u.id
        LEFT JOIN (SELECT id_interest FROM `users_usersInterest` WHERE id_users = $id) up on up.id_interest = ui.id_interest
        LEFT JOIN usersLocation ul ON ul.id_users = u.id
        LEFT JOIN usersImage img ON img.id_users = u.id AND img.isprofil = 1
        WHERE (u.nickname LIKE :terms OR u.name LIKE :terms OR u.lastname LIKE :terms)
        AND u.id != $id
        GROUP BY u.id, ui.id_users,img.id, ul.city");
        $usersL->execute(array('terms' => '%'.$string.'%'));
        $usersL = $usersL->fetchAll();
        $usersL = $this->addInteretList($usersL);

        return $usersL;

    }

    public function updatedLocation($id)
    {

    }

}

?>