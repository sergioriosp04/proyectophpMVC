<?php
//error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

class Core {
    protected $actualController = 'Pages';
    protected $actualMethod = 'index';
    protected $parameters = [];

    public function __construct()
    {
        $url = $this->getUrl();
        //validar si existe el controlador
        if ($url && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            $this->actualController = ucwords($url[0]);
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->actualController . '.php';
        $this->actualController = new $this->actualController;

        if (isset($url[1])) {
            if (method_exists($this->actualController, $url[1])){
                $this->actualMethod = $url[1];
                unset($url[1]);
            } else {
                //var_dump(phpinfo());
                throw new Exception(sprintf(
                    'El metodo %s no existe',
                    $url[1]
                ));
            }
        }

        $this->parameters = $url ? array_values($url) : [];
        call_user_func_array([$this->actualController, $this->actualMethod], $this->parameters);
    }

    public function getUrl()
    {
        if(isset($_GET['url'])){
            $url = filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;      
        } else {
            $url[0]='Pages';
            return $url;
        }
    }
}