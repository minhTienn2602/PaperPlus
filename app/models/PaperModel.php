<?php
class PaperModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }
// Lấy thông tin bài báo theo ID
    public function getPaperById($id) {
        $sql = "SELECT * FROM PAPERS WHERE paper_id = :paper_id";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':paper_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Lấy các bài báo theo chủ đề
    public function getPapersByTopic($topicId, $limit = 5) {
        $sql = "SELECT * FROM PAPERS WHERE topic_id = :topic_id ORDER BY paper_id DESC LIMIT :limit";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':topic_id', $topicId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  
     // Lấy các bài báo theo ID tác giả
    
    public function getPapersByAuthorId($author_id) {
        $sql = "
            SELECT p.*
            FROM PAPERS p
            JOIN PARTICIPATION pa ON p.paper_id = pa.paper_id
            WHERE pa.author_id = :author_id
            AND pa.status = 'show'
            ORDER BY p.paper_id DESC
        ";
    
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function searchPapers($keyword, $author, $conference, $date, $topic, $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM PAPERS WHERE 1=1";

        if (!empty($keyword)) {
            $sql .= " AND title LIKE :keyword";
        }
        if (!empty($author)) {
            $sql .= " AND author_string_list LIKE :author";
        }
        if (!empty($conference)) {
            $sql .= " AND (conference_id IN (SELECT conference_id FROM CONFERENCES WHERE name LIKE :conference OR abbreviation LIKE :conference))";
        }
        if (!empty($date)) {
            $sql .= " AND (conference_id IN (SELECT conference_id FROM CONFERENCES WHERE start_date <= :date AND end_date >= :date))";
        }
        if (!empty($topic)) {
            $sql .= " AND topic_id IN (SELECT topic_id FROM TOPICS WHERE topic_name LIKE :topic)";
        }
        $sql .= " LIMIT :offset, :perPage";

        $pdo = $this->db->connect();
        $stmt = $pdo->prepare($sql);

        if (!empty($keyword)) {
            $stmt->bindValue(':keyword', '%' . $keyword . '%');
        }
        if (!empty($author)) {
            $stmt->bindValue(':author', '%' . $author . '%');
        }
        if (!empty($conference)) {
            $stmt->bindValue(':conference', '%' . $conference . '%');
        }
        if (!empty($date)) {
            $stmt->bindValue(':date', $date);
        }
        if (!empty($topic)) {
            $stmt->bindValue(':topic', '%' . $topic . '%');
        }
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalPages($keyword, $author, $conference, $date, $topic, $perPage = 10) {
        $sql = "SELECT COUNT(*) AS total FROM PAPERS WHERE 1=1";

        if (!empty($keyword)) {
            $sql .= " AND title LIKE :keyword";
        }
        if (!empty($author)) {
            $sql .= " AND author_string_list LIKE :author";
        }
        if (!empty($conference)) {
            $sql .= " AND (conference_id IN (SELECT conference_id FROM CONFERENCES WHERE name LIKE :conference OR abbreviation LIKE :conference))";
        }
        if (!empty($date)) {
            $sql .= " AND (conference_id IN (SELECT conference_id FROM CONFERENCES WHERE start_date <= :date AND end_date >= :date))";
        }
        if (!empty($topic)) {
            $sql .= " AND topic_id IN (SELECT topic_id FROM TOPICS WHERE topic_name LIKE :topic)";
        }

        $pdo = $this->db->connect();
        $stmt = $pdo->prepare($sql);

        if (!empty($keyword)) {
            $stmt->bindValue(':keyword', '%' . $keyword . '%');
        }
        if (!empty($author)) {
            $stmt->bindValue(':author', '%' . $author . '%');
        }
        if (!empty($conference)) {
            $stmt->bindValue(':conference', '%' . $conference . '%');
        }
        if (!empty($date)) {
            $stmt->bindValue(':date', $date);
        }
        if (!empty($topic)) {
            $stmt->bindValue(':topic', '%' . $topic . '%');
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $total = $result['total'];

        return ceil($total / $perPage);
    }
    public function addPaper($title, $abstract, $conferenceId, $topicId, $userId) {
        $sql = "INSERT INTO PAPERS (title, author_string_list, abstract, conference_id, topic_id, user_id) 
                VALUES (:title, :author_string_list, :abstract, :conference_id, :topic_id, :user_id)";
    
        // Kết nối đến cơ sở dữ liệu
        $pdo = $this->db->connect();
        
        // Chuẩn bị câu lệnh
        $stmt = $pdo->prepare($sql);
        
        // Thực thi câu lệnh
        $stmt->execute([
            ':title' => $title,
            ':author_string_list' => '', // This can be empty or calculated if needed
            ':abstract' => $abstract,
            ':conference_id' => $conferenceId,
            ':topic_id' => $topicId,
            ':user_id' => $userId
        ]);
    
        // Trả về ID của bản ghi vừa chèn
        return $pdo->lastInsertId();
    }
    public function addParticipation($authorId, $paperId, $role, $dateAdded, $status) {
        $sql = "INSERT INTO PARTICIPATION (author_id, paper_id, role, date_added, status) 
                VALUES (:author_id, :paper_id, :role, :date_added, :status)";
    
        // Kết nối đến cơ sở dữ liệu
        $pdo = $this->db->connect();
        
        // Chuẩn bị câu lệnh
        $stmt = $pdo->prepare($sql);
        
        // Thực thi câu lệnh
        $stmt->execute([
            ':author_id' => $authorId,
            ':paper_id' => $paperId,
            ':role' => $role,
            ':date_added' => $dateAdded,
            ':status' => $status
        ]);
    }
    
}
?>