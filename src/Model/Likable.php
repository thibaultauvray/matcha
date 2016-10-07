<?php


Class Likable extends Model
{
    public function likeUser($id, $idLike)
    {
        $like = $this->app->db->prepare("SELECT *
        FROM likable 
        WHERE id_users = ? AND id_users_like = ?");
        $like->execute(array($id, $idLike));

        if (!empty($like->fetchAll()))
        {
            return -1;
        }
        $like = $this->app->db->prepare("SELECT *
        FROM likable 
        WHERE id_users_like = ?");
        $like->execute(array($id));
        $lika = $like->fetchAll();
        if(!empty($lika))
        {
            return $lika['id'];
        }
        return 0;
    }

    public function isMutual($id, $idLike)
    {
        $like = $this->app->db->prepare("SELECT *
        FROM likable 
        WHERE id_users = ? AND id_users_like = ?");
        $like->execute(array($idLike, $id));
        if (!empty($like->fetchAll()))
        {
            return 1;
        }
        return 0;
    }

    public function deleteLike($id, $idLike)
    {
        $pdo = $this->app->db->prepare("DELETE FROM $this->name WHERE id_users = :id AND id_users_like = :idLike");
        $pdo->execute(array(
            'id' => $id,
            'idLike' => $idLike
        ));
    }

}

?>