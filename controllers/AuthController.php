<?php
require_once __DIR__ . '/../config/database.php';

class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            exit;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Email dan password harus diisi.']);
            exit;
        }

        try {
            $stmt = $this->pdo->prepare("SELECT * FROM customer WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nama'];
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Login berhasil.']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Email atau password salah.']);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan pada server.']);
        }
        exit;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            exit;
        }

        $nama = $_POST['nama'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $no_hp = $_POST['no_hp'] ?? '';

        if (empty($nama) || empty($email) || empty($password) || empty($no_hp)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Semua kolom wajib diisi.']);
            exit;
        }

        try {
            // Check if email exists
            $stmt = $this->pdo->prepare("SELECT id FROM customer WHERE email = :email");
            $stmt->execute([':email' => $email]);
            if ($stmt->fetch()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Email sudah terdaftar.']);
                exit;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("INSERT INTO customer (nama, email, password, no_hp) VALUES (:nama, :email, :password, :no_hp)");
            $stmt->execute([
                ':nama' => $nama,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':no_hp' => $no_hp
            ]);

            $userId = $this->pdo->lastInsertId();
            
            // Auto login after register
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_name'] = $nama;

            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Registrasi berhasil.']);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan pada server.']);
        }
        exit;
    }

    public function logout() {
        session_destroy();
        header("Location: " . base_url(''));
        exit;
    }
}
