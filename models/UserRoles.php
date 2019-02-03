<?php

class UserRoles
{
public static function user_role($user_id)
{
   return Database::queryOne(
       'Select role_id, role_name 
               from user_roles as r
               inner join users as u on r.role_id = u.user_role
               where u.user_id = ?
               ',array($user_id)
   );
}
public function allRoles()
{
    return Database::queryAll('
    select * from user_roles
    ');
}
public static function logged_user_can($permission)
{
    $userManager = new UserManager();
    $user = $userManager->getLoggedUser();
    if(!$user)
    {
        return false;
    }
    $role = self::user_role($user['user_id']);
    $has_permission = Database::query('
    Select * 
    from roles_permissions as r
    inner join permissions as p on r.permission_id = p.permission_id
    inner join user_roles as u on r.role_id = u.role_id
    where u.role_id = ? AND p.permission_name = ?
    
    ',array($role['role_id'],$permission));
    if($has_permission)
    {
        return true;
    }
    else
    {
        return false;
    }
}
public function roleId($role_name)
{

        return Database::queryOne('
    select role_id 
    from user_roles
    where role_name = ?
    ', array($role_name));

}
}