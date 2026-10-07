<?php
class Controller {
    public function model($modelName) {
        $file = ROOT_PATH . '/app/models/' . $modelName . '.php';
        if (file_exists($file)) {
            require_once $file;
            return new $modelName();
        }
        die("Model does not exist: $modelName");
    }

    public function view($viewPath, $data = [], $layout = null) {
        $data['data'] = $data; // Allow accessing both $var and $data['var']
        extract($data);
        $file = ROOT_PATH . '/app/views/' . $viewPath . '.php';
        if (!file_exists($file)) {
            die("View does not exist: $viewPath");
        }

        // If layout is explicitly set to false, render view directly
        if ($layout === false) {
            require $file;
            return;
        }

        // Determine default layout based on path if not specified
        if ($layout === null) {
            if (str_starts_with($viewPath, 'auth/')) {
                $layout = 'layouts/auth';
            } elseif (str_starts_with($viewPath, 'admin/') || str_starts_with($viewPath, 'superadmin/')) {
                $layout = 'layouts/admin';
            } else {
                $layout = 'layouts/public';
            }
        }

        // Buffer the view content
        ob_start();
        require $file;
        $content = ob_get_clean();

        // Automatically inject platform branding if available
        if (!isset($platformProfile)) {
            try {
                $pengaturanModel = $this->model('PengaturanModel');
                $platformProfile = $pengaturanModel->getPlatformProfile();
            } catch (Exception $e) {
                $platformProfile = [
                    'app_name' => 'Jejak Muslim Indonesia',
                    'app_logo' => 'public/img/logo-transparent.png',
                    'app_favicon' => 'public/img/favicon.png'
                ];
            }
        }

        // Render layout
        $layoutFile = ROOT_PATH . '/app/views/' . $layout . '.php';
        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            echo $content;
        }
    }

    public function redirect($url) {
        header('Location: ' . BASE_URL . '/' . ltrim($url, '/'));
        exit;
    }

    public function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function isPost() {
        return ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';
    }

    public function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
