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
        $users = new Users($this->app);
        $id = $this->getUserId();
        $user = $users->findById($idLike);
        if(empty($user))
        {
            $uri = $request->getUri()->withPath($this->app->router->pathFor('homepage'));
            $this->app->flash->addMessage('fail', 'Une erreur s\'est produit, duh');

            return $response = $response->withRedirect($uri, 403);
        }
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

    public function listChat($request, $response, $args)
    {
        $chat = new Chat($this->app);
        $users = new Users($this->app);
        $id = $args['id'];
        $user = $users->findById($id);
        if(empty($user) || $id != $this->getUserId())
        {
            $uri = $request->getUri()->withPath($this->app->router->pathFor('homepage'));
            $this->app->flash->addMessage('fail', 'Une erreur s\'est produit, duh');

            return $response = $response->withRedirect($uri, 403);
        }
        $chat = $chat->getUsersChat($id);

        return $this->app->view->render($response, 'views/chat/list.twig', array('chat' => $chat));
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
        $arr = array('lastID' => $lastId, 'html' => $this->app->view->renderView($response, 'views/chat/message.twig', array('error'    => $error,
                                                                                                                         'userLike' => $userLike,
                                                                                                                         'message'  => $msg,
                                                                                                                         'lastId'   => $lastId,
                                                                                                                         'idRec'    => $idLike
        )));
        $response->withHeader('Content-type', 'application/json');
        $response->withJson(array($arr));
        return $response;

//        return $this->app->view->render($response, 'views/chat/message.twig', array('error'    => $error,
//                                                                                    'userLike' => $userLike,
//                                                                                    'message'  => $msg,
//                                                                                    'lastId'   => $lastId,
//                                                                                    'idRec'    => $idLike
//        ));

    }
}