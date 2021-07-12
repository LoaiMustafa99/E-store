<?php


namespace PHPMVC\CONTROLLERS;


class NotFoundController extends AbstractController
{
    public function notFoundAction()
    {
        $this->_language->load('template.common');
        $this->_view();
    }
}