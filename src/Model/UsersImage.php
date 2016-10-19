<?php


Class UsersImage extends Model
{
    public function getProfilPic($id)
    {
        $img = $this->app->db->prepare("SELECT * FROM usersImage WHERE id_users = ? AND isprofil = 1");
        $img->execute(array($id));

        $img = $img->fetch();

        return $img['url'];
    }

    public function setAsDefault($id, $idUsers)
    {
        $us = $this->app->db->prepare("UPDATE usersImage SET isprofil = 0 WHERE id_users = ? ");
        $us->execute(array($idUsers));
        $us = $this->app->db->prepare("UPDATE usersImage SET isprofil = 1 WHERE id = ? ");
        $us->execute(array($id));


    }

    public function isProfil($id)
    {
        $img = $this->findOne('id', $id);
        if ($img['isprofil'] == 1)
            return true;

        return false;

    }

    public function deleteImage($id, $idUsers)
    {
        $isprofil = $this->isProfil($id);
        $us = $this->app->db->prepare("DELETE FROM usersImage WHERE id = ? ");
        $us->execute(array($id));
        if ($isprofil)
        {
            $us = $this->findOne('id_users', $idUsers);
            if (!empty($us))
            {
                echo $us['id'];
//            $us = $this->app->db->prepare("UPDATE usersImage SET isprofil = 1 WHERE id = ? ");
//            $us->execute(array($us['id']));
            }
        }

    }
}

?>