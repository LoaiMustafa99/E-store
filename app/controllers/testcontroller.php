<?php
namespace PHPMVC\CONTROLLERS;
use PHPMVC\LIB\Validate;
use PHPMVC\MODELS\UserGroupPrivilegeModel;

class TestController extends AbstractController
{
    use Validate;
    public function defaultAction()
    {
        $privileges = UserGroupPrivilegeModel::getBy(['GroupId' => $this->session->u->GroupId]);
        echo "<pre>";
        var_dump($privileges);
        echo "</pre>";
    }

}