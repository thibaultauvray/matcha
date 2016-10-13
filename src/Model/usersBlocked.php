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
            return true;
        }
        else
        {
            $this->delete($idDel);
            return false;
        }
    }

    public function getListBlock($id)
    {
        $blocked = $this->app->db->prepare("SELECT id_users_block FROM usersblocked WHERE id_users = ?");
        $blocked->execute(array($id));
        foreach ($blocked->fetchAll() as $arr)
        {
            $list[] = $arr['id_users_block'];
        }
        if(empty($list))
        {
            return "' '";
        }
        $list = implode(',', $list);

        return $list;

    }

    public function isBlock($id, $idBlock)
    {
        $pdo = $this->app->db;

        $block = $pdo->prepare("SELECT * FROM usersBlocked WHERE id_users = ? AND id_users_block = ?");
        $block->execute(array($id, $idBlock));
        if(empty($block->fetch()))
        {
            return false;
        }
        else{
            return true;
        }
    }
}