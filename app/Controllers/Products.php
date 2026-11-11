<?php

namespace App\Controllers;

use App\Models\ProductsModel;

class Products extends BaseController
{
    protected $productsModel;

    public function __construct()
    {
        $this->productsModel = new ProductsModel();
    }

    public function index()
    {
        $data['products'] = $this->productsModel->findAll();

        return view('products/index', $data);
    }

    public function create()
    {
        return view('products/create');
    }

    public function store()
    {
        $rules = [
            'name' => 'required|max_length[150]',
            'price' => 'required|decimal|greater_than_equal_to[0]',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
        ];

        if ($this->hasImageUpload('image')) {
            $rules['image'] = 'uploaded[image]|max_size[image,2048]|is_image[image]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image');
        $imageName = $this->hasImageUpload('image') ? $this->saveDisplayImage($image, 'products') : null;

        $this->productsModel->insert([
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
            'image' => $imageName,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/products')
            ->with('success', 'Product added successfully.');
    }

    public function edit($id)
    {
        $data['product'] = $this->productsModel->find($id);

        if (!$data['product']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }

        return view('products/edit', $data);
    }

    public function update($id)
    {
        $product = $this->productsModel->find($id);

        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }

        $rules = [
            'name' => 'required|max_length[150]',
            'price' => 'required|decimal|greater_than_equal_to[0]',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
        ];

        if ($this->hasImageUpload('image')) {
            $rules['image'] = 'uploaded[image]|max_size[image,2048]|is_image[image]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity')
        ];

        $image = $this->request->getFile('image');

        if ($this->hasImageUpload('image')) {
            $imageName = $this->saveDisplayImage($image, 'products');
            $data['image'] = $imageName;
        }

        if ($this->productsModel->update($id, $data)) {
            if (isset($imageName)) {
                $this->deleteDisplayImage($product['image'], 'products');
            }
        } elseif (isset($imageName)) {
            $this->deleteDisplayImage($imageName, 'products');
        }

        return redirect()->to('/products')
            ->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        $product = $this->productsModel->find($id);

        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }

        if ((new \App\Models\SalesModel())->where('product_id', $id)->countAllResults() > 0) {
            return redirect()->to('/products')->with('error', 'This product has sales history and cannot be deleted.');
        }

        if ($this->productsModel->delete($id)) {
            $this->deleteDisplayImage($product['image'], 'products');
        }

        return redirect()->to('/products')
            ->with('success', 'Product deleted successfully.');
    }
}