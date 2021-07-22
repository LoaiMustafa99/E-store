<?php
namespace PHPMVC\CONTROLLERS;
use PHPMVC\LIB\FileUpload;
use PHPMVC\LIB\Helper;
use PHPMVC\LIB\InputFilter;
use PHPMVC\LIB\Messenger;
use PHPMVC\MODELS\permissionModel;
use PHPMVC\MODELS\ProductCategoryModel;
use PHPMVC\MODELS\UserGroupModel;
use PHPMVC\MODELS\UserGroupPrivilegeModel;

class ProductCategoriesController extends AbstractController
{

    use InputFilter;
    use Helper;

    public function defaultAction()
    {
        $this->language->load('template.common');
        $this->language->load('productcategories.default');

        $this->_data['categories'] = ProductCategoryModel::getAll();

        $this->_view();
    }

    public function addAction()
    {
        $this->language->load('template.common');
        $this->language->load('productcategories.add');
        $this->language->load('productcategories.labels');
        $this->language->load('productcategories.messages');


        if(isset($_POST['submit'])) {
            $category = new ProductCategoryModel();
            $category->Name = $this->filterString($_POST['Name']);

            $uploadError = false;

            $category->Image = (new FileUpload($_FILES['image']))->upload()->getFileName();

            if(!empty($_FILES['image']['name'])) {
                $uploader = new FileUpload($_FILES['image']);
                try {
                    $uploader->upload();
                    $category->Image = $uploader->getFileName();
                } catch (\Exception $e) {
                    $this->messenger->add($e->getMessage(), Messenger::APP_MESSAGE_ERROR);
                    $uploadError = true;
                }
            }
            if($uploadError === false && $category->save()) {
                $this->messenger->add('ProductCategories', $this->language->get('message_create_success'));
            } else {
                $this->messenger->add('ProductCategories', $this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
            }
            $this->redirect('/productcategories');
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
                $this->messenger->add('UserGroup','تم حفظ المجموعة بنجاح');
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
            $this->messenger->add('UserGroup', 'تم حذف المجموعة بنجاح', Messenger::APP_MESSAGE_ERROR);
            $this->redirect('/usersgroups');
        }
    }

}