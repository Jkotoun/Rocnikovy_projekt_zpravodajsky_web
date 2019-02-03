<?php
/**
 * Created by PhpStorm.
 * User: Josef Kotoun
 * Date: 26.11.2018
 * Time: 21:57
 */

class UsersManagementController extends controller
{
public function process($params)
{
    if(!UserRoles::logged_user_can('manage-users'))
    {
        $this->redirect('chyba');
    }
    $userRoles = new UserRoles();
    $userManager = new UserManager();
    $search='';
    $this->head = array(
        'title' => 'Správa uživatelů',
        'keywords' => 'uživatelé, administrace',
        'description' => 'Správá uživatelů v administraci',
        'scripts'=>  array('admin_script.js')
    );
    if ($_POST) {
        $search = $_POST['search'];
        $users = $userManager->SearchUser($search);
    }
    else {
        if (isset($params[0]) && isset($params[1]) && $params[1] == 'delete') {
            try {
                if (!UserRoles::logged_user_can('manage-users')) {
                    throw new Exception("Nedostatečná oprávnění");
                }
                if($params[0] == UserManager::getLoggedUser()['user_id'])
                {
                    throw new Exception("Nemůžete smazat sám sebe");
                }
                $userManager->removeUser($params[0]);
                $this->addSuccess("Uživatel odstraněn");
                $this->redirect('administrace/uzivatele');

            } catch (Exception $error) {
                $this->addError($error->getMessage());
            }

        }
        else if (isset($params[0]) && is_numeric($params[0])) {
            $current_page = $params[0];
            $page_count = 10;
            $max_page = ceil($userManager->UsersCount() / $page_count);
            if ($current_page > $max_page) {
                $this->redirect('administrace/uzivatele/' . $max_page);
            }
            if ($current_page < 1) {
                $this->redirect('administrace/uzivatele/1');
            }
            $users = $userManager->UsersInfo($page_count, ($current_page * $page_count) - $page_count);
            $this->data['current_page'] = $current_page;
            $this->data['max_page'] = $max_page;


        } else {
            $this->data['current_page'] = 1;
            $this->data['max_page'] = ceil($userManager->UsersCount() / 10);
            $users = $userManager->UsersInfo(10, 0);
        }
    }
    foreach($users as $index => $value)
    {
$users[$index]['articles_count'] = $userManager->userArticlesCount($users[$index]['user_id']);

    }
    $this->data['users'] = $users;
    $this->data['roles'] = $userRoles->allRoles();
    $this->data['search']=$search;
    $this->head['active_menu_li'] ='users-management';
    $this->view = 'users_management';
    $this->data['messages'] = $this->getMessages();
}
}