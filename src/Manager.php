<?php
namespace Clicalmani\Container;

class Manager extends SPL_Loader
{
    public function inject(string|callable $class_or_file)
    {
        if (is_callable($class_or_file)) include_once $class_or_file();
        else $this->load($class_or_file);
    }
}
