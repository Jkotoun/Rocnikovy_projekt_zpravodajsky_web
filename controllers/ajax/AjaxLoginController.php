<?php

class AjaxLoginController extends controller
{
    public function process($params)
    {
        $errors = array();
        $data = array();
        if ($_POST)
        {
            try
            {
                $userManager = new UserManager();
                $userManager->login($_POST['email'], $_POST['password']);
                $data['success'] = true;
            }
            catch (Exception $error)
            {
                $data['success'] = false;
                $errors['login'] = $error->getMessage();

            }
            finally
            {
                $data['errors'] = $errors;
                echo(json_encode($data));
            }
        }
    }

}