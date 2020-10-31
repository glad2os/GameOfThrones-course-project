<?php

class controller_main extends Controller
{
    function action_index()
    {
        $this->view->generate('index_view.html', [
            "title" => "Game Of Thrones",
            'activeNavBtn' => "home",
            'scripts' => ['api', 'cookies','threads_loader']
        ]);
    }
}