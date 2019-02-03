<?php

class AccessDeniedController extends Controller
{
    public function process($params)
    {
        $this->head['title'] = "Přístup odepřen";
        $this->head['description'] = "Přístup odepřen";
        $this->head['keywords'] = "přístup odepřen, nedostatečná práva";
        $this->head['scripts'] = array('navbar-toggling' => 'navbar-scripts.js');

        $this->view='AccessDenied';

    }
}