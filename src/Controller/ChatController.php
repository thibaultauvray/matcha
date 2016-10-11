<?php

/**
 * Created by PhpStorm.
 * User: tauvray
 * Date: 10/10/16
 * Time: 12:08 PM
 */
class ChatController extends Controller
{
    public function index($request, $response, $args)
    {
        $idLike = $args['id'];
        $id = $this->getUserId();
        $like = new Likable($this->app);
        $user = new Users($this->app);
        $chat = new Chat($this->app);

        $userLike = $user->findById($idLike);
        if (!$like->isMutual($id, $idLike))
            $error = 1;
        $msg = $chat->getMessage($id, $idLike);
        $lastId = end($msg)['idChat'];
        if (!$lastId)
            $lastId = 0;

        return $this->app->view->render($response, 'views/chat/index.twig', array('error'    => $error,
                                                                                  'userLike' => $userLike,
                                                                                  'message'  => $msg,
                                                                                  'lastId'   => $lastId,
                                                                                  'idRec'    => $idLike
        ));
    }

    public function postMessage($request, $response, $args)
    {
        $error = 0;
        $idLike = $_POST['id'];
        $like = new Likable($this->app);
        $id = $this->getUserId();
        $notif = new Notification($this->app);
        if (!$like->isMutual($id, $idLike))
        {
            $error = 1;
        }
        else
        {
        $notif->sendNotification($id, $idLike, 'vous a envoyé(e) un message', $this->app->router->pathFor('chatIndex', array('id' => $id)));

        $msg = $_POST['msg'];
        $chat = new Chat($this->app);
        $imgM = new UsersImage($this->app);
        $idChat = $chat->post($id, $idLike, $msg);
        $img = $imgM->getProfilPic($id);
        $date = $chat->findById($idChat)['created_at'];
        $nickname = $_SESSION['login']['nickname'];
        }
        return $this->app->view->render($response, 'views/chat/messageSingle.twig', array('error'    => $error,
                                                                                          'id'       => $id,
                                                                                          'nickname' => $nickname,
                                                                                          'idChat'   => $idChat,
                                                                                          'date'     => $date,
                                                                                          'url'      => $img,
                                                                                          'userLike' => $userLike,
                                                                                          'message'  => $msg,
                                                                                          'lastId'   => $lastId,
                                                                                          'idRec'    => $idLike));

    }

    public function getMessage($request, $response, $args)
    {
        $lastId = $_GET['lastId'];
        $idRec = $_GET['idRec'];
        $id = $this->getUserId();
        $chat = new Chat($this->app);

        $msg = $chat->getLastMsg($lastId, $id, $idRec);
        $lastId = end($msg)['idChat'];

        return $this->app->view->render($response, 'views/chat/message.twig', array('error'    => $error,
                                                                                    'userLike' => $userLike,
                                                                                    'message'  => $msg,
                                                                                    'lastId'   => $lastId,
                                                                                    'idRec'    => $idLike
        ));

    }
}