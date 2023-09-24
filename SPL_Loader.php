<?php
namespace Clicalmani\Container;

/**
 * Holds the root directory
 * 
 * @var string $root_path Root path
 */
global $root_path;

class SPL_Loader 
{
    private $bindings = [
        'App/' => 'app/',
        'Http/' => 'http/',
        'Models/' => 'models/',
        'Middlewares/' => 'middlewares/',
        'Controllers/' => 'controllers/',
        'Authenticate/' => 'authenticate/'
    ];

    public function __construct(private $root_path)
    {
        global $root_path;

        $root_path = $this->root_path;
        spl_autoload_register(fn($className) => $this->load($className)); // Registers the autoloader
    }

    public function load(string $className)
    {
        $fileName  = '';
        $namespace = '';
        
        if (false !== ($lastNsPos = strripos($className, '\\'))) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }

        $fileName = str_replace('\\', '/', $fileName);
        $fileName .= $className . '.php';
        
        $fullFileName = $this->bind($this->root_path . '/' . $fileName);
        
        if ( file_exists($fullFileName) ) {
            require_once $fullFileName;
        }
    }

    public function bind($fullFileName)
    {
        foreach ($this->bindings as $key => $value) {
            $fullFileName = str_replace($key, $value, $fullFileName);
        }

        return $fullFileName;
    }
}
