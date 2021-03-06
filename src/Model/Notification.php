<?php


Class Notification extends Model
{
    public function getNotification($id)
    {
        $pdo = $this->app->db;
        $notif = $pdo->prepare("SELECT *, n.id as idNotif
         FROM Notification n
         LEFT JOIN users u ON u.id = n.id_users
         LEFT JOIN usersImage im ON im.id_users = n.id_users AND im.isprofil = 1
         WHERE n.id_users_send = $id
         ORDER BY n.id DESC
        ");

        $notif->execute();

        return $notif->fetchAll();

    }

    public function mutualLike($id, $idLike)
    {
        $message = "est connecté a vous !";
        $isBLock = new usersBlocked($this->app);

            $this->insert(array(
                'id_users'      => $id,
                'id_users_send' => $idLike,
                'message'       => $message,
                'href'          => $this->app->router->pathFor('chatIndex', ['id' => $idLike])));
        if (!$isBLock->isBlock($id, $idLike))
        {
            $notif = $this->insert(array(
                'id_users'      => $idLike,
                'id_users_send' => $id,
                'message'       => $message,
                'href'          => $this->app->router->pathFor('chatIndex', ['id' => $idLike])
            ));
        }

    }

    public function sendLike($id, $idLike)
    {
        $pdo = $this->app->db;
        $isBLock = new usersBlocked($this->app);
        if (!$isBLock->isBlock($idLike, $id))
        {
            $message = "A aimé(e) votre profil";
            $notif = $this->insert(array(
                'id_users'      => $id,
                'id_users_send' => $idLike,
                'message'       => $message,
                'href'          => $this->app->router->pathFor('viewProfil', ['id' => $id])
            ));
        }
    }

    public function sendNotification($id, $idSend, $message, $path = null)
    {
        $isBLock = new usersBlocked($this->app);
        if (!$isBLock->isBlock($idSend, $id))
        {
            $notif = $this->insert(array('id_users'      => $id,
                                         'id_users_send' => $idSend,
                                         'message'       => $message,
                                         'href'          => $path));

        }
    }

    public function getCountUnreadNotif($id)
    {

        $notif = $this->app->db->prepare("SELECT *
         FROM Notification n 
         LEFT JOIN users u ON u.id = n.id_users
         LEFT JOIN usersImage im ON im.id_users = n.id_users AND im.isprofil = 1
         WHERE n.reading = 0
         AND n.id_users_send = ?");

        $notif->execute(array($id));

        return count($notif->fetchAll());
    }

    public function setAsRead($id)
    {
        $notif = $this->app->db->prepare("UPDATE Notification SET reading = 1 WHERE id = ?");

        $notif->execute(array($id));


    }

}

?>