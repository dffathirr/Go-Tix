<?php
require_once __DIR__ . '/../config/database.php';

class AdminController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // --- DASHBOARD ---
    public function getDashboardStats() {
        $stats = [];
        try {
            $stats['total_movies'] = $this->pdo->query("SELECT COUNT(*) FROM film")->fetchColumn();
            $stats['total_cinemas'] = $this->pdo->query("SELECT COUNT(*) FROM cinema")->fetchColumn();
            $stats['total_bookings'] = $this->pdo->query("SELECT COUNT(*) FROM pemesanan")->fetchColumn();
        } catch (Exception $e) {
            $stats = ['total_movies' => 0, 'total_cinemas' => 0, 'total_bookings' => 0];
        }
        return $stats;
    }

    // --- MOVIES ---
    public function getMovies() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM film ORDER BY id DESC");
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function storeMovie($data) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO film (title, genre, durasi, rating, type) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([
                $data['title'], 
                $data['genre'], 
                $data['durasi'], 
                $data['rating'], 
                $data['type']
            ]);
        } catch (Exception $e) {
            $_SESSION['error_msg'] = "Gagal menambahkan film. Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateMovie($id, $data) {
        try {
            $stmt = $this->pdo->prepare("UPDATE film SET title=?, genre=?, durasi=?, rating=?, type=? WHERE id=?");
            return $stmt->execute([
                $data['title'], 
                $data['genre'], 
                $data['durasi'], 
                $data['rating'], 
                $data['type'],
                $id
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteMovie($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM film WHERE id=?");
            return $stmt->execute([$id]);
        } catch (Exception $e) {
            return false;
        }
    }

    // --- CINEMAS ---
    public function getCinemas() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM cinema ORDER BY id DESC");
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function storeCinema($data) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO cinema (nama, jml_kursi, status) VALUES (?, 50, 'open')");
            return $stmt->execute([$data['nama']]);
        } catch (Exception $e) {
            $_SESSION['error_msg'] = "Gagal menambahkan bioskop. Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateCinema($id, $data) {
        try {
            $stmt = $this->pdo->prepare("UPDATE cinema SET nama=? WHERE id=?");
            return $stmt->execute([$data['nama'], $id]);
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteCinema($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM cinema WHERE id=?");
            return $stmt->execute([$id]);
        } catch (Exception $e) {
            return false;
        }
    }

    // --- BOOKINGS ---
    public function getBookings() {
        try {
            $stmt = $this->pdo->query("
                SELECT p.id, p.jml_tiket, p.total_harga, p.kd_pembayaran, p.status, 
                       c.nama as customer_name, f.title as movie_title, t.tanggal
                FROM pemesanan p
                LEFT JOIN customer c ON c.id = p.id_customer
                LEFT JOIN jadwal j ON j.id = p.id_jadwal
                LEFT JOIN film f ON f.id = j.id_film
                LEFT JOIN tanggal t ON t.id = j.id_tanggal
                ORDER BY p.id DESC
            ");
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
}
?>
