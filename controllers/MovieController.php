<?php
require_once __DIR__ . '/../config/database.php';

class MovieController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Map movie titles (or IDs) to poster image paths
    private $posterMap = [
        'tumbal proyek' => 'assets/img/poster-tumbal-proyek.webp',
        'semua akan baik' => 'assets/img/poster-semua-akan-baik-saja.jpg', // Partial match
        'star wars' => 'assets/img/poster-star-wars.webp',
        'salmokji' => 'assets/img/poster-salmoki.webp', // matches db salmokji to file salmoki
        'ghost in the cell' => 'assets/img/poster-ghost-in-cell.png',
        'toy story 5' => 'assets/img/poster-toy-story.webp',
        'dukun magang' => 'assets/img/poster-dukun-magang.webp',
        'clbk' => 'assets/img/poster-clbk.webp',
        'kucing hitam' => 'assets/img/poster-kucing-hitam.webp',
        'minions' => 'assets/img/poster-minions.webp',
        'five friends' => 'assets/img/poster-five-friend-2.webp',
        'gedung merica' => 'assets/img/poster-gudang-merica.webp',
        'hokum' => 'assets/img/poster-hokum.webp',
        'moana' => 'assets/img/poster-moana.webp',
        'the death of robin' => 'assets/img/the death of robin.webp',
        'warkop' => 'assets/img/warkop  dki.webp'
    ];

    public function getOngoingMovies($limit = 10) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM film WHERE type = 'ongoing' ORDER BY id DESC LIMIT :limit");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $movies = $stmt->fetchAll();
            return $this->attachPosters($movies);
        } catch (Exception $e) {
            return [];
        }
    }

    public function getComingSoonMovies($limit = 10) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM film WHERE type = 'coming soon' ORDER BY id DESC LIMIT :limit");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $movies = $stmt->fetchAll();
            return $this->attachPosters($movies);
        } catch (Exception $e) {
            return [];
        }
    }

    public function getMovieById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM film WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $movie = $stmt->fetch();
            if ($movie) {
                // Attach poster using the existing method but wrapped in an array
                $moviesWithPosters = $this->attachPosters([$movie]);
                return $moviesWithPosters[0];
            }
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function getAvailableDates($limit = 10) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT *
                FROM tanggal 
                WHERE tanggal >= CURRENT_DATE
                ORDER BY tanggal ASC
                LIMIT :limit
            ");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getAvailableDatesByMovie($movieId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT DISTINCT t.*
                FROM jadwal j
                JOIN tanggal t ON j.id_tanggal = t.id
                WHERE j.id_film = :movie_id
                ORDER BY t.tanggal ASC
            ");
            $stmt->bindValue(':movie_id', $movieId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getSchedulesByMovieAndDate($movieId, $dateId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT c.nama as cinema_name, j.id as id_jadwal, j.harga, r.nama as waktu, j.status
                FROM jadwal j
                JOIN cinema c ON j.id_cinema = c.id
                JOIN reference r ON j.kd_waktu = r.kode
                WHERE j.id_film = :movie_id AND j.id_tanggal = :date_id
                ORDER BY c.nama ASC, r.nama ASC
            ");
            $stmt->bindValue(':movie_id', $movieId, PDO::PARAM_INT);
            $stmt->bindValue(':date_id', $dateId, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll();
            
            $cinemas = [];
            foreach ($results as $row) {
                $cinemaName = $row['cinema_name'];
                if (!isset($cinemas[$cinemaName])) {
                    $cinemas[$cinemaName] = [];
                }
                $cinemas[$cinemaName][] = [
                    'id_jadwal' => $row['id_jadwal'],
                    'waktu' => $row['waktu'],
                    'harga' => $row['harga'],
                    'status' => $row['status']
                ];
            }
            return $cinemas;
        } catch (Exception $e) {
            return [];
        }
    }

    private function attachPosters($movies) {
        foreach ($movies as &$movie) {
            $titleLower = strtolower($movie['title']);
            $assignedPoster = 'assets/img/poster-ongoing-1.webp'; // Default fallback
            
            // Search in mapping
            foreach ($this->posterMap as $key => $posterPath) {
                if (strpos($titleLower, $key) !== false) {
                    $assignedPoster = $posterPath;
                    break;
                }
            }
            
            // Only assign if the DB doesn't already have a valid poster column
            if (empty($movie['poster'])) {
                $movie['poster'] = $assignedPoster;
            }
        }
        return $movies;
    }
}
