<?php

namespace Alex\Annotations\Providers;
use Alex\Annotations\Services\Annotations;
use Illuminate\Support\ServiceProvider;

class AnnotationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->scanFileGetAnnotations($this->getClasses());
    }

    protected function getClasses()
    {
        $dirs = $this->ReadAllDirAndFiles();
        $files = $dirs['file'];
        $classes = [];
        $bashpath = str_replace('/', '\\', base_path()) . '\app';
        foreach ($files as $val) {
            $path = str_replace('/', '\\', str_replace('.php', '', $val));
            $classes[] = 'App' . str_replace($bashpath, '', $path);
        }
        return$classes;
    }

    protected function scanFileGetAnnotations($classes)
    {
        $bind = require __DIR__ . '/../Config/Bind.php';
        Annotations::bind($bind);
        foreach ($classes as $class) {
            $this->app->resolving($class, function ($object) use ($class)  {
                Annotations::register($object);
            });
        }
    }

    private function ReadAllDirAndFiles()
    {
        $allDir = [];
        $allFile = [];

        $basePath = base_path() . '/app';
        if ($basePath === false) {
            return false;
        }

        $allDir[] = $basePath;
        $allHandleDir = $allDir;

        while (!empty($allHandleDir)) {
            $basePathTemp = array_pop($allHandleDir);
            $allObj = scandir($basePathTemp);

            foreach ($allObj as $item) {
                if ($item == '.' || $item == '..') {
                    continue;
                }

                $path = $basePathTemp . '/' . $item;
                if (is_dir($path)) {
                    $allDir[] = $path;
                    $allHandleDir[] = $path;
                } else {
                    $allFile[] = $path;
                }
            }
        }
        return [
            'dir'  => $allDir,
            'file' => $allFile
        ];
    }
}
