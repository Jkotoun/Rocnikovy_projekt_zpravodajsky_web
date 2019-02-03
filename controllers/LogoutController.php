<?php

class LogoutController extends Controller
{
    public function process($params)
    {
        $userManager = new UserManager();
        $userManager->logout();
        $this->redirect(ltrim(parse_url($_SERVER["HTTP_REFERER"],PHP_URL_PATH),"/"));
    }

}