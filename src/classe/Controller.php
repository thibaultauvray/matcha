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
    }
    ?>