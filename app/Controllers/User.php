<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class User extends BaseController
{
    public function __construct()
    {
        $session = session();
        helper('url');
    }

    public function login()
    {
        echo view('login');
    }

    public function action()
    {
        // echo view('login');
        $session = session();
        $username = $this->request->getVar('username');
        $password = md5(md5(md5(md5($this->request->getVar('password')))));
        $UserModel = new UserModel();
        $fetch = $UserModel->where('username', $username)->where('password', $password)->first();
        if ($fetch != null) {
            if ($fetch['status'] == 0) {
                $session->setFlashdata('invalid_error', 'Your account is Deactivated, Please Contact Administrator!');
                return redirect()->redirect("login");
            } else {
                $session->set('is_login', 1);
                $session->set('user_details', $fetch);
                if ($fetch['role'] == 1) {
                    return redirect()->redirect("manufacturerDashboard");
                    die;
                } else if ($fetch['role'] == 2) {
                    return redirect()->redirect("sellerDashboard");
                    die;
                } else if ($fetch['role'] == 3) {
                    return redirect()->redirect("customerDashboard");
                    die;
                }
            }
        }else{
            $session->setFlashdata('invalid_error', 'Wrong Credentials, try again..');
            return redirect()->redirect("login");
        }
    }

    public function register()
    {
        echo view('register');
    }

    public function add()
    {
        $session = session();
        $UserModel = new UserModel();
        $data = array();
        $data['username'] = $this->request->getVar('username');
        $data['role'] = $this->request->getVar('role');
        $password = $this->request->getVar('password');
        $data['password'] = md5(md5(md5(md5($password))));
        $data['status'] = 1;
        $save = $UserModel->insert($data);
        if ($save) {
            $session->setFlashdata('valid_message', 'User Created Successfully!');
            return redirect()->redirect("register");
            die;
        } else {
            $session->setFlashdata('invalid_error', 'User Not Created!');
            return redirect()->redirect("register");
            die;
        }
    }

    function logout() {
		$session = session();		
        $session->set(['user_details' => '']);
        $session->destroy();
        return redirect()->redirect("login");
        die;
    }
}
