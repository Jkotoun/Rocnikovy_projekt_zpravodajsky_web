<?php
class LoginController extends Controller
{
 public function process($params)
 {
     $userManager = new UserManager();
     if($userManager->getLoggedUser())
     {
         $this->redirect('');
     }
     $this->head = array(
         'title' => 'Přihlášení',
         'keywords' => 'login, login-form',
         'description' => 'Přihlášení uživatele',
         'scripts' => array('navbar-toggling' => 'navbar-scripts.js', 'login'=>'Forms.js')
     );

     $this->view = 'login';
 }
}