<?php
class AuthorController extends BaseController
{
    private $authorModel;
    private $paperModel;

    public function __construct() {
        $this->authorModel = $this->loadModel('AuthorModel');
        $this->paperModel = $this->loadModel('PaperModel');
    }

    // Hiển thị thông tin tác giả
    public function index($id) {
        // Lấy thông tin tác giả theo ID
        $author = $this->authorModel->getAuthorById($id);

        // Lấy danh sách các bài báo của tác giả
        $papers = $this->paperModel->getPapersByAuthorId($id);

        // Kiểm tra nếu tác giả tồn tại
        if ($author) {
            // Thiết lập dữ liệu cho view
            $this->data['title'] = 'Thông tin tác giả';
            $this->data['content'] = 'authors/index'; // Chỉ định view cụ thể cho nội dung
            $this->data['sub_content'] = [
                'author' => $author, // Dữ liệu chi tiết tác giả
                'papers' => $papers // Dữ liệu bài báo của tác giả
            ];

            // Render view thông qua layout chính
            $this->render('layouts/main_layout', $this->data);
        } else {
            // Nếu không tìm thấy tác giả, hiển thị lỗi
            echo "Author not found.";
        }
    }
    public function edit($id) {
        $currentUserId = $_SESSION['user']['user_id']; // Lấy ID của người dùng hiện tại
        if ($currentUserId != $id) {
            // Nếu người dùng hiện tại không phải là tác giả đang xem, điều hướng về trang chủ
            header('Location: ' . _WEB_ROOT);
            exit();
        }
    
        // Lấy thông tin tác giả theo ID
        $author = $this->authorModel->getAuthorById($id);
        if ($author) {
            // Thiết lập dữ liệu cho view
            $this->data['title'] = 'Chỉnh sửa thông tin tác giả';
            $this->data['content'] = 'authors/edit'; // Chỉ định view cụ thể cho nội dung
            $this->data['sub_content'] = [
                'author' => $author // Dữ liệu chi tiết tác giả
            ];
    
            // Render view thông qua layout chính
            $this->render('layouts/main_layout', $this->data);
        } else {
            // Nếu không tìm thấy tác giả, điều hướng về trang chủ
            header('Location: ' . _WEB_ROOT);
            exit();
        }
    }
    public function update($id) {
        // Kiểm tra xem người dùng hiện tại có quyền cập nhật thông tin không
        $currentUserId = $_SESSION['user']['user_id'];
        if ($currentUserId != $id) {
            // Nếu không phải là tác giả hiện tại, chuyển hướng về trang chủ
            header('Location: ' . _WEB_ROOT);
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $fullName = $_POST['full_name'];
            $website = $_POST['website'];
            $profileJsonText = json_encode([
                'bio' => $_POST['bio'],
                'interests' => explode(',', $_POST['interests'])
            ]);
    
            // Xử lý ảnh tải lên
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = $_FILES['image'];
                $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
                $targetDir = _DIR_ROOT . '/public/img/';
                $targetFile = $targetDir . uniqid() . '.' . $ext;
    
                if (move_uploaded_file($image['tmp_name'], $targetFile)) {
                    $imagePath = str_replace(_DIR_ROOT, '', $targetFile);
                }
            }
    
            // Cập nhật thông tin tác giả
            $updateData = [
                'full_name' => $fullName,
                'website' => $website,
                'profile_json_text' => $profileJsonText,
            ];
    
            if ($imagePath) {
                $updateData['image_path'] = $imagePath;
            }
    
            $this->authorModel->updateAuthor($id, $updateData);
    
            // Điều hướng đến trang chi tiết của tác giả
            header('Location: ' . _WEB_ROOT . '/author/index/' . $id);
            exit();
        } else {
            // Nếu không phải là POST, điều hướng về trang chỉnh sửa
            $this->edit($id);
        }
    }
    
    
}
?>