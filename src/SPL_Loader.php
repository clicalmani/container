<?php
namespace Clicalmani\Container;

/**
 * Holds the root directory
 * 
 * @var string $root_path Root path
 */
global $root_path;

$root_path = dirname( dirname( dirname( dirname( __DIR__ ) ) ) );

/**
 * Class SPL_Loader
 * 
 * @package Clicalmani\Container
 * @author @clicalmani
 */
class SPL_Loader 
{
    private $bindings = [
        'App/' => 'app/',
        'Http/' => 'http/',
        'Requests/' => 'requests/',
        'Models/' => 'models/',
        'Middlewares/' => 'middlewares/',
        'Controllers/' => 'controllers/',
        'Authenticate/' => 'authenticate/',
        'Providers/' => 'providers/',
        'Database/' => 'database/',
        'Factories/' => 'factories/',
        'Seeders/' => 'seeders/',
        'Test/' => 'test/',
        'Events' => 'events',
        'Commands' => 'commands'
    ];

    /**
     * Constructor
     * 
     * @param ?string $root_path
     */
    public function __construct(private ?string $root_path = null)
    {
        spl_autoload_register(fn($className) => $this->load($className)); // Registers the autoloader
    }

    /**
     * Load a class
     * 
     * @param string $className
     * @return void
     */
    public function load(string $className) : void
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
        
        if ( @ file_exists($fullFileName) ) {
            require_once $fullFileName;
        }
    }

    /**
     * Bind dependence
     * 
     * @param string $fullFileName
     * @return string
     */
    public function bind(string $fullFileName) : string
    {
        foreach ($this->bindings as $key => $value) {
            $fullFileName = str_replace($key, $value, $fullFileName);
        }

        return $fullFileName;
    }
}
