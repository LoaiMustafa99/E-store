<?php
namespace PHPMVC\CONTROLLERS;
use PHPMVC\LIB\Helper;
use PHPMVC\LIB\InputFilter;
use PHPMVC\LIB\Messenger;
use PHPMVC\MODELS\SupplierModel;

class SuppliersController extends AbstractController
{
    use InputFilter;
    use Helper;

    public function defaultAction()
    {
        $this->language->load('template.common');
        $this->language->load('suppliers.default');

        $this->_data['suppliers'] = SupplierModel::getAll();
        $this->_view();
    }

    public function addAction()
    {
        $this->language->load('validation.errors');
        $this->language->load('template.common');
        $this->language->load('suppliers.add');
        $this->language->load('suppliers.label');
        $this->language->load('suppliers.messages');

        if(isset($_POST['submit'])) {
            $_POST['EmailExists'] = SupplierModel::EmailExists($_POST['Email']);
            if($this->validate->supplier_and_client_Validation($_POST)) {
                $supplier = new SupplierModel();
                $supplier->Name = $this->filterString($_POST['Name']);
                $supplier->Email = $this->filterString($_POST['Email']);
                $supplier->PhoneNumber = $this->filterString($_POST['PhoneNumber']);
                $supplier->Address = $this->filterString($_POST['Address']);

                if($supplier->save()) {
                    $this->messenger->add('Suppliers', $this->language->get('message_create_success'));
                }else {
                    $this->messenger->add('Suppliers', $this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
                }
                $this->redirect('/suppliers');
            }
        }

        $this->_view();
    }

    public function editAction()
    {

        $id = $this->filterInt($this->_params[0]);
        $supplier = SupplierModel::getByID($id);

        if($supplier == false) {
            $this->redirect('/suppliers');
        }

        $this->_data['supplier'] = $supplier;

        $this->language->load('validation.errors');
        $this->language->load('template.common');
        $this->language->load('suppliers.edit');
        $this->language->load('suppliers.label');
        $this->language->load('suppliers.messages');

        if(isset($_POST['submit'])) {


            $_POST['EmailExists'] =  ($supplier->Email == $_POST['Email']) ? false : SupplierModel::EmailExists($_POST['Email']);
            if($this->validate->supplier_and_client_Validation($_POST)) {

                $supplier->Name = $this->filterString($_POST['Name']);
                $supplier->Email = $this->filterString($_POST['Email']);
                $supplier->PhoneNumber = $this->filterString($_POST['PhoneNumber']);
                $supplier->Address = $this->filterString($_POST['Address']);

                if($supplier->save()) {
                    $this->messenger->add('Suppliers', $this->language->get('message_create_success'));
                }else {
                    $this->messenger->add('Suppliers', $this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
                }
                $this->redirect('/suppliers');
            }
        }

        $this->_view();
    }

    public function deleteAction ()
    {
        $this->language->load('suppliers.messages');

        $id = $this->filterInt($this->_params[0]);
        $supplier = SupplierModel::getByID($id);

        if($supplier == false) {
            $this->redirect('/suppliers');
        }

        if($supplier->delete()) {
            $this->messenger->add('Suppliers', $this->language->get('message_delete_success'));
        }else {
            $this->messenger->add('Suppliers', $this->language->get('message_delete_failed'), Messenger::APP_MESSAGE_ERROR);
        }
        $this->redirect('/suppliers');
    }

}