<?php
namespace PHPMVC\CONTROLLERS;
use PHPMVC\LIB\Helper;
use PHPMVC\LIB\InputFilter;
use PHPMVC\LIB\Messenger;
use PHPMVC\MODELS\ClientModel;

class ClientsController extends AbstractController
{
    use InputFilter;
    use Helper;

    public function defaultAction()
    {
        $this->language->load('template.common');
        $this->language->load('clients.default');

        $this->_data['clients'] = ClientModel::getAll();
        $this->_view();
    }

    public function addAction()
    {
        $this->language->load('validation.errors');
        $this->language->load('template.common');
        $this->language->load('clients.add');
        $this->language->load('clients.label');
        $this->language->load('clients.messages');

        if(isset($_POST['submit'])) {
            $_POST['EmailExists'] = ClientModel::EmailExists($_POST['Email']);
            if($this->validate->supplier_and_client_Validation($_POST)) {
                $client = new ClientModel();
                $client->Name = $this->filterString($_POST['Name']);
                $client->Email = $this->filterString($_POST['Email']);
                $client->PhoneNumber = $this->filterString($_POST['PhoneNumber']);
                $client->Address = $this->filterString($_POST['Address']);

                if($client->save()) {
                    $this->messenger->add('Clients', $this->language->get('message_create_success'));
                }else {
                    $this->messenger->add('Clients', $this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
                }
                $this->redirect('/clients');
            }
        }

        $this->_view();
    }

    public function editAction()
    {

        $id = $this->filterInt($this->_params[0]);
        $client = ClientModel::getByID($id);

        if($client == false) {
            $this->redirect('/clients');
        }

        $this->_data['client'] = $client;

        $this->language->load('validation.errors');
        $this->language->load('template.common');
        $this->language->load('clients.edit');
        $this->language->load('clients.label');
        $this->language->load('clients.messages');

        if(isset($_POST['submit'])) {


            $_POST['EmailExists'] =  ($client->Email == $_POST['Email']) ? false : ClientModel::EmailExists($_POST['Email']);
            if($this->validate->supplier_and_client_Validation($_POST)) {

                $client->Name = $this->filterString($_POST['Name']);
                $client->Email = $this->filterString($_POST['Email']);
                $client->PhoneNumber = $this->filterString($_POST['PhoneNumber']);
                $client->Address = $this->filterString($_POST['Address']);

                if($client->save()) {
                    $this->messenger->add('Clients', $this->language->get('message_create_success'));
                }else {
                    $this->messenger->add('Clients', $this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
                }
                $this->redirect('/clients');
            }
        }

        $this->_view();
    }

    public function deleteAction ()
    {
        $this->language->load('Clients.messages');

        $id = $this->filterInt($this->_params[0]);
        $client = ClientModel::getByID($id);

        if($client == false) {
            $this->redirect('/clients');
        }

        if($client->delete()) {
            $this->messenger->add('Clients', $this->language->get('message_delete_success'));
        }else {
            $this->messenger->add('Clients', $this->language->get('message_delete_failed'), Messenger::APP_MESSAGE_ERROR);
        }
        $this->redirect('/clients');
    }

}