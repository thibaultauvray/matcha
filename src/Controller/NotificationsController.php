<?php

class NotificationsController extends Controller
{
    public function like($request, $response, $args)
    {
        if(!$this->noProfilPic())
        {
            $response->withJson(array('error' => "-1"));
            return $response;
        }
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
            $mutual = $like->isMutual($id, $idLike);
            if ($mutual == 1)
            {
                $notif = new Notification($this->app);
                $notif->mutualLike($id, $idLike);
            }
        }
        else if($likable == -1)
        {
            $mutual = $like->isMutual($id, $idLike);
            if ($mutual == 1)
            {
                $notif = new Notification($this->app);
                $notif->sendNotification($id, $idLike, "n\'est plus connecté(e) a vous");
            }
            $like->deleteLike($id, $idLike);
            $response->withJson(array('error' => "2"));
        }
        return $response;

    }



    public function getLike($request, $response, $args)
    {
        $id = $this->getUserId();


        $like = new Likable($this->app);
        $idLike = $_GET['id'];
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

    public function getFormatNotif($unread)
    {
        foreach ($unread as $u)
        {
            $href = $u['href'];
            $baseUrl = $_SERVER['SERVER_NAME'];
            $url = $u['url'];
            $nickname = $u['nickname'];
            $msge = $u['message'];
            $msg[] = "<li><a href='$href'><img width=50 height=50 src='http://$baseUrl/img/$url'>$nickname $msge</a></li>";
        }

        return $msg;

    }

    public function readNotif($request, $response, $args)
    {
        $id = $_POST['id'];

        $notif = new Notification($this->app);
        $notif->setAsRead($id);
        $idUser = $this->getUserId();
        $nb = $notif->getCountUnreadNotif($idUser);
        $response->withHeader('Content-type', 'application/json');
        $response->withJson(array('nb' => $nb));

        return $response;

    }

    public function getCountNotif($request, $response, $args)
    {
        $response->withHeader('Content-type', 'application/json');
        $idUser = $this->getUserId();
        $notif = new Notification($this->app);
        $nb = $notif->getCountUnreadNotif($idUser);
        $response->withJson(array('nb' => $nb));

        return $response;

    }

    public function getUnreadNotif($request, $response, $args)
    {
        return $this->app->view->render($response, 'views/users/notification.twig', array('suggest'   => $userSuggest,
                                                                                     'routeName' => $name,
                                                                                     'data'      => $_POST['terms']));
    }
}

?>