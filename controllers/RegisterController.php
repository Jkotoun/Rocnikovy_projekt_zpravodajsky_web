<?php
/**
 * Created by PhpStorm.
 * User: Josef Kotoun
 * Date: 01.11.2018
 * Time: 18:51
 */

class RegisterController extends Controller
{

    public function process($params)
    {
        $usermanager = new UserManager();
        if($usermanager->getLoggedUser())
        {
            $this->redirect('');
        }
        $this->head = array(
            'title' => 'Registrace',
            'keywords' => 'register, new user',
            'description' => 'Registrace nového uživatele',
            'scripts' => array('navbar-toggling' => 'navbar-scripts.js', 'register'=>'Forms.js')
        );

        $this->view= 'register';
    }
}