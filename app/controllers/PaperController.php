<?php
class PaperController extends BaseController
{
    private $paperModel;
    private $conferenceModel;
    private $topicModel;
    private $participationModel;
    private $authorModel;


    public function __construct() {
        $this->paperModel = $this->loadModel('PaperModel');
        $this->conferenceModel = $this->loadModel('ConferenceModel');
        $this->topicModel = $this->loadModel('TopicModel');
        $this->participationModel = $this->loadModel('ParticipationModel');
        $this->authorModel = $this->loadModel('AuthorModel');
    }

    // Hiển thị chi tiết bài báo
    public function detail($id) {
        // Lấy thông tin bài báo theo ID
        $paper = $this->paperModel->getPaperById($id);

      
        // Kiểm tra nếu bài báo tồn tại
        if ($paper) {
            // Lấy thông tin hội nghị
            $conference = $this->conferenceModel->getConferenceById($paper['conference_id']);
            
            // Lấy thông tin chủ đề
            $topic = $this->topicModel->getTopicById($paper['topic_id']);

            // Lấy thông tin tác giả
            $authors = $this->participationModel->getAuthorsByPaperId($paper['paper_id']);

            // Thiết lập dữ liệu cho view
            $this->data['title'] = 'Chi tiết';
            $this->data['content'] = 'papers/detail'; // Chỉ định view cụ thể cho nội dung
            $this->data['sub_content'] = [
                'paper' => $paper, // Dữ liệu chi tiết bài báo
                'conference' => $conference, // Thông tin hội nghị
                'topic' => $topic, // Thông tin chủ đề
                'authors' => $authors // Dữ liệu tác giả
            ];

            // Render view thông qua layout chính
            $this->render('layouts/main_layout', $this->data);
        } else {
            // Nếu không tìm thấy bài báo, hiển thị lỗi
            echo "Paper not found.";
        }
    }
    // Phương thức hiển thị trang tìm kiếm
    public function search() {
        $this->data['title'] = 'Tìm kiếm bài báo';
        $this->data['content'] = 'papers/search';
        $this->render('layouts/main_layout', $this->data);
    }

    // Phương thức xử lý tìm kiếm bài báo qua AJAX
    public function searchPapers() {
        $keyword = $_GET['keyword'] ?? '';
        $author = $_GET['author'] ?? '';
        $conference = $_GET['conference'] ?? '';
        $date = $_GET['date'] ?? '';
        $topic = $_GET['topic'] ?? '';
        $page = $_GET['page'] ?? 1;

        $papers = $this->paperModel->searchPapers($keyword, $author, $conference, $date, $topic, $page);

        $this->data['sub_content']['papers'] = $papers;
        $this->data['sub_content']['currentPage'] = $page;
        $this->data['sub_content']['totalPages'] = $this->paperModel->getTotalPages($keyword, $author, $conference, $date, $topic);

        $this->render('papers/search_results', $this->data['sub_content']);
    }
    public function add() {
        // Load conferences and topics for combo boxes
        $conferences = $this->conferenceModel->getAllConferences();
        $topics = $this->topicModel->getAllTopics();

        // Load authors for selection
        $authors = $this->authorModel->getAllAuthors();

        // Ensure the current user is included at the top
        $currentUserId = $_SESSION['user']['user_id'];
        $currentUser = null;

        foreach ($authors as $key => $author) {
            if ($author['user_id'] == $currentUserId) {
                $currentUser = $author;
                unset($authors[$key]);
                break;
            }
        }

        if ($currentUser) {
            array_unshift($authors, $currentUser);
        }

        // Pass data to the view
        $this->data['sub_content'] = [
            'conferences' => $conferences,
            'topics' => $topics,
            'authors' => $authors
        ];
        $this->data['title'] = 'Thêm báo';

        $this->data['content'] = 'papers/add';
        $this->render('layouts/main_layout', $this->data);
       // The render method will use layouts/main_layout.php
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $abstract = $_POST['abstract'];
            $conferenceId = $_POST['conference_id'];
            $topicId = $_POST['topic_id'];
            $userId = $_SESSION['user']['user_id'];

            // Get selected authors and roles
            $authorRoles = $_POST['author_roles']; // e.g., ['1' => 'first_author', '2' => 'member']

            // Insert the new paper into the PAPERS table
            $paperId = $this->paperModel->addPaper($title, $abstract, $conferenceId, $topicId, $userId);

            // Insert records into PARTICIPATION table
            foreach ($authorRoles as $authorId => $role) {
                $this->paperModel->addParticipation($authorId, $paperId, $role, date('Y-m-d H:i:s'), 'show');
            }

            // Redirect to the papers index page
            header('Location: ' . _WEB_ROOT);
            exit();
        }
    }
}
?>