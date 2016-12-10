<?php

namespace WebLab;

use Twig_Autoloader;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Exception;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Core - test core app class. Singelton.
 * @author Andrey Lisnyak <munspel@ukr.net>
 */
class Core {

    protected $BASE_DIR = "";
    protected $config = array();

    /**
     * @var Illuminate\Database\Capsule\Manager
     * @link http://laravel.su/docs/5.0/eloquent 
     */
    protected $capsule;

    /**
     *
     * @var Twig_Environment 
     */
    protected $twig = null;

    /**
     * Статическая переменная, в которой мы
     * будем хранить экземпляр класса
     *
     * @var SingletonTest
     */
    protected static $_instance;

    /**
     * Закрываем доступ к функции вне класса.
     * Паттерн Singleton не допускает вызов
     * этой функции вне класса
     *
     */
    private function __construct() {
        /**
         * При этом в функцию можно вписать
         * свой код инициализации. Также можно
         * использовать деструктор класса.
         * Эти функции работают по прежднему,
         * только не доступны вне класса
         */
    }

    /**
     * Закрываем доступ к функции вне класса.
     * Паттерн Singleton не допускает вызов
     * этой функции вне класса
     *
     */
    private function __clone() {
        
    }

    /**
     * Статическая функция, которая возвращает
     * экземпляр класса или создает новый при
     * необходимости
     *
     * @return SingletonTest
     */
    public static function getInstance() {
        // проверяем актуальность экземпляра
        if (null === self::$_instance) {
            // создаем новый экземпляр
            self::$_instance = new self();
        }
        // возвращаем созданный или существующий экземпляр
        return self::$_instance;
    }
    /**
     * Parse $_SERVER["QUERY_STRING"]
     * @return route
     * @throws Exception
     */
    protected function getRoute() {
        $mathes = null;
        $query = $_SERVER["QUERY_STRING"];
        
        if (empty($query)) {
            $query = "q=" . $this->config["DefaultRoute"];
        }
       
        $is_mathed = preg_match('/^q=(?<route>(?<controller>\\w+)\\/(?<action>\\w+)(\\/\\w+)*)([?&]?(?<param>.*))/', $query, $mathes);
        if (!$is_mathed || empty($mathes["controller"]) || empty($mathes["action"])) {
            throw new Exception("Не верный формат запроса!");
        }
       
        return $mathes["route"];
    }

    /**
     * Run the app
     * @param type $config
     */
    public function run($config) {

        if (is_file($config)) {
            $this->config = include $config;
        } else {
            // load default config   
        }
        $this->bootstrap();

        $route = $this->getRoute();

        $this->handleRequest($route);
    }

    /**
     * Base app method
     * @param type $uri
     */
    protected function handleRequest($uri) {
        try {
            if (empty($uri)) {
                $uri = $this->config["DefaultRoute"];
            }
            $request = explode('/', $uri);
            $className = '\\WebLab\\Controllers\\' . ucfirst(array_shift($request));
            $actionName = "do" . ucfirst(array_shift($request));
            if (class_exists($className)) {
                $controller = new $className();
                $controller->init($this);
                if (method_exists($controller, $actionName)) {
                    $params = array();
                    while (count($request) > 0) {
                        $params[] = array_shift($request);
                    }
                    call_user_func_array(array($controller, $actionName), $params);
                }
            } else {
                throw new Exception("Controller class $className does not exist!");
            }
        } catch (Exception $ex) {
            echo $this->getTwig()->render("error.tpl.php", ["msg" => $ex->getMessage(), "trace" => $ex->getTraceAsString()]);
        }
    }

    /**
     * Return site name from config
     */
    public function getSiteName() {
        return $this->config["SiteName"];
    }

    public function log($error_msg) {
        trigger_error($error_msg, E_USER_ERROR);
    }

    /**
     * Return twig object
     * @return Twig_Environment
     */
    public function getTwig() {
        if (empty($this->twig)) {
            try {
                Twig_Autoloader::register(true);
                $loader = new Twig_Loader_Filesystem($this->config["components"]["twig"]["template_path"]);
                $this->twig = new Twig_Environment($loader, array(
                    'cache' => $this->config["components"]["twig"]["cache_path"],
                    'debug' => true,
                ));
            } catch (Exception $ex) {
                $this->log($ex->getMessage());
            }
        }
        return $this->twig;
    }

    /**
     * Suppose, you are browsing in your localhost 
     * http://localhost/myproject/index.php?id=8
     */
    function getBaseUrl() {
        // output: /myproject/index.php
        $currentPath = $_SERVER['PHP_SELF'];

        // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
        $pathInfo = pathinfo($currentPath);

        // output: localhost
        $hostName = $_SERVER['HTTP_HOST'];

        // output: http://
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';

        // return: http://localhost/myproject/
        return $protocol . $hostName . $pathInfo['dirname'] . "/";
    }

    /**
     * Load app components
     */
    protected function bootstrap() {
        session_start();
        $this->capsule = new Capsule;

        $this->capsule->addConnection($this->config["components"]["db"]);

        $this->capsule->bootEloquent();


        \PhpConsole\Connector::getInstance()->setServerEncoding('cp1251');
        \PhpConsole\Helper::register();
    }

}
