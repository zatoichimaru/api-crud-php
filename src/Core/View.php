<?php
namespace Core;

class View
{

    private function getPath($file)
    {
        if (DIRECTORY_SEPARATOR == '\\') {
            return str_replace('\\', '/', $file);
        }
        
        return $file;
    }

    public function render($template, $data = null)
    {
        $templatePath = $this->getPath($template);

        if (! is_file($templatePath)) {
            throw new \RuntimeException('Template does not exist');
        }

        ob_start();
        require $templatePath;
        echo ob_get_clean();
    }
}