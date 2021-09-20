<?php
namespace App\Config\Loader;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

class YamlLoader extends FileLoader
{
    public function load($resource, $type = null)
    {
        $configValues = Yaml::parse(file_get_contents($resource));
        return $this;
    }

    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'yaml' === pathinfo(
                $resource,
                PATHINFO_EXTENSION
            );
    }
}