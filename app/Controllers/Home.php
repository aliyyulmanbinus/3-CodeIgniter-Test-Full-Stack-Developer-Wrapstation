<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ProductModel;
use App\Models\TransactionModel;

class Home extends BaseController
{
    public function index()
    {
        $userModel        = new UserModel();
        $productModel     = new ProductModel();
        $transactionModel = new TransactionModel();

        $data = [
            'title'              => 'Beranda',
            'totalUsers'         => $userModel->countAll(),
            'totalProducts'      => $productModel->countAll(),
            'totalTransactions'  => $transactionModel->countAll(),
        ];

        return view('home', $data);
    }
}