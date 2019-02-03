<?php

class ErrorController extends Controller
{
    public function process($params)
    {
        header("HTTP/1.0 404 Not Found");
        $this->head['title'] = "Chyba 404";
        $this->head['description'] = "Chyba - stránka nenalezena";
        $this->head['keywords'] = "chyba, 404";
        $this->head['scripts'] = array('navbar-toggling' => 'navbar-scripts.js');

        $this->view='404';

    }
}