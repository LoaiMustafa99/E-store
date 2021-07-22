<?php
namespace PHPMVC\CONTROLLERS;
use PHPMVC\LIB\Validate;
use PHPMVC\MODELS\UserGroupPrivilegeModel;

class TestController extends AbstractController
{
    use Validate;
    public function defaultAction()
    {
        echo "<pre>";
        var_dump($this->session->u);
        echo "</pre>";
    }

}