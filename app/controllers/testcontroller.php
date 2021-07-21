<?php
namespace PHPMVC\CONTROLLERS;
use PHPMVC\LIB\Validate;

class TestController extends AbstractController
{
    use Validate;
    public function defaultAction()
    {
        var_dump(date('Y-m-d'));
    }

}