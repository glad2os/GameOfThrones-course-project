<?php


class View
{
    function generate($content_view, $data = null)
    {
        if(is_array($data)) {
            // преобразуем элементы массива в переменные
            extract($data);
        }

        include __DIR__ . '/../views/template_view.php';
    }

}