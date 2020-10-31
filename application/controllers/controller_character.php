<?php


class controller_character extends Controller
{
    function action_stark()
    {
        $this->view->generate('stark_view.html',[
            'activeNavBtn' => 'characters'
        ]);
    }

    function action_lannister()
    {
        $this->view->generate('lannister_view.html',[
            'activeNavBtn' => 'characters'
        ]);
    }

    function action_targaryen()
    {
        $this->view->generate('targaryen_view.html',[
            'activeNavBtn' => 'characters'
        ]);
    }

    function action_other()
    {
        $this->view->generate('other_view.html',[
            'activeNavBtn' => 'characters'
        ]);
    }
}