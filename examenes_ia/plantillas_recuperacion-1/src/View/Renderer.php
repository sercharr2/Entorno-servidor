<?php

namespace App\View;

class Renderer
{
    protected $templatePath;

    public function __construct($templatePath)
    {
        $this->templatePath = rtrim($templatePath, '/') . '/';
    }

    public function render($template, $data = [])
    {
        $filePath = $this->templatePath . $template . '.php';

        if (!file_exists($filePath)) {
            throw new \Exception("Template not found: " . $filePath);
        }

        ob_start();
        extract($data);
        include $filePath;
        return ob_get_clean();
    }
}