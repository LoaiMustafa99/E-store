<?php


namespace PHPMVC\CONTROLLERS;


class NotFoundController extends AbstractController
{
    public function notFoundAction()
    {
        $this->language->load('template.common');
        $this->_view();
    }
}