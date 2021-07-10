<?php


namespace PHPMVC\CONTROLLERS;
use PHPMVC\LIB\Helper;
use PHPMVC\LIB\InputFilter;
use PHPMVC\MODELS\EmployeeModel;

class EmployeeController extends AbstractController
{
    use InputFilter;
    use Helper;

    public function defaultAction()
    {
        $this->_language->load('template.common');
        $this->_language->load('employee.default');
        $this->_data['employees'] = EmployeeModel::getAll();
        $this->_view();
    }

    public function addAction()
    {
        if(isset($_POST['submit']))
        {
            $emp = new EmployeeModel();
            $emp->name = $this->filterString($_POST['name']);
            $emp->age = $this->filterInt($_POST['age']);
            $emp->address = $this->filterString($_POST['address']);
            $emp->tax = $this->filterFloat($_POST['tax']);
            $emp->salary = $this->filterFloat($_POST['salary']);
            if ($emp->save() == true)
            {
                $_SESSION['message'] = "تم اضافة موظف جديد";
                $this->redirect('/employee');
            }
            var_dump($_POST);
        }
        $this->_language->load('template.common');
        $this->_view();
    }

    public function editAction()
    {
        $id = $this->filterInt($this->_params[0]);
        $emp = EmployeeModel::getByID($id);
        if($emp == false) {
            $this->redirect("/employee");
        }

        $this->_language->load('template.common');

        $this->_data['employees'] = $emp;
        if(isset($_POST['submit']))
        {
            $emp->name = $this->filterString($_POST['name']);
            $emp->age = $this->filterInt($_POST['age']);
            $emp->address = $this->filterString($_POST['address']);
            $emp->tax = $this->filterFloat($_POST['tax']);
            $emp->salary = $this->filterFloat($_POST['salary']);
            if ($emp->save() == true)
            {
                $_SESSION['message'] = "تم تعديل موظف جديد";
                $this->redirect('/employee');
            }
            var_dump($_POST);
        }
        $this->_view();
    }

    public function deleteAction()
    {
        $id = $this->filterInt($this->_params[0]);
        $emp = EmployeeModel::getByID($id);
        if($emp->delete() == true) {
            $_SESSION['message'] = "Employees deleted successfully";
            $this->redirect("/employee");
        }
    }
}