<?php

/**
 * Created by PhpStorm.
 * User: tauvray
 * Date: 10/10/16
 * Time: 1:26 PM
 */
class Chat extends Model
{
    public function getMessage($id, $idRec)
    {
        $msg = $this->app->db->prepare("SELECT c.id AS idChat, rimg.url as url, message, r.nickname, c.id_receiver as idRec, c.created_at AS date
                                        FROM chat c
                                        INNER JOIN users r ON r.id = c.id_auteur
                                        INNER JOIN usersImage rimg ON c.id_auteur = rimg.id_users AND rimg.isprofil = 1
                                        WHERE (id_auteur = ? AND id_receiver =?) 
                                        OR (id_auteur = ? AND id_receiver = ?)
                                        ORDER BY c.id");
        $msg->execute(array($id, $idRec, $idRec, $id));

        return $msg->fetchAll();
    }

    public function getUsersChat($id)
    {
        $pdo = $this->app->db;
        $users =  $pdo->prepare('SELECT l.id_users, u.nickname, img.url, c.message, c.created_at FROM likable l
                                 LEFT JOIN chat c ON c.id_auteur = l.id_users
                                 LEFT JOIN users u ON l.id_users = u.id
                                 LEFT JOIN usersImage img ON img.id_users = u.id AND img.isprofil = 1
                                 LEFT JOIN usersblocked b ON u.id = l.id_users
                                WHERE l.id_users_like = ? AND l.id_users IN (SELECT id_users_like FROM likable WHERE id_users = ?)
                                AND l.id_users NOT IN(SELECT u1.id_users_block FROM usersblocked u1 WHERE u1.id_users = ?)
                                GROUP BY l.id_users
                                ORDER BY c.created_at DESC');
        $users->execute(array($id, $id, $id));
        return $users->fetchAll();
    }

    public function post($id, $idRec, $msg)
    {
        $id = $this->insert(array('id_auteur'   => $id,
                            'id_receiver' => $idRec,
                            'message'     => $msg));
        return $id;
    }

    public function getLastMsg($lastId, $id, $idRec)
    {
        $msg = $this->app->db->prepare("SELECT c.id AS idChat, rimg.url as url, message, r.nickname, c.id_receiver as idRec, c.created_at AS date
                                        FROM chat c
                                        INNER JOIN users r ON r.id = c.id_auteur
                                        INNER JOIN usersImage rimg ON c.id_auteur = rimg.id_users AND rimg.isprofil = 1
                                        WHERE id_auteur = ? AND id_receiver =?
                                       AND c.id > ?
                                        ORDER BY c.id");
        $msg->execute(array($idRec,$id, $lastId));
        return $msg->fetchAll();
    }

}