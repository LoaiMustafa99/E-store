<?php
namespace PHPMVC\CONTROLLERS;
use PHPMVC\LIB\FileUpload;
use PHPMVC\LIB\Helper;
use PHPMVC\LIB\InputFilter;
use PHPMVC\LIB\Messenger;
use PHPMVC\MODELS\ProductCategoryModel;
use PHPMVC\MODELS\ProductListModel;


class ProductListController extends AbstractController
{

    use InputFilter;
    use Helper;

    public function defaultAction()
    {
        $this->language->load('template.common');
        $this->language->load('productlist.default');

        $this->_data['products'] = ProductListModel::getAll();

        $this->_view();
    }

    public function addAction()
    {
        $this->language->load('template.common');
        $this->language->load('productlist.add');
        $this->language->load('productlist.labels');
        $this->language->load('productlist.messages');
        $this->language->load('productlist.units');
        $this->language->load('validation.errors');

        $this->_data['categories'] = ProductCategoryModel::getAll();

        $uploadError = false;

        if(isset($_POST['submit'])) {
            if($this->validate->product_Validation($_POST)) {
                $product = new ProductListModel();
                $product->Name = $this->filterString($_POST['Name']);
                $product->CategoryId = $this->filterInt($_POST['CategoryId']);
                $product->Quantity = $this->filterInt($_POST['Quantity']);
                $product->BuyPrice = $this->filterFloat($_POST['BuyPrice']);
                $product->SellPrice = $this->filterFloat($_POST['SellPrice']);
                $product->Unit = $this->filterInt($_POST['Unit']);


                if (!empty($_FILES['image']['name'])) {
                    $uploader = new FileUpload($_FILES['image']);
                    try {
                        $uploader->upload();
                        $product->Image = $uploader->getFileName();
                    } catch (\Exception $e) {
                        $this->messenger->add('UploadImage', $e->getMessage(), Messenger::APP_MESSAGE_ERROR);
                        $uploadError = true;
                    }
                }
                if ($uploadError === false && $product->save()) {
                    $this->messenger->add('ProductList', $this->language->get('message_create_success'));
                } else {
                    $this->messenger->add('ProductList', $this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
                }
                $this->redirect('/productlist');
            }
        }

        $this->_view();
    }

    public function editAction()
    {
        $id = $this->filterInt($this->_params[0]);
        $product = ProductListModel::getByID($id);

        if($product === false) {
            $this->redirect('/productlist');
        }

        $this->language->load('template.common');
        $this->language->load('productlist.add');
        $this->language->load('productlist.labels');
        $this->language->load('productlist.messages');
        $this->language->load('productlist.units');
        $this->language->load('validation.errors');

        $this->_data['categories'] = ProductCategoryModel::getAll();
        $this->_data['product'] = $product;

        $uploadError = false;

        if(isset($_POST['submit'])) {
            if($this->validate->product_Validation($_POST)) {

                $product->Name = $this->filterString($_POST['Name']);
                $product->CategoryId = $this->filterInt($_POST['CategoryId']);
                $product->Quantity = $this->filterInt($_POST['Quantity']);
                $product->BuyPrice = $this->filterFloat($_POST['BuyPrice']);
                $product->SellPrice = $this->filterFloat($_POST['SellPrice']);
                $product->Unit = $this->filterInt($_POST['Unit']);

                if (!empty($_FILES['image']['name'])) {
                    // Remove the old image
                    if ($product->Image !== '' && file_exists(IMAGE_UPLOAD_STORAGE . DS . $product->Image) && is_writable(IMAGE_UPLOAD_STORAGE)) {
                        unlink(IMAGE_UPLOAD_STORAGE . DS . $product->Image);
                    }
                    // Create a new image
                    $uploader = new FileUpload($_FILES['image']);
                    try {
                        $uploader->upload();
                        $product->Image = $uploader->getFileName();
                    } catch (\Exception $e) {
                        $this->messenger->add('UploadImage', $e->getMessage(), Messenger::APP_MESSAGE_ERROR);
                        $uploadError = true;
                    }
                }
                if ($uploadError === false && $product->save()) {
                    $this->messenger->add('ProductList', $this->language->get('message_create_success'));
                } else {
                    $this->messenger->add('ProductList', $this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
                }
                $this->redirect('/productlist');
            }
        }

        $this->_view();
    }

    public function deleteAction()
    {

        $this->language->load('productlist.messages');

        $id = $this->filterInt($this->_params[0]);
        $product = ProductListModel::getByID($id);

        if($product === false) {
            $this->redirect('/productlist');
        }

        if($product->delete()) {
            if($product->Image !== '' && file_exists(IMAGE_UPLOAD_STORAGE.DS.$product->Image) && is_writable(IMAGE_UPLOAD_STORAGE)) {
                unlink(IMAGE_UPLOAD_STORAGE.DS.$product->Image);
            }
            $this->messenger->add('ProductList', $this->language->get('message_delete_success'));
        }else {
            $this->messenger->add('ProductList', $this->language->get('message_delete_failed'), Messenger::APP_MESSAGE_ERROR);
        }
        $this->redirect('/productlist');
    }

}