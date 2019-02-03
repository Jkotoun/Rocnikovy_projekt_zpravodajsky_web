<?php


class AjaxRouterController extends Controller
{
    protected $controller;
    public function process($params)
    {
        $url_array = $this->urlToArray($params[0]);
        if (empty($url_array[0]))
        {
            $this->redirect('error');
        }
        else
        {
            $controller_url = array_shift($url_array);

        }
        $controller_class = Paths::getControllerClass($controller_url);
        if(file_exists('controllers/ajax/' . $controller_class . '.php'))
        {
            $this->controller = new $controller_class;

        }
        else
        {
            $this->redirect('chyba');
        }
        $this->controller->process($_SERVER["HTTP_REFERER"]);
        if($controller_class!="AjaxLoginController" && $controller_class != "AjaxRegisterController" )
        {
            $this->controller->renderView();

        }
    }

}