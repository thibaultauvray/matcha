<?php

/**
 * Created by PhpStorm.
 * User: tauvray
 * Date: 10/12/16
 * Time: 5:23 PM
 */
class usersBlocked extends Model
{

    public function block($id, $idblock)
    {
        $pdo = $this->app->db;

        $block = $pdo->prepare("SELECT * FROM usersBlocked WHERE id_users = ? AND id_users_block = ?");
        $block->execute(array($id, $idblock));
        $idDel = $block->fetch()['id'];
        if (!$idDel)
        {
            $this->insert(array('id_users' => $id,
                                'id_users_block' => $idblock));
        }
        else
        {
            $this->delete($idDel);
        }
    }
}