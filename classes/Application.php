<?php

namespace Landingo\Resources;

class Application
{
    public $base_url = null;

    private $_module = null;
    public $_page = null;
    public $_act = null;
    public $_params = array();

    public function __construct()
    {
        $conf = new Config();

        $this->base_url = $conf->get('app.base_url');

        $this->_module = $conf->get('app.default_module');
        $this->_page = $conf->get('app.default_page');
        $this->_page = $conf->get('app.default_act');
        $this->_params = $conf->get('app.default_params');

        $conf->close();

    }
    public function start()
    {
        $uri = Uri::get();

        if(isset($uri['module']))
        {
            $this->_module = $uri['module'];
        }

        if(isset($uri['page']))
        {
            $this->_page = $uri['page'];
        }

        if(isset($uri['act']))
        {
            $this->_act = $uri['act'];
        }
        
        $this->_params = $uri['params'];

        if(!file_exists(BASE_DIR . '/module/' . $this->_module . '.php'))
        {
            $this->_module = 'home';
            $this->_page = '404';
        }

        $this->reqFile();
    }

    public function loadPage()
    {
        if(!$this->_page)
        {
            $this->_page = 'index';
        }
        $file = BASE_DIR . "/module/page/{$this->_module}/{$this->_page}.php";

        if(!file_exists($file))
        {
            $file = $file = BASE_DIR . "/module/page/{$this->_module}/404.php";
        }

        $base_url = $this->base_url;
        require_once $file;
    }

    private function reqFile()
    {
        $base_url = $this->base_url;
        require_once BASE_DIR . '/module/' . $this->_module . '.php';
    }
}