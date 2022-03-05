<?php

namespace Core\Controller;

class Controller{

    protected $viewPath;
    protected $template;

    protected function render($view, $variables = [])
    {
        ob_start();
        extract($variables);
        require($this->viewPath . str_replace('.', '/', $view) . '.php');
        $content = ob_get_clean();
        require($this->viewPath . 'templates/'. $this->template . '.php');

    }

    protected function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');
        die("<b>403.</b> <br /> Your client does not have permission to get URL from this server.  <small style=\"color:grey\">That's all we know.</small> <br/> <a href=\"index.php\" style=\"font-weight:bold;font-style:italic;text-decoration:none;\">Back home page</a>");
    }

    protected function notFound()
    {
        header('HTTP/1.0 404 Not found');
        die("<b>404.</b> <br /> The requested URL was not found on this server. <small style=\"color:grey\">That's all we know.</small>");
    }

}