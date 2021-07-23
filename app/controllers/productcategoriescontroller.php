<?php
namespace PHPMVC\CONTROLLERS;
use PHPMVC\LIB\FileUpload;
use PHPMVC\LIB\Helper;
use PHPMVC\LIB\InputFilter;
use PHPMVC\LIB\Messenger;
use PHPMVC\MODELS\ProductCategoryModel;


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
        $this->language->load('validation.errors');


        if(isset($_POST['submit'])) {
            if($this->validate->product_category_Validation($_POST)) {
                $category = new ProductCategoryModel();
                $category->Name = $this->filterString($_POST['Name']);

                $uploadError = false;

                if (!empty($_FILES['image']['name'])) {
                    $uploader = new FileUpload($_FILES['image']);
                    try {
                        $uploader->upload();
                        $category->Image = $uploader->getFileName();
                    } catch (\Exception $e) {
                        $this->messenger->add('UploadImage', $e->getMessage(), Messenger::APP_MESSAGE_ERROR);
                        $uploadError = true;
                    }
                }
                if ($uploadError === false && $category->save()) {
                    $this->messenger->add('ProductCategories', $this->language->get('message_create_success'));
                } else {
                    $this->messenger->add('ProductCategories', $this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
                }
                $this->redirect('/productcategories');
            }
        }

        $this->_view();
    }

    public function editAction()
    {
        $id = $this->filterInt($this->_params[0]);
        $category = ProductCategoryModel::getByID($id);

        if($category === false) {
            $this->redirect('/productcategories');
        }

        $this->language->load('template.common');
        $this->language->load('productcategories.edit');
        $this->language->load('productcategories.labels');
        $this->language->load('productcategories.messages');
        $this->language->load('validation.errors');

        $this->_data['category'] = $category;
        $uploadError = false;

        if(isset($_POST['submit'])) {
            if($this->validate->product_category_Validation($_POST)) {
                $category->Name = $this->filterString($_POST['Name']);
                if (!empty($_FILES['image']['name'])) {
                    // Remove the old image
                    if ($category->Image !== '' && file_exists(IMAGE_UPLOAD_STORAGE . DS . $category->Image) && is_writable(IMAGE_UPLOAD_STORAGE)) {
                        unlink(IMAGE_UPLOAD_STORAGE . DS . $category->Image);
                    }
                    // Create a new image
                    $uploader = new FileUpload($_FILES['image']);
                    try {
                        $uploader->upload();
                        $category->Image = $uploader->getFileName();
                    } catch (\Exception $e) {
                        $this->messenger->add('UploadImage', $e->getMessage(), Messenger::APP_MESSAGE_ERROR);
                        $uploadError = true;
                    }
                }
                if ($uploadError === false && $category->save()) {
                    $this->messenger->add('ProductCategories', $this->language->get('message_create_success'));
                    $this->redirect('/productcategories');
                } else {
                    $this->messenger->add('ProductCategories', $this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
                }
            }
        }

        $this->_view();
    }

    public function deleteAction()
    {

        $this->language->load('productcategories.messages');

        $id = $this->filterInt($this->_params[0]);
        $category = ProductCategoryModel::getByID($id);

        if($category === false) {
            $this->redirect('/productcategories');
        }

        if($category->delete()) {
            if($category->Image !== '' && file_exists(IMAGE_UPLOAD_STORAGE.DS.$category->Image)) {
                unlink(IMAGE_UPLOAD_STORAGE.DS.$category->Image);
            }
            $this->messenger->add('ProductCategories', $this->language->get('message_delete_success'));
        }else {
            $this->messenger->add('ProductCategories', $this->language->get('message_delete_failed'), Messenger::APP_MESSAGE_ERROR);
        }
        $this->redirect('/productcategories');
    }

}