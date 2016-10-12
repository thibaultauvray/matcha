<?php


    class Controller {

        protected $app;
        protected $view;
        protected $flash;
        protected $router;


        public function __construct($container) {
            $this->app = $container;
            $this->view = $this->app->view;
            $this->flash = $this->app->flash;
            $this->router = $this->app->router;


        }

        public function isLogged()
        {
        	if (isset($_SESSION['login']) && !empty($_SESSION['login']))
        		return true;
        	return false;
        }

        public function getNotification()
        {
            $users = new Notification($this->app);

            $id = $this->getUserId();
            $notifications = $users->getNotification($id);
            return $notifications;
        }
        public function noProfilPic()
        {
            $id = $this->getUserId();

            $img = new UsersImage($this->app);
            $img = $img->getProfilPic($id);
            return $img;
        }

        public function getCountUnreadNotif()
        {
            $notif = new Notification($this->app);

            $id = $this->getUserId();
            $nb = $notif->getCountUnreadNotif($id);
            return $nb;
        }

        public function getUserId()
        {
        	if (isset($_SESSION['login']) && !empty($_SESSION['login']))
        		return ($_SESSION['login']['id']);
    		return false;
        }

        public function upPopularity($id, $int)
        {
            $user = new Users($this->app);

            if ($id == $this->getUserId())
                return false;
            $user->addition($id, "popularity", $int);
        }
    }
    ?>