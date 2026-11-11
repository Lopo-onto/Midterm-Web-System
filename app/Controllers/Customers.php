<?php

namespace App\Controllers;

use App\Models\CustomersModel;

class Customers extends BaseController
{
    public function index()
    {
        // $customers = [
        // ];

        $customersModel = new CustomersModel();


        $customers = $customersModel->findAll();

        return view('customers/index', 
                    ['customers' => $customers]);

    }

    public function new()
    {
        return view("customers/new");
    }

    public function create()
    {
        $rules = [
            'full_name' => 'required|max_length[150]',
            'email' => 'required|valid_email|max_length[254]',
            'phone' => 'permit_empty|max_length[40]',
        ];

        if ($this->hasImageUpload('avatar')) {
            $rules['avatar'] = 'uploaded[avatar]|max_size[avatar,2048]|is_image[avatar]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $customersModel = new CustomersModel();

        $avatar = $this->request->getFile('avatar');

        $avatarName = $this->hasImageUpload('avatar') ? $this->saveDisplayImage($avatar, 'customers') : null;

        $customersModel->insert([
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'created_at' => date('Y-m-d H:i:s'),
            'avatar' => $avatarName
        ]);

        return redirect()->to('/customers')->with('success', 'Customer added successfully.');
    }

    public function edit($id)
    {
        $customersModel = new CustomersModel();

        $customers = $customersModel->find($id);

        if (!$customers) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Customer not found');
        }

        return view('customers/edit', 
                    ['customers' => $customers]);
    }

    public function update($id)
    {
        $customersModel = new CustomersModel();
        $customer = $customersModel->find($id);

        if (!$customer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Customer not found');
        }

        $rules = [
            'full_name' => 'required|max_length[150]',
            'email' => 'required|valid_email|max_length[254]',
            'phone' => 'permit_empty|max_length[40]',
        ];

        if ($this->hasImageUpload('avatar')) {
            $rules['avatar'] = 'uploaded[avatar]|max_size[avatar,2048]|is_image[avatar]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $avatar = $this->request->getFile('avatar');
        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
        ];

        if ($this->hasImageUpload('avatar')) {
            $data['avatar'] = $this->saveDisplayImage($avatar, 'customers');
        }

        if ($customersModel->update($id, $data)) {
            if (isset($data['avatar'])) {
                $this->deleteDisplayImage($customer['avatar'] ?? null, 'customers');
            }
        } elseif (isset($data['avatar'])) {
            $this->deleteDisplayImage($data['avatar'], 'customers');
        }

        return redirect()->to('/customers')->with('success', 'Customer updated successfully.');
    }

    public function delete($id)
    {
        $customersModel = new CustomersModel();
        $customer = $customersModel->find($id);

        if (!$customer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Customer not found');
        }

        (new \App\Models\SalesModel())
            ->where('customer_id', $id)
            ->set('customer_id', null)
            ->update();

        $customersModel->delete($id);
        $this->deleteDisplayImage($customer['avatar'] ?? null, 'customers');

        return redirect()->to('/customers')->with('success', 'Customer deleted. Sale history was preserved.');
    }
}
