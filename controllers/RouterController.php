<?php

class RouterController extends Controller
{
	protected $controller;

    public function process($params)
    {
        $administration = false;
        $loggedUser = UserManager::getLoggedUser();
        $url_array = $this->urlToArray($params[0]);
        if (empty($url_array[0])) {
            $controller_url = 'kategorie';
            $this->view = 'layouts/default-template';
            $controller_class = Paths::getControllerClass($controller_url);
        } else {
            $controller_url = array_shift($url_array);
            if ($controller_url == 'administrace') {

                if (!$loggedUser) {
                    $this->redirect('prihlaseni');
                }
                if (!UserRoles::logged_user_can('access-administration')) {
                    $this->redirect('access-denied');
                }
                $this->view = 'layouts/admin-template';
                $administration = true;


                if (empty($url_array[0])) {
                    $this->redirect('administrace/clanky');
                } else {
                    $controller_url = array_shift($url_array);
                }
                $controller_class = Paths::getControllerAdminClass($controller_url);

            } else {

                $this->view = 'layouts/default-template';
                $controller_class = Paths::getControllerClass($controller_url);
            }

        }
        if (file_exists('controllers/' . $controller_class . '.php')) {
            $this->controller = new $controller_class;
        } else {
            $this->redirect('chyba');
        }

        $this->controller->process($url_array);
        if ($administration) {
            $this->data['active_menu_li'] = $this->controller->head['active_menu_li'];
        }
            $this->data['title'] = $this->controller->head['title'];
            $this->data['description'] = $this->controller->head['description'];
            $this->data['keywords'] = $this->controller->head['keywords'];
            $this->data['logged_user'] =  UserManager::getLoggedUser();

            $this->data['scripts'] = $this->controller->head['scripts'];



            $this->renderView();







	
    }
}