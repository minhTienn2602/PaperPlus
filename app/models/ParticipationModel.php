<?php
class ParticipationModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect(); // Store PDO connection in $this->db
    }

    public function getAuthorsByPaperId($paper_id) {
        $sql = "
            SELECT a.user_id, a.full_name, p.role 
            FROM PARTICIPATION p
            JOIN AUTHORS a ON p.author_id = a.user_id
            WHERE p.paper_id = :paper_id
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['paper_id' => $paper_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addParticipation($authorId, $paperId, $role) {
        $query = "INSERT INTO PARTICIPATION (author_id, paper_id, role, date_added, status)
                  VALUES (:author_id, :paper_id, :role, NOW(), 'show')";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':author_id', $authorId, PDO::PARAM_INT);
        $stmt->bindParam(':paper_id', $paperId, PDO::PARAM_INT);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function getRoleInPaper($authorId, $paperId) {
        $query = "SELECT role FROM PARTICIPATION
                  WHERE author_id = :author_id AND paper_id = :paper_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':author_id', $authorId, PDO::PARAM_INT);
        $stmt->bindParam(':paper_id', $paperId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($result) ? $result['role'] : false;
    }
}
?>