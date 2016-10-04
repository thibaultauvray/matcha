<?php


Class Notification extends Model
{
    public function getNotification($id)
    {
        $pdo = $this->app->db;
        $notif = $pdo->prepare("SELECT *
         FROM Notification n
         LEFT JOIN users u ON u.id = n.id_users_send
         LEFT JOIN usersImage im ON im.id_users = n.id_users_send AND im.isprofil = 1
         WHERE n.id_users = $id
         ORDER BY n.id DESC");

        $notif->execute();
        return $notif->fetchAll();

     }
}

?>