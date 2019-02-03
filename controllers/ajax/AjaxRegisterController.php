<?php

class AjaxRegisterController extends controller
{
public function process($params)
{
    $errors = array();
    $data = array();
    if($_POST)
    {
        try
        {
            $usermanager = new UserManager();
            $usermanager->register($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['password'],
                 $_POST['birth_day'], $_POST['birth_month'],
                $_POST['birth_year'], $_POST['gender']);
            $usermanager->login($_POST['email'], $_POST['password']);
            $data['success'] = true;
        }
        catch (Exception $error)
        {
            $data['success'] = false;
            $errors['mail'] = $error->getMessage();
        }
        finally
        {
            $data['errors'] = $errors;
            echo(json_encode($data));
        }


    }
}
}