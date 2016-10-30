<?php

/**
 * Created by PhpStorm.
 * User: tauvray
 * Date: 10/22/16
 * Time: 12:13 PM
 */
class Reported extends Model
{
    public function report($id, $idUser)
    {
        $pdo = $this->app->db;
        $report = $pdo->prepare("SELECT * FROM reported WHERE id_users = ? AND id_users_reported = ?");
        $report->execute(array($idUser, $id));
        if (empty($report->fetch()))
        {
            $this->insert(array('id_users'          => $idUser,
                                'id_users_reported' => $id));
            return true;
        }
        else
            return false;
    }

    public function isReported($id, $idUser)
    {
        $pdo = $this->app->db;
        $report = $pdo->prepare("SELECT * FROM reported WHERE id_users = ? AND id_users_reported = ?");
        $report->execute(array($idUser, $id));
        if (empty($report->fetch()))
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function getReportUser($id)
    {
        $rep = $this->app->db->prepare("SELECT u.id, u.nickname FROM `users` u INNER JOIN reported r ON r.id_users_reported = ? AND r.id_users = u.id");
        $rep->execute(array($id));
        return $rep->fetchAll();
    }
}