<?php

class Users extends Model
{
    public function __construct($app)
    {
        parent::__construct($app);
    }

    public function getHome()
    {
        $us = $this->app->db->prepare("SELECT u.*, u.id AS id_users, ul.city, img.url
                    FROM users u
                    LEFT JOIN usersLocation ul ON u.id = ul.id_users
                    LEFT JOIN usersImage img ON img.id_users = u.id AND img.isprofil = 1
                   WHERE u.gender = 'f'
                    ORDER BY u.popularity DESC
                    LIMIT 8");
        $us->execute();

        return $us->fetchAll();
    }

    public function updatedLogin($id)
    {
        $date = date("d/m/Y H:i:s");
        $us = $this->app->db->prepare("UPDATE users SET last_seen = ?, isConnected = ? WHERE id = ?");
        $us->execute(array($date, 1, $id));
    }

    public function setSaltForget($id)
    {
        $salt = uniqid();
        $this->update($id, array('salt' => $salt));

        return $salt;
    }

    public function getLocationById($id)
    {
        $loca = $this->app->db->prepare("SELECT * FROM usersLocation WHERE id_users = ?");
        $loca->execute(array($id));
        return $loca->fetch();
    }

    public function getAllUser()
    {
        $pdo = $this->app->db->prepare("SELECT u.*, ui.url, ul.city, ul.longitude, ul.latitude FROM users u INNER JOIN usersImage ui ON ui.id_users = u.id AND ui.isprofil = 1 INNER JOIN usersLocation ul ON ul.id_users = u.id");
        $pdo->execute();
        return $pdo->fetchAll();
    }

    public function checkPass($id, $old, $pass1, $pass2)
    {
        $user = $this->getUsers($id);

        if(hash('whirlpool', $old) != $user['passwd'])
            return -1;
        else if ($pass1 != $pass2)
            return -2;
        else
            $this->update($id, array('passwd' => hash('whirlpool', $pass1)));
        return 1;
    }

    public function changePass($id, $salt, $pass)
    {
        $user = $this->getUsers($id);
        if ($user['salt'] == $salt)
        {
            $this->update($id, array('passwd' => hash('whirlpool', $pass),
                                     'salt'   => uniqid()));
            return true;
        }
        return false;
    }

    public function isGoodSalt($mail, $salt)
    {
        $sal = $this->app->db->prepare("SELECT * FROM users WHERE salt = :salt AND mail = :mail");
        $sal->execute(array('salt' => $salt, 'mail' => $mail));

        if (empty($sal->fetch()))
            return false;

        return true;
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

    public function getUsersByDate()
    {

        $date = new DateTime('-7 days');
        $date = $date->format('d/m/Y');

        $pdo = $this->app->db->prepare("SELECT SUBSTRING(created_at, 1, 10) as date, count(SUBSTRING(created_at, 1, 10)) as cpt FROM `users` WHERE created_at >= ? group by date");
        $pdo->execute(array($date));
        return $pdo->fetchAll();
    }

    public function getAllUsers()
    {
        $user = $this->app->db->prepare("SELECT u.*, url, count(r.id_users_reported) as cptRe FROM users u LEFT JOIN usersImage ui ON u.id=ui.id_users AND ui.isprofil = 1 LEFT JOIN reported r ON r.id_users_reported = u.id AND r.id is not NULL GROUP by r.id_users_reported, IF(r.id_users_reported IS NULL, u.id, 0) ");
            $user->execute();

        return $user->fetchAll();
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

    public function deleteInfo($id)
    {


        $pdo = $this->app->db->prepare("DELETE FROM usersImage WHERE id_users = ?");
        $pdo->execute(array($id));

        $pdo = $this->app->db->prepare("DELETE FROM users_usersInterest WHERE id_users = ?");
        $pdo->execute(array($id));

        $pdo = $this->app->db->prepare("DELETE FROM usersLocation WHERE id_users = ?");
        $pdo->execute(array($id));

        $pdo = $this->app->db->prepare("DELETE FROM notification WHERE id_users = ? OR id_users_send = ?");
        $pdo->execute(array($id, $id));

        $pdo = $this->app->db->prepare("DELETE FROM likable WHERE id_users = ? OR id_users_like = ?");
        $pdo->execute(array($id, $id));

        $pdo = $this->app->db->prepare("DELETE FROM chat WHERE id_auteur = ? OR id_receiver = ?");
        $pdo->execute(array($id, $id));

        $pdo = $this->app->db->prepare("DELETE FROM history WHERE id_users = ? OR id_users_visited = ?");
        $pdo->execute(array($id, $id));

        $pdo = $this->app->db->prepare("DELETE FROM usersblocked WHERE id_users = ? OR id_users_block = ?");
        $pdo->execute(array($id, $id));

        $pdo = $this->app->db->prepare("DELETE FROM reported WHERE id_users = ? OR id_users_reported = ?");
        $pdo->execute(array($id, $id));

        $pdo = $this->app->db->prepare("DELETE FROM users WHERE id = ?");
        $pdo->execute(array($id));

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
        $pdo = $this->app->db->prepare("SELECT ui.id, ui.url, ui.isprofil FROM users u 
										INNER JOIN usersImage ui ON u.id = ui.id_users
										WHERE u.id = ? ");
        $pdo->execute(array($id));

        return $pdo->fetchAll();
    }

    public function isNotLoca($id)
    {
        $pdo = $this->app->db->prepare("SELECT * FROM usersLocation WHERE id_users = ?");
        $pdo->execute(array($id));

        return $pdo->fetch();
    }

    public function getStatuts($id, $idUser)
    {
        if ($id == $idUser)
            return -1;
        $like = $this->app->db->prepare("SELECT *
        FROM likable 
        WHERE (id_users = ? AND id_users_like = ?) OR (id_users = ? AND id_users_like = ?)");
        $like->execute(array($idUser, $id, $id, $idUser));
        if (count($like->fetchAll()) == 2)
        {
            return 2;
        }
        $like = $this->app->db->prepare("SELECT *
        FROM likable 
        WHERE id_users = ? AND id_users_like = ?");
        $like->execute(array($id, $idUser));
        if (count($like->fetchAll()) == 1)
        {
            return 1;
        }

        return 0;

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
        if ($user['orientation'] == "hetero")
        {
            if (($user['gender'] == $user2['gender']) || ($user['gender'] != $user2['gender'] && $user2['orientation'] == "homosexuel"))
                return false;

        } else if ($user['orientation'] == "homosexuel")
        {
            if ($user['gender'] != $user2['gender'] || ($user['gender'] == $user2['gender'] && $user2['orientation'] == "hetero"))
                return false;
        } else if ($user['orientation'] == "bisexuel")
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
        foreach ($listUser as $key => $value)
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
        $sql = "SELECT u.*, u.id AS id_users, ul.city, img.url, (ABS($ong - ul.longitude) + ABS($lat  - ul.latitude)) AS distance,ul.latitude, ul.longitude,  COUNT(up.id_interest) as commonInterest
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
        $usersL->execute(array('terms' => '%' . $string . '%'));
        $usersL = $usersL->fetchAll();
        $usersL = $this->addInteretList($usersL);

        return $usersL;

    }

    public function updatedLocation($id)
    {

    }

    public function getUsersByGender()
    {
        $pdo = $this->app->db->prepare("select count(case when gender='f' then 1 end) as malCpt, count(case when gender='m' then 1 end) as femCpt, count(*) as total_cnt from users");
        $pdo->execute();
        return $pdo->fetch();
    }

    public function getUsersByOrien()
    {
        $pdo = $this->app->db->prepare("SELECT count(CASE WHEN orientation='bisexuel' then 1 end) as bi, count(CASE WHEN orientation='hetero' then 1 end) as he, count(CASE WHEN orientation='homosexuel' then 1 end) as ho FROM users");
        $pdo->execute();
        return $pdo->fetch();
    }

}

?>