<?php


class UserProfileController extends Controller
{
    public function process($params)
    {
        $userManager = new UserManager();
        $contentManager = new ContentManager();
        $userData = $userManager->getUserByUrl($params[0]);;
        if(!$userData)
        {
            $this->redirect('chyba');
        }
        $comments = $contentManager->getUsersComments($userData['user_id'], 10, 0);

        $this->head = array(
            'title' => $userData['first_name'] . " " . $userData['last_name'],
            'keywords' => 'uživatel, profil, komentáře',
            'description' => 'Uživatelský profil uživatele ' . $userData['first_name'] . " " . $userData['last_name'],
            'scripts' => array('navbar-toggling' => 'navbar-scripts.js', 'ajax' => 'AjaxLoader.js', 'loading' => 'UserProfileData.js')
        );
        $userData['birth_date'] = date_diff(date_create($userData['birth_date']), date_create('today'))->y;
        $this->data['user'] = $userData;
        $this->data['comments'] = $comments;
        $this->view = 'profile';
    }

}