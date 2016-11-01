<?php

/**
 * Created by PhpStorm.
 * User: tauvray
 * Date: 10/12/16
 * Time: 11:39 AM
 */
class History extends Model
{

    public function getVisitor($id)
    {
        $pdo = $this->app->db;
        $user = $pdo->prepare("SELECT h.created_at as date, img.url as url, u.nickname as nickname
                               FROM history h
                               LEFT JOIN users u ON  h.id_users_visited = u.id
                               LEFT JOIN usersImage img ON img.id_users = h.id_users_visited AND img.isprofil = 1
                                WHERE h.id_users = :id
                                ORDER BY date DESC
");
        $user->execute(array('id' => $id));
        return $user->fetchAll();
    }
}