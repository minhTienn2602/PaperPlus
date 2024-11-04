<?php
class UserController extends BaseController
{
    private $userModel;
    public $data = [];

    public function __construct() {
        $this->userModel = $this->loadModel('UserModel');
    }
    //Hiển thị trang đăng nhập
    public function login() {
        $this->render('login', $this->data);
    }
    //Thực hiện hành action đăng nhập
    public function checkLogin() {
        header('Content-Type: application/json'); // Đảm bảo rằng phản hồi là JSON

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->getUserByEmail($email);

            if ($user && $password == $user['password']  && $user['status'] == 'active') {
                // Authentication successful
                $_SESSION['user'] = $user; // Store user data in session
                echo json_encode(['success' => true, 'redirect' => _WEB_ROOT]);
                exit();
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
                exit();
            }
        } else {
            $this->render('login', $this->data); // Render login page
        }
    }
    

    public function logout() {
        // Destroy the session
        session_destroy();
        // Redirect to login page
        header('Location: ' . _WEB_ROOT);
        exit();
    }
}
?>