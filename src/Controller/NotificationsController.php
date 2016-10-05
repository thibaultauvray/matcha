<?php

class NotificationsController extends Controller
{
    public function like($request, $response, $args)
    {
        $idLike = $_POST['id'];
        $id = $this->getUserId();
        $response->withHeader('Content-type', 'application/json');

        if ($id == $idLike)
        {
            $response->withJson(array('error' => "1"));
            return $response;
        }
        $like = new Likable($this->app);

        $likable = $like->likeUser($id, $idLike);
        if($likable != -1)
        {
            $like->insert(array('id_users' => $id,
                                    'id_users_like' => $idLike));
            $notif = new Notification($this->app);

            $notif->sendLike($id, $idLike);
            $response->withJson(array('error' => "0"));
        }
        else if($likable == -1)
        {
            $like->deleteLike($id, $idLike);
            $response->withJson(array('error' => "2"));
        }
        return $response;

    }

    public function getLike($request, $response, $args)
    {
        $like = new Likable($this->app);
        $idLike = $_GET['id'];
        $id = $this->getUserId();
        $response->withHeader('Content-type', 'application/json');

        $likable = $like->likeUser($id, $idLike);
        if($likable == 0)
        {
            $response->withJson(array('error' => "0"));
        }
        else if($likable == -1)
        {
            $response->withJson(array('error' => "2"));
        }
        return $response;

    }
}

?>