<?php
namespace PHPMVC\CONTROLLERS;
use PHPMVC\LIB\Helper;
use PHPMVC\LIB\InputFilter;
use PHPMVC\LIB\Messenger;
use PHPMVC\MODELS\permissionModel;
use PHPMVC\MODELS\UserGroupPrivilegeModel;

class PermissionsController extends AbstractController
{
    use InputFilter;
    use Helper;

    public function defaultAction()
    {
        $this->language->load('template.common');
        $this->language->load('permissions.default');
        $this->_data['privileges'] = permissionModel::getAll();
        $this->_view();
    }

    public function addAction()
    {
        $this->language->load('template.common');
        $this->language->load('permissions.labels');
        $this->language->load('permissions.add');
        $this->language->load('permissions.messages');

        if(isset($_POST['submit'])) {
            $privilege = new permissionModel();
            $privilege->PrivilegeTitle = $this->filterString($_POST['PrivilegeTitle']);
            $privilege->Privilege = $this->filterString($_POST['Privilege']);
            if($privilege->save())
            {
                $this->messenger->add('permission', $this->language->get('message_create_success'));
            }else {
                $this->messenger->add('permission', $this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
            }
            $this->redirect('/Permissions');
        }

        $this->_view();
    }

    public function editAction()
    {

        $id = $this->filterInt($this->_params[0]);
        $privilege = permissionModel::getByID($id);

        if($privilege === false) {
            $this->redirect('/Permissions');
        }

        $this->_data['privilege'] = $privilege;

        $this->language->load('template.common');
        $this->language->load('permissions.labels');
        $this->language->load('permissions.edit');
        $this->language->load('permissions.messages');

        if(isset($_POST['submit'])) {
            $privilege->PrivilegeTitle = $this->filterString($_POST['PrivilegeTitle']);
            $privilege->Privilege = $this->filterString($_POST['Privilege']);
            if($privilege->save())
            {
                $this->messenger->add('permission', $this->language->get('message_create_success'));
            }else {
                $this->messenger->add('permission', $this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
            }
            $this->redirect('/Permissions');
        }

        $this->_view();
    }

    public function deleteAction()
    {

        $id = $this->filterInt($this->_params[0]);
        $privilege = permissionModel::getByID($id);

        if($privilege === false) {
            $this->redirect('/Permissions');
        }

        $groupPrivileges = UserGroupPrivilegeModel::getBy(['PrivilegeId' => $privilege->PrivilegeId]);
        if(false !== $groupPrivileges) {
            foreach ($groupPrivileges as $groupPrivilege) {
                $groupPrivilege->delete();
            }
        }
        $this->language->load('permissions.messages');

        if($privilege->delete())
        {
            $this->messenger->add('permission', $this->language->get('message_delete_success'));
        }else {
            $this->messenger->add('permission', $this->language->get('message_delete_failed'), Messenger::APP_MESSAGE_ERROR);
        }
        $this->redirect('/Permissions');
    }

}