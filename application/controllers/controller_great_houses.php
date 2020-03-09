<?php


class controller_great_houses extends Controller
{
    function action_index()
    {
        $this->view->generate('great_houses_view.html', [
            "title" => "Game Of Thrones",
            'activeNavBtn' => "home",
            'scripts' => ['api', 'cookies', 'nav-del', 'index_loader']
        ]);
    }
}