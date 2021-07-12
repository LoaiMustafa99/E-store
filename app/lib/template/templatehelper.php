<?php
namespace PHPMVC\LIB\TEMPLATE;


trait TemplateHelper
{
    public function matchUrl($url) {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === $url;
    }


}