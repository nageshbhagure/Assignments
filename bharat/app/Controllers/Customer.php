<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\StockModel;

use CodeIgniter\Controller;

class Customer extends BaseController
{
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $session = session();
        helper('url');
    }
    public function customerDashboard()
    {
        $StockModel = new StockModel();
        $path = FCPATH . 'uploads\product_img';

        $builder = $this->db->table("stock as stk");
        $builder->select('stk.id as stock_id, prd.id as prod_id, stk.product_code as prod_code, stk.quantity as qty, prd.price as prod_price, prd.gst as gst, prd.name as prod_name, prd.file as filename');
        $builder->join('product as prd', 'prd.id = stk.product_id', "left");
        // $builder->where("stk.id='".$_GET['id']."'");
        $fetch = $builder->get()->getResult();
        $data['product'] = $fetch;
        // echo"<pre>";print_r($data);die;
        echo view('customerDashboard', $data);
    }
    public function buyProduct()
    {
        if (empty($_GET['id'])) {
            echo view('buyProduct');
        } else {
            $ProductModel = new ProductModel();
            $data = array();
            $fetch = $ProductModel->where('status', 1)->find($_GET['id']);

            $data['product_info'] = $fetch;
            echo view('buyProduct', $data);
        }
    }
    public function customerCart()
    {
        echo"<pre>";print_r($_SESSION['shopping_cart']);die;
    }
    public function customerBag()
    {
        // $session = session('user_details');
        $session = session();
        $code = $_POST['prod_id'];
        $quantity = $_POST['qty'];
        $ProductModel = new ProductModel();
        $fetch = $ProductModel->where('status', 1)->find($code);
        $name = $fetch['name'];
        $code = $fetch['code'];
        $price = $fetch['price'];
        $image = $fetch['file'];
        $cartArray = array(
            $code => array(
                'name' => $name,
                'code' => $code,
                'price' => $price,
                'quantity' => $quantity,
                'image' => $image
            )
        );
        if (empty($_SESSION["shopping_cart"])) {
            $_SESSION["shopping_cart"] = $cartArray;
            $session->setFlashdata('valid_message', 'Product is added to your cart!!');
            return redirect()->redirect("customerDashboard");
        } else {
            $array_keys = array_keys($_SESSION["shopping_cart"]);
            if (in_array($code, $array_keys)) {
                $session->setFlashdata('invalid_error', 'Product is already added to your cart!!');
                return redirect()->redirect("customerDashboard");
            } else {
                $_SESSION["shopping_cart"] = array_merge(
                    $_SESSION["shopping_cart"],
                    $cartArray
                );
                $session->setFlashdata('valid_message', 'Product is added to your cart!!');
                return redirect()->redirect("customerDashboard");
            }
        }
    }
    public function buyItem()
    {
        $user_details = session('user_details');
        $session = session();
        // echo"<pre>";print_r($user_details);die;
        $ProductModel = new ProductModel();
        $data = array();
        $data['name'] = $this->request->getVar('pname');
        $data['code'] = $this->request->getVar('pcode');
        $data['price'] = $this->request->getVar('price');
        $data['gst'] = $this->request->getVar('gst');
        $data['manufacturer_id'] = $user_details['id'];
        $data['status'] = 1;
        $id = $this->request->getVar('id');
        if ($id == "") {
            $save = $ProductModel->insert($data);
            if ($save) {
                $session->setFlashdata('valid_message', 'Product Added Successfully!');
                return redirect()->redirect("manufacturerDashboard");
                die;
            } else {
                $session->setFlashdata('invalid_error', 'Product Not Added!');
                return redirect()->redirect("addProduct");
                die;
            }
        } else {
            $update = $ProductModel->update($id, $data);
            if ($update) {
                $session->setFlashdata('valid_message', 'Product Update Successfully!');
                return redirect()->redirect("addProduct?id=$id");
                die;
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
        return redirect("customerDashboard");
        // return redirect()->redirect(site_url("manufacturerDashboard"));
        // return $this->response->redirect(site_url('/users-list'));
        die;
    }
    public function get_quantity_stocks()
    {
        if (isset($_POST)) {
            $StockModel = new StockModel();
            // $fetch = $StockModel->where('status', 1)->find($_POST['id']);
            $fetch = $StockModel->where('product_id', $_POST['id'])->where('status', 1)->first();
            // print_r($fetch);die;
            if ($fetch) {
                echo json_encode(['quantity' => $fetch['quantity'], 'status' => 1]);
                die;
            } else {
                echo json_encode(['status' => 0]);
                die;
            }
        } else {
            echo json_encode(['status' => -1]);
            die;
        }
    }
}
