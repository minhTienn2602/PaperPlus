<?php
class ParticipationController extends BaseController {
    private $participationModel;

    public function __construct() {
        $this->participationModel = $this->loadModel('ParticipationModel');
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['user'])) {
                $authorId = $_POST['author_id'];
                $paperId = $_POST['paper_id'];
                $role = 'member'; // Set the role as member

                // Check if the user is already a member or first author
                $existingRole = $this->participationModel->getRoleInPaper($authorId, $paperId);
                
                if (!$existingRole) {
                    // Insert into PARTICIPATION table
                    $result = $this->participationModel->addParticipation($authorId, $paperId, $role);

                    if ($result) {
                        // Redirect or show success message
                        // Example redirect:
                        header('Location: ' . _WEB_ROOT . '/paper/detail/' . $paperId);
                        exit();
                    } else {
                        // Handle error, maybe show an error message
                        echo "Failed to add as member.";
                    }
                } else {
                    // User is already a member or first author
                    echo "Bạn đã là member/first_author của bài báo này.";
                }
            } else {
                // Redirect to login if user is not logged in
                header('Location: ' . _WEB_ROOT . '/user/login');
                exit();
            }
        } else {
            // Handle GET request or other methods if needed
            // Maybe redirect to homepage or show an error
            echo "Method not allowed.";
        }
    }
}
?>