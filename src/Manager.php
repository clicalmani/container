<?php
namespace Clicalmani\Container;

class Manager extends SPL_Loader
{
    /**
     * Inject into service container
     * 
     * @param string|callable $class_or_file
     * @return void
     */
    public function inject(string|callable $class_or_file) : void
    {
        if (is_callable($class_or_file)) include_once $class_or_file();
        else $this->load($class_or_file);
    }
}
