<?php
class HomeController extends BaseController
{
    public $data = [];
    private $topicModel;
    private $paperModel;

    public function __construct() {
        $this->topicModel = $this->loadModel('TopicModel');
        $this->paperModel = $this->loadModel('PaperModel');
    }

    public function index() {
        // Lấy danh sách các chủ đề
        $topics = $this->topicModel->getAllTopics();
        

        $this->data['title'] = "Trang chủ";
        $this->data['content'] = "home/index";

        // Lấy 5 bài báo cho mỗi chủ đề
        $this->data['sub_content'] = [];
        foreach ($topics as $topic) {
            $papers = $this->paperModel->getPapersByTopic($topic['topic_id']);
            $this->data['sub_content'][$topic['topic_name']] = $papers;
        }

        // Render view
        $this->render('layouts/main_layout', $this->data);
    }
    public function about() {
   

     $this->data['title'] = "Giới thiệu";
     $this->data['content'] = "home/about";
    
     $this->render('layouts/main_layout', $this->data);
 }
}
?>