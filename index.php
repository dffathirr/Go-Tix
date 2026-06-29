<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/MovieController.php';
require_once __DIR__ . '/controllers/BookingController.php';
require_once __DIR__ . '/utils/helper.php';

// $pdo is already initialized in config/database.php

// Initialize Controllers
$movieController = new MovieController($pdo);
$bookingController = new BookingController($pdo);
require_once __DIR__ . '/controllers/AuthController.php';
$authController = new AuthController($pdo);

// Parsing URL
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$url = filter_var($url, FILTER_SANITIZE_URL);
$urlParams = explode('/', $url);

$route = $urlParams[0];

switch ($route) {
    case 'auth':
        $action = isset($urlParams[1]) ? $urlParams[1] : null;
        if ($action === 'login') {
            $authController->login();
        } elseif ($action === 'register') {
            $authController->register();
        } elseif ($action === 'logout') {
            $authController->logout();
        } else {
            header("HTTP/1.0 404 Not Found");
        }
        break;

    case '':
    case 'home':
        // Fetch Ongoing Movies (Sedang Tayang)
        $ongoingMovies = $movieController->getOngoingMovies(10);
        // Fetch Coming Soon Movies (Akan Tayang)
        $comingSoonMovies = $movieController->getComingSoonMovies(10);
        
        render_view('home', get_defined_vars());
        break;

    case 'movies':
        $hashId = isset($urlParams[1]) ? $urlParams[1] : null;
        if ($hashId) {
            $id = decrypt_id($hashId);
            if ($id) {
                $movieDetail = $movieController->getMovieById($id);
                if ($movieDetail) {
                    $availableDates = $movieController->getAvailableDates(10);
                    $dateHash = isset($_GET['date']) ? $_GET['date'] : null;
                    $selectedDateId = $dateHash ? decrypt_id($dateHash) : (!empty($availableDates) ? $availableDates[0]['id'] : null);
                    $schedules = $selectedDateId ? $movieController->getSchedulesByMovieAndDate($id, $selectedDateId) : [];
                    render_view('detail', get_defined_vars());
                } else {
                    // Movie not found in DB
                    header("Location: /gotix-php/movies");
                    exit();
                }
            } else {
                // If decryption fails (invalid ID hash), redirect back to movies list
                header("Location: /gotix-php/movies");
                exit();
            }
        } else {
            // Fetch movies for list
            $ongoingMovies = $movieController->getOngoingMovies(100);
            $comingSoonMovies = $movieController->getComingSoonMovies(100);
            render_view('movies', get_defined_vars());
        }
        break;

    case 'booking':
        $jadwalHash = isset($_GET['jadwal']) ? $_GET['jadwal'] : null;
        $jadwalId = $jadwalHash ? decrypt_id($jadwalHash) : null;
        if ($jadwalId) {
            $jadwalDetails = $bookingController->getJadwalDetails($jadwalId);
            
            if ($jadwalDetails) {
                // Handle Checkout POST
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $seats = isset($_POST['selected_seats']) ? explode(',', $_POST['selected_seats']) : [];
                    $total_harga = isset($_POST['total_harga']) ? (int)$_POST['total_harga'] : 0;
                    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
                    
                    if (!empty($seats) && $total_harga > 0 && !empty($payment_method)) {
                        $id_customer = 1; // Hardcoded per plan
                        $success = $bookingController->processCheckout($id_customer, $jadwalId, $seats, $total_harga, $payment_method);
                        if ($success) {
                            render_view('booking_success', get_defined_vars());
                            exit();
                        }
                    }
                }
                
                // Load form
                $seats = $bookingController->getSeats($jadwalDetails['cinema_id'], $jadwalId);
                $paymentMethods = $bookingController->getPaymentMethods();
                render_view('booking', get_defined_vars());
            } else {
                header("Location: /gotix-php/movies");
                exit();
            }
        } else {
            header("Location: /gotix-php/movies");
            exit();
        }
        break;

    case 'login':
        require_once 'views/login.php';
        break;

    case 'register':
        require_once 'views/register.php';
        break;

    default:
        // 404 Not Found Page (fallback to home for now)
        header("Location: /gotix-php/");
        exit();
        break;
}
