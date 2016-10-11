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
                                        INNER JOIN usersImage rimg ON c.id_auteur = rimg.id_users
                                        WHERE (id_auteur = ? AND id_receiver =?) 
                                        OR (id_auteur = ? AND id_receiver = ?)
                                        ORDER BY c.id");
        $msg->execute(array($id, $idRec, $idRec, $id));

        return $msg->fetchAll();
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
                                        INNER JOIN usersImage rimg ON c.id_auteur = rimg.id_users
                                        WHERE ((id_auteur = ? AND id_receiver =?) 
                                        OR (id_auteur = ? AND id_receiver = ?))
                                        AND c.id > ?
                                        ORDER BY c.id");
        $msg->execute(array($id, $idRec, $idRec, $id, $lastId));
        return $msg->fetchAll();
    }

}