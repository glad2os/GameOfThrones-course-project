<?php

use \Exception\NotFoundException;

class controller_threads extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model = new model_threads();
    }

    function action_get()
    {
        try {
            $routes = preg_split('/[\/?]/', $_SERVER['REQUEST_URI']);
            $thread = $this->model->getThread($routes[3]);
            if ($thread == null) throw new NotFoundException('Thread not found');
            $this->view->generate('threads_view.html', [
                "title" => "Account",
                'activeNavBtn' => "account",
                'scripts' => ['api', 'cookies', 'nav-del', 'index_loader'],
                'threadTitle' => $thread['title'],
                'date' => $thread['date_post'],
                'author' => $thread['login'],
                'text' => $thread['text'],
                'img' => $thread['img']
            ]);
        } catch (RuntimeException $exception) {
            $this->view->generate('error_view.html', [
                "title" => $exception->getCode() . " Error",
                'activeNavBtn' => "account",
                'scripts' => ['nav-del', 'index_loader'],
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }

    }

    function action_post()
    {
        $this->view->generate('post_view.html', [
            "title" => "Account",
            'activeNavBtn' => "account",
            'scripts' => ['api', 'cookies', 'nav-del', 'index_loader']
        ]);
    }
}