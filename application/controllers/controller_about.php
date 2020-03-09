<?php


class controller_about extends Controller
{
    function action_index()
    {
        $this->view->generate('about_view.html', [
            "title" => "Game Of Thrones",
            'activeNavBtn' => "home",
            'scripts' => ['api', 'cookies', 'nav-del', 'index_loader']
        ]);
    }
}