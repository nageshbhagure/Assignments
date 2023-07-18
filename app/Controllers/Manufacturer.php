<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Controller;

class Manufacturer extends BaseController
{
    public function __construct()
    {
        $session = session();
        helper('url');
    }
    public function manufacturerDashboard()
    {
        $ProductModel = new ProductModel();
        $fetch = $ProductModel->where('status', 1)->findAll();
        $data['product'] = $fetch;
        // print_r($data);die;
        echo view('manufacturerDashboard', $data);
    }
    public function addProduct()
    {
        // echo FCPATH.'uploads';die;
        if (empty($_GET['id'])) {
            echo view('addProduct');
        } else {
            $ProductModel = new ProductModel();
            $data = array();
            $fetch = $ProductModel->where('status', 1)->find($_GET['id']);

            $data['product_info'] = $fetch;
            echo view('addProduct', $data);
        }
    }
    public function addItem()
    {
        $user_details = session('user_details');
        $session = session();
        $path = FCPATH . 'uploads\product_img';
        // echo"<pre>";print_r($user_details);die;
        $ProductModel = new ProductModel();
        $data = array();
        $data['name'] = $this->request->getVar('pname');
        $data['code'] = $this->request->getVar('pcode');
        $data['price'] = $this->request->getVar('price');
        $data['gst'] = $this->request->getVar('gst');
        $data['quantity'] = $this->request->getVar('quantity');
        $data['manufacturer_id'] = $user_details['id'];
        $data['status'] = 1;
        $file = $this->request->getFile('userfile');
        $product_name = $this->request->getVar('pname');
        $product_code = $this->request->getVar('pcode');
        $filename = $product_name . '_' . $product_code . '.jpg';
        $data['file'] = $filename;

        $id = $this->request->getVar('id');

        if ($id == "") {
            $save = $ProductModel->insert($data);
            if ($save) {
                $newName = $filename;
                if (!$file->move($path, $newName)) {
                    $session->setFlashdata('invalid_error', 'Product Image Not Added!');
                    return redirect()->redirect("addProduct");
                    die;
                } else {
                    $session->setFlashdata('valid_message', 'Product Added Successfully!');
                    return redirect()->redirect("manufacturerDashboard");
                    die;
                }
            } else {
                $session->setFlashdata('invalid_error', 'Product Not Added!');
                return redirect()->redirect("addProduct");
                die;
            }
        } else {
            $data['updated'] = date('Y-m-d H:i:s');
            $update = $ProductModel->update($id, $data);
            if ($update) {
                $newName = $filename;
                if (!$file->move($path, $newName)) {
                    $session->setFlashdata('invalid_error', 'Product Image Not Added!');
                    return redirect()->redirect("addProduct");
                    die;
                } else {
                    $session->setFlashdata('valid_message', 'Product Added Successfully!');
                    return redirect()->redirect("manufacturerDashboard");
                    die;
                }
            } else {
                $session->setFlashdata('invalid_error', 'Product Not Added!');
                return redirect()->redirect("addProduct?id=$id");
                die;
            }
        }
    }

    public function deleteItem($id = null)
    {
        $ProductModel = new ProductModel();
        $ProductModel->delete($id);
        return redirect()->redirect("manufacturerDashboard");
        die;
    }
}
