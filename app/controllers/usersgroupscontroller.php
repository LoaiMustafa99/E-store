<?php
namespace PHPMVC\CONTROLLERS;
use PHPMVC\LIB\Helper;
use PHPMVC\LIB\InputFilter;
use PHPMVC\LIB\Messenger;
use PHPMVC\MODELS\permissionModel;
use PHPMVC\MODELS\UserGroupModel;
use PHPMVC\MODELS\UserGroupPrivilegeModel;

class UsersGroupsController extends AbstractController
{

    use InputFilter;
    use Helper;

    public function defaultAction()
    {
        $this->language->load('template.common');
        $this->language->load('usersgroups.default');
        $this->_data['groups'] = UserGroupModel::getAll();
        $this->_view();
    }

    public function addAction()
    {
        $this->language->load('template.common');
        $this->language->load('usersgroups.add');
        $this->language->load('usersgroups.labels');
        $this->_data['privileges'] = permissionModel::getAll();
        if(isset($_POST['submit'])) {
            $group = new UserGroupModel();
            $group->GroupName = $this->filterString($_POST['GroupName']);
            if($group->save())
            {
                if(isset($_POST['privileges']) && is_array($_POST['privileges'])) {
                    foreach ($_POST['privileges'] as $privilegeId) {
                        $groupPrivilege = new UserGroupPrivilegeModel();
                        $groupPrivilege->GroupId = $group->GroupId;
                        $groupPrivilege->privilegeId = $privilegeId;
                        $groupPrivilege->save();
                    }
                }
                $this->messenger->add('تم حفظ المجموعة بنجاح');
                $this->redirect('/usersgroups');
            }
        }

        $this->_view();
    }

    public function editAction()
    {
        $id = $this->filterInt($this->_params[0]);
        $group = UserGroupModel::getByID($id);

        if($group === false) {
            $this->redirect('/usersgroups');
        }

        $this->language->load('template.common');
        $this->language->load('usersgroups.edit');
        $this->language->load('usersgroups.labels');

        $this->_data['group'] = $group;
        $this->_data['privileges'] = permissionModel::getAll();
        $extractedPrivilegesIds = $this->_data['groupPrivileges'] = UserGroupPrivilegeModel::getGroupPrivileges($group);

        if(isset($_POST['submit'])) {
            $group->GroupName = $this->filterString($_POST['GroupName']);
            if($group->save())
            {
                if(isset($_POST['privileges']) && is_array($_POST['privileges'])) {

                    $privilegesIdsToBeDeleted = array_diff($extractedPrivilegesIds, $_POST['privileges']);
                    $privilegesIdsToBeAdded = array_diff($_POST['privileges'], $extractedPrivilegesIds);

                    // Delete the unwanted privileges
                    if(!empty($privilegesIdsToBeDeleted)) {
                        foreach ($privilegesIdsToBeDeleted as $deletedPrivilege) {
                            $unwantedPrivilege = UserGroupPrivilegeModel::getBy(['PrivilegeId' => $deletedPrivilege, 'GroupId' => $group->GroupId]);
                            $unwantedPrivilege->current()->delete();
                        }
                    }

                    // Add the new privileges
                    if(!empty($privilegesIdsToBeAdded)) {
                        foreach ($privilegesIdsToBeAdded as $privilegeId) {
                            $groupPrivilege = new UserGroupPrivilegeModel();
                            $groupPrivilege->GroupId = $group->GroupId;
                            $groupPrivilege->privilegeId = $privilegeId;
                            $groupPrivilege->save();
                        }
                    }
                }
                $this->messenger->add('تم حفظ المجموعة بنجاح');
                $this->redirect('/usersgroups');
            }
        }

        $this->_view();
    }

    public function deleteAction()
    {

        $id = $this->filterInt($this->_params[0]);
        $group = UserGroupModel::getByID($id);

        if($group === false) {
            $this->redirect('/usersgroups');
        }

        $groupPrivileges = UserGroupPrivilegeModel::getBy(['GroupId' => $group->GroupId]);

        if(false !== $groupPrivileges) {
            foreach ($groupPrivileges as $groupPrivilege) {
                $groupPrivilege->delete();
            }
        }

        if($group->delete()) {
            $this->messenger->add('تم حذف المجموعة بنجاح', Messenger::APP_MESSAGE_ERROR);
            $this->redirect('/usersgroups');
        }
    }

}