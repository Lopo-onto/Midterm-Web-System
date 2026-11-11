<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    public function index()
    {
        $usersModel = new UsersModel();
        $users = $usersModel
            ->select('id, username, full_name, avatar, created_at')
            ->findAll();
        return view('users/user', ['users' => $users]);
    }

    public function new()
    {
        return view("users/new");
    }

    public function create()
    {
        $rules = [
            'username'  => 'required|is_unique[users.username]',
            'full_name' => 'required|max_length[150]',
            'password' => 'required|min_length[8]|max_length[255]',
        ];

        if ($this->hasImageUpload('avatar')) {
            $rules['avatar'] = 'uploaded[avatar]|max_size[avatar,2048]|is_image[avatar]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $usersModel = new UsersModel();

        $avatar = $this->request->getFile('avatar');

        $avatarName = $this->hasImageUpload('avatar') ? $this->saveDisplayImage($avatar, 'users') : null;

        $usersModel->insert([
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
            'avatar' => $avatarName
        ]);

        return redirect()->to('/users')->with('success', 'Staff account created successfully.');
    }

    public function edit($id)
    {
        $usersModel = new UsersModel();

        $users = $usersModel->find($id);

        if (!$users) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Staff member not found');
        }

        return view('users/edit', ['users' => $users]);
    }

    public function update($id)
    {
        $usersModel = new UsersModel();
        $user = $usersModel->find($id);

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Staff member not found');
        }

        $rules = [
            'username'  => "required|is_unique[users.username,id,{$id}]",
            'full_name' => 'required|max_length[150]',
            'password' => 'permit_empty|min_length[8]|max_length[255]',
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
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
        ];

        $password = $this->request->getPost('password');
        if ($password !== null && $password !== '') {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($this->hasImageUpload('avatar')) {
            $data['avatar'] = $this->saveDisplayImage($avatar, 'users');
        }

        if ($usersModel->update($id, $data)) {
            if (isset($data['avatar'])) {
                $this->deleteDisplayImage($user['avatar'] ?? null, 'users');
            }
        } elseif (isset($data['avatar'])) {
            $this->deleteDisplayImage($data['avatar'], 'users');
        }

        return redirect()->to('/users')->with('success', 'Staff account updated successfully.');
    }

    public function delete($id)
    {
        if ((int) $id === (int) session()->get('user_id')) {
            return redirect()->to('/users')->with('error', 'You cannot delete the staff account you are currently using.');
        }

        $usersModel = new UsersModel();
        $user = $usersModel->find($id);

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Staff member not found');
        }

        if ((new \App\Models\SalesModel())->where('sold_by', $id)->countAllResults() > 0) {
            return redirect()->to('/users')->with('error', 'This staff member has sales history and cannot be deleted.');
        }

        $usersModel->delete($id);
        $this->deleteDisplayImage($user['avatar'] ?? null, 'users');

        return redirect()->to('/users')->with('success', 'Staff member deleted successfully.');
    }
}
