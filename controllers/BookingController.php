<?php
require_once __DIR__ . '/../config/database.php';

class BookingController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getJadwalDetails($id_jadwal) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT
                j.id,
                f.id as movie_id,
                f.title as movie_title,
                c.nama AS cinema,
                c.id as cinema_id,
                t.id as date_id,
                t.tanggal,
                rw.nama AS jam,
                rs.nama AS studio,
                j.harga
                FROM jadwal j
                JOIN film f ON f.id=j.id_film
                JOIN cinema c ON c.id=j.id_cinema
                JOIN tanggal t ON t.id=j.id_tanggal
                JOIN reference rw ON rw.kode=j.kd_waktu
                JOIN reference rs ON rs.kode=j.kd_audi
                WHERE j.id = ?
            ");
            $stmt->execute([$id_jadwal]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return null;
        }
    }

    public function getSeats($id_cinema, $id_jadwal) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT
                s.id,
                r.nama AS seat,
                CASE
                WHEN dp.id IS NULL THEN 'available'
                ELSE 'booked'
                END AS status
                FROM seat s
                JOIN reference r
                ON r.kode=s.kd_seat
                LEFT JOIN detail_pemesanan dp
                ON dp.id_seat=s.id
                LEFT JOIN pemesanan p
                ON p.id=dp.id_pemesanan
                AND p.id_jadwal=?
                AND p.status='success'
                WHERE s.id_cinema=?
                ORDER BY r.nama
            ");
            // The placeholder order is id_jadwal, id_cinema
            $stmt->execute([$id_jadwal, $id_cinema]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getPaymentMethods() {
        try {
            $stmt = $this->pdo->prepare("
                SELECT kode, nama
                FROM reference
                WHERE `group`='PEMBAYARAN'
            ");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function processCheckout($id_customer, $id_jadwal, $seats, $total_harga, $kd_pembayaran) {
        try {
            $this->pdo->beginTransaction();
            
            // Insert pemesanan
            $stmt = $this->pdo->prepare("
                INSERT INTO pemesanan(id_customer, id_jadwal, jml_tiket, total_harga, kd_pembayaran, status) 
                VALUES(?, ?, ?, ?, ?, 'success')
            ");
            $stmt->execute([$id_customer, $id_jadwal, count($seats), $total_harga, $kd_pembayaran]);
            $idPemesanan = $this->pdo->lastInsertId();
            
            // Insert detail_pemesanan
            $stmtDetail = $this->pdo->prepare("
                INSERT INTO detail_pemesanan(id_pemesanan, id_seat) 
                VALUES(?, ?)
            ");
            foreach($seats as $id_seat) {
                $stmtDetail->execute([$idPemesanan, $id_seat]);
            }
            
            $this->pdo->commit();
            return $idPemesanan;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}
