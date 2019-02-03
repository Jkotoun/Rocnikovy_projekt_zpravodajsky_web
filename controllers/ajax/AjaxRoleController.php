<?php

class AjaxRoleController extends controller
{

    public function process($params)
    {
        $errors = array();
        if($_POST)
        {
            $user_id = $_POST['user'];
            $role_name= $_POST['role_name'];
            $userManager = New UserManager();
            $roleManager = new UserRoles();


try
{
    $role_id = $roleManager->roleId($role_name);
    $logged_user = $userManager::getLoggedUser();
    if($logged_user['user_id'] == $user_id)
    {
        throw new Exception("Nemůžete upravit svou vlastní roli");
    }
    $userManager->updateUserData(array('user_role'=>$role_id['role_id']),$user_id);
}
catch(Exception $exception)
{
    $errors['role'] = $exception->getMessage();

}
            echo(Json_encode($errors));
        }
    }

}