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
}

?>