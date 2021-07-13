<?php


namespace PHPMVC\CONTROLLERS;


class IndexController extends AbstractController
{
    public function defaultAction()
    {
        $this->language->load('template.common');
        $this->language->load('index.default');
        $this->_view();
    }

}