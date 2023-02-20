<?php

class EnvReader 
{
    private $path = '';

    public function __construct($path)
    {
        $this->path = $path;    
    }

    public function load()
    {
        if(!file_exists($this->path)) 
            return false;

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach($lines as $line)
        {
            if(strpos(trim($line), '#') !== false)
                continue;

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) 
            {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}