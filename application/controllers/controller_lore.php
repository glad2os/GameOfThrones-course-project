<?php


class controller_lore extends Controller
{
    function action_index()
    {
        $this->view->generate('lore_view.html', [
            "title" => "Game Of Thrones",
            'activeNavBtn' => "lore",
            'scripts' => ['api', 'cookies']
        ]);
    }
}