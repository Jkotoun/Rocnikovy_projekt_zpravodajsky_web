<?php
abstract class Controller
{

    protected $data = array();
    protected $view = "";
	protected $head = array('title' => '', 'keywords' => '', 'description' => '', 'scripts' => array());
    public function addError($message)
    {
        if (isset($_SESSION['messages']['errors']))
            $_SESSION['messages']['errors'] = $message;
        else
            $_SESSION['messages']['errors'] = array($message);
    }
    public function addSuccess($message)
    {
        if (isset($_SESSION['messages']['success']))
            $_SESSION['messages']['success'] = $message;
        else
            $_SESSION['messages']['success'] = array($message);
    }
    public function getMessages()
    {
        if (isset($_SESSION['messages']))
        {
            $messages = $_SESSION['messages'];
            unset($_SESSION['messages']);
            return $messages;
        }
        else
            return array();
    }
    protected function urlToArray($url)
    {
        $parsed_url = parse_url($url);
        $parsed_url["path"] = ltrim($parsed_url["path"], "/");
        $parsed_url["path"] = trim($parsed_url["path"]);
        $path_array = explode("/", $parsed_url["path"]);
        return $path_array;
    }
    public function renderView()
    {
        if ($this->view)
        {
            extract($this->escape_vars($this->data));
            extract($this->data, EXTR_PREFIX_ALL, "");
            require("views/" . $this->view . ".php");
        }
    }
	public function redirect($url)
	{
		header("Location: /$url");
		header("Connection: close");
        exit;
	}
    private function escape_vars($x = null)
    {
        if (!isset($x))
            return null;
        elseif (is_string($x))
            return htmlspecialchars($x, ENT_QUOTES);
        elseif (is_array($x))
        {
            foreach($x as $k => $v)
            {
                $x[$k] = $this->escape_vars($v);
            }
            return $x;
        }
        else
            return $x;
    }
    abstract function process($params);

}