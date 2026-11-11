<?php

namespace App\Controllers;

use App\Models\SalesModel;
use App\Models\ProductsModel;
use App\Models\CustomersModel;

class Sales extends BaseController
{
    protected $salesModel;
    protected $productModel;
    protected $customerModel;

    public function __construct()
    {
        $this->salesModel = new SalesModel();
        $this->productModel = new ProductsModel();
        $this->customerModel = new CustomersModel();
    }

    public function index()
    {
        $sales = $this->salesModel
            ->select('
                sales.*,
                products.name AS product_name,
                customers.full_name AS customer_name,
                users.full_name AS seller_name
            ')
            ->join('products', 'products.id = sales.product_id', 'left')
            ->join('customers', 'customers.id = sales.customer_id', 'left')
            ->join('users', 'users.id = sales.sold_by', 'left')
            ->orderBy('sales.created_at', 'DESC')
            ->findAll();

        $data['sales'] = $sales;

        return view('sales/index', $data);
    }

    public function create()
    {
        $data['products'] = $this->productModel->findAll();
        $data['customers'] = $this->customerModel->findAll();

        return view('sales/create', $data);
    }

    public function store()
    {
        $productId = $this->request->getPost('product_id');
        $customerId = $this->request->getPost('customer_id');
        $quantity = (int) $this->request->getPost('quantity');
        $rules = [
            'product_id' => 'required|is_natural_no_zero',
            'customer_id' => 'permit_empty|is_natural_no_zero',
            'quantity' => 'required|integer|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $product = $this->productModel->find($productId);

        if (!$product) {
            return redirect()->back()->withInput()->with('error', 'The selected product is no longer available.');
        }

        if ($customerId !== null && $customerId !== '' && !$this->customerModel->find($customerId)) {
            return redirect()->back()->withInput()->with('error', 'The selected customer could not be found.');
        }

        $db = db_connect();
        $db->transBegin();

        $db->table('products')
            ->set('stock_quantity', 'stock_quantity - ' . $quantity, false)
            ->where('id', $productId)
            ->where('stock_quantity >=', $quantity)
            ->update();

        if ($db->affectedRows() !== 1) {
            $db->transRollback();
            $available = $this->productModel->find($productId)['stock_quantity'] ?? 0;

            return redirect()->back()->withInput()->with(
                'error',
                "Only {$available} unit(s) are in stock. Reduce the quantity and try again."
            );
        }

        $totalPrice = number_format((float) $product['price'] * $quantity, 2, '.', '');

        $inserted = $this->salesModel->insert([
            'product_id' => $productId,
            'customer_id' => $customerId ?: null,
            'sold_by' => session()->get('user_id'),
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if (!$inserted || !$db->transStatus()) {
            $db->transRollback();

            return redirect()->back()->withInput()->with('error', 'The sale could not be recorded. Stock has not been changed.');
        }

        $db->transCommit();

        return redirect()->to('/sales')
                         ->with('success', 'Sale recorded successfully.');
    }
}