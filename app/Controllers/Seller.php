<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\StockModel;
use CodeIgniter\Controller;

class Seller extends BaseController
{
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $session = session();
        helper('url');
    }
    public function sellerDashboard()
    {
        $builder = $this->db->table("stock as stk");
        $builder->select('stk.id as stock_id, stk.product_id as prod_id, stk.product_code as prod_code, stk.quantity as qty, prd.price as prod_price, prd.gst as gst, prd.name as prod_name');
        $builder->join('product as prd', 'prd.id = stk.product_id', "left");
        $fetch = $builder->get()->getResult();
        $data['product'] = $fetch;
        echo view('sellerDashboard', $data);
    }
    public function addStocks()
    {
        if (empty($_GET['id'])) {
            $ProductModel = new ProductModel();
            $data = array();
            $fetch = $ProductModel->where('status', 1)->findAll();
            // echo"<pre>";print_r($fetch);die;
            $data['products'] = $fetch;
            echo view('addStocks', $data);
        } else {
            // echo $_GET['id'];die;
            $ProductModel = new ProductModel();
            $data = array();
            $fetch = $ProductModel->where('status', 1)->findAll();
            // print_r($fetch);die;
            $data['products'] = $fetch;
            // $builder = $this->db->table("stock as stk");
            // $builder->select('stk.id as stock_id, stk.product_id as prod_id, stk.product_code as prod_code, stk.quantity as qty, prd.price as prod_price, prd.gst as gst, prd.name as prod_name');
            // $builder->join('product as prd', 'prd.id = stk.product_id', "left");
            // $builder->where("stk.id='" . $_GET['id'] . "'");
            // $fetch = $builder->get()->getResult();
            // $data['product'] = $fetch;
            echo view('addStocks', $data);
        }
    }
    public function addProduct()
    {
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
    public function addStock()
    {
        $user_details = session('user_details');
        $session = session();

        $ProductModel = new ProductModel();
        $StockModel = new StockModel();
        $fetch1 = $ProductModel->where('status', 1)->find($_POST['pname']);
        // echo"<pre>";print_r($fetch1);die;
        $data = array();
        $data['product_id'] = $this->request->getVar('pname');
        $data['product_code'] = $fetch1['code'];
        $data['manufacturer_id'] = $fetch1['manufacturer_id'];
        $data['status'] = 1;
        // echo $_POST['pname'];die;    
        $fetch2 = $StockModel->where('product_id', $_POST['pname'])->first();
        
        $qty = array();
        $qty['quantity'] = $fetch1['quantity'] - $this->request->getVar('quantity');

        if (empty($fetch2)) {
            $data['quantity'] = $this->request->getVar('quantity');
            $save = $StockModel->insert($data);
            if ($save) {
                $ProductModel->update($fetch1['id'], $qty);
                $session->setFlashdata('valid_message', 'Stock Added Successfully!');
                return redirect()->redirect("sellerDashboard");
                die;
            } else {
                $session->setFlashdata('invalid_error', 'Stock Not Added!');
                return redirect()->redirect("sellerDashboard");
                die;
            }
        } else {
            $id = $fetch2['id'];
            $data['quantity'] = $fetch2['quantity'] + $this->request->getVar('quantity');
            $data['updated'] = date('Y-m-d H:i:s');
            $update = $StockModel->update($id, $data);
            if ($update) {
                $ProductModel->update($fetch1['id'], $qty);
                $session->setFlashdata('valid_message', 'Stock Update Successfully!');
                return redirect()->redirect("sellerDashboard");
                die;
            } else {
                $session->setFlashdata('invalid_error', 'Stock Not Added!');
                return redirect()->redirect("sellerDashboard");
                die;
            }
        }
    }
    public function deleteStock($id = null)
    {
        $session = session();
        $StockModel = new StockModel();
        $StockModel->delete($id);
        $session->setFlashdata('valid_message', 'Stock Deleted Successfully!');  
        return redirect()->redirect("sellerDashboard");              
        die;
    }

    public function get_quantity()
    {
        if (isset($_POST)) {
            $ProductModel = new ProductModel();
            $fetch = $ProductModel->where('status', 1)->find($_POST['id']);
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
