<?php


namespace PHPMVC\CONTROLLERS;


class IndexController extends AbstractController
{
    public function defaultAction()
    {
        $this->_language->load('template.common');
        $this->_view();
    }

}