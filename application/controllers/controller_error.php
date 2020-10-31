<?php

class controller_error extends Controller
{
    /**
     * @param $exception Exception
     */
    function action_exception($exception)
    {
        $this->view->generate('error_view.html', [
            'title' => $exception->getCode() . ' Error',
            'code' => $exception->getCode(),
            'message' => $exception->getMessage()
        ]);
    }
}