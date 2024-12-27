<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Article.php';

class AdminController extends Controller
{
    public function index()
    {
        $userModel = new User();
        $articleModel = new Article();

        $users = $userModel->getAll();
        $articles = $articleModel->getAll();

        $this->renderView('admin/dashboard', [
            'users' => $users,
            'articles' => $articles,
        ]);
    }

    public function users()
    {
        $userModel = new User();
        $users = $userModel->getAll();
        $this->renderView('admin/users', ['users' => $users]);
    }

    public function editUser($id)
    {
        $userModel = new User();
        $user = $userModel->find($id);
        $this->renderView('admin/edit_user', ['user' => $user]);
    }

    public function updateUser($id)
    {
        $username = sanitizeInput($_POST['username']);
        $password = password_hash(sanitizeInput($_POST['password']), PASSWORD_BCRYPT);

        $userModel = new User();
        $userModel->update($id, [
            'username' => $username,
            'password' => $password,
        ]);

        $this->redirect('/admin/users');
    }

    public function deleteUser($id)
    {
        $userModel = new User();
        $userModel->delete($id);
        $this->redirect('/admin/users');
    }
}
?>