<?php


Class Notification extends Model
{
    public function getNotification($id)
    {
        $pdo = $this->app->db;
        $notif = $pdo->prepare("SELECT *
         FROM Notification n
         LEFT JOIN users u ON u.id = n.id_users
         LEFT JOIN usersImage im ON im.id_users = n.id_users AND im.isprofil = 1
         WHERE n.id_users_send = $id
         ORDER BY n.id DESC");

        $notif->execute();
        return $notif->fetchAll();

     }

     public function sendLike($id, $idLike)
     {
         $pdo = $this->app->db;

         $message = "A aimé(e) votre profil";
         $notif = $this->insert(array(
             'id_users' => $id,
             'id_users_send' => $idLike,
             'message' => $message,
             'href' => $this->app->router->pathFor('viewProfil', ['id' => $id])
         ));
     }
}

?>