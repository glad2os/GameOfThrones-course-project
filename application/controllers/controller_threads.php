<?php

use Exception\IllegalArgumentException;
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
                'scripts' => ['api', 'cookies'],
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
            'scripts' => ['api', 'cookies']
        ]);
    }

    function action_add()
    {

        $request = json_decode(file_get_contents("php://input"), true);

        if ((!isset($request['title'])) ||
            (!isset($request['text']))
        ) throw new IllegalArgumentException("Fields title, text, author must be exists");
        $this->model->addThread($request['title'], $request['text'], $request['img']);
        http_response_code(204);
    }

    function action_getAll()
    {
        $allThreads = $this->model->getAllThreads();
        $return = [];
        foreach ($allThreads as $thread) {
            $login = $this->model->getAuthor($thread['id']);
            array_push($thread, $login);
            array_push($return, $thread);
        }
        print json_encode($return);
    }
}