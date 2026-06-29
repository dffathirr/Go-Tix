<?php
function encrypt_id($id) {
    // Encode the ID with a prefix and make it URL-safe
    return rtrim(strtr(base64_encode('GOTIX-' . $id), '+/', '-_'), '=');
}

function decrypt_id($hash) {
    // Decode the URL-safe base64 string
    $decoded = base64_decode(strtr($hash, '-_', '+/'));
    
    // Check if the prefix matches and extract the ID
    if (strpos($decoded, 'GOTIX-') === 0) {
        return substr($decoded, 6);
    }
    return null;
}

function base_url($path = '') {
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}

function render_view($viewPath, $data = []) {
    // Extract variables into current scope
    if (!empty($data)) {
        extract($data);
    }
    
    // Start output buffering for the view content
    ob_start();
    require __DIR__ . '/../views/' . $viewPath . '.php';
    $content = ob_get_clean();
    
    // Default values if not set by the view
    $title = $title ?? 'G0-Tix - Pesan Tiket Bioskop & Event';
    $activeMenu = $activeMenu ?? '';
    
    // Require the master layout
    require __DIR__ . '/../views/layouts/app.php';
}
?>
