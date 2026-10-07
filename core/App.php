<?php
class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();
        $controllerPath = ROOT_PATH . '/app/controllers/';

        // Check for admin or superadmin prefix
        if (!empty($url) && $url[0] === 'admin') {
            array_shift($url); // remove 'admin'
            $controllerPath .= 'admin/';

            if (!empty($url) && $url[0] === 'superadmin') {
                array_shift($url); // remove 'superadmin'
                $controllerPath .= 'superadmin/';

                // Map route shortcuts for superadmin
                $map = [
                    'verifikasi' => 'MasjidVerifController',
                    'masjidverif' => 'MasjidVerifController',
                    'users' => 'UserMgmtController',
                    'usermgmt' => 'UserMgmtController',
                    'masterdata' => 'MasterDataController',
                    'qris' => 'QrisSettingsController',
                    'pengaturan' => 'QrisSettingsController',
                    'profil' => 'PlatformProfileController',
                    'profilplatform' => 'PlatformProfileController',
                    'platform' => 'PlatformProfileController'
                ];
                $target = strtolower($url[0] ?? '');
                if (isset($map[$target])) {
                    $this->controller = $map[$target];
                    array_shift($url);
                } else {
                    $this->controller = 'MasjidVerifController';
                }
            } else {
                // Map route shortcuts for admin
                $map = [
                    'dashboard' => 'DashboardController',
                    'masjid' => 'MasjidMgmtController',
                    'keuangan' => 'KeuanganController',
                    'kegiatan' => 'KegiatanMgmtController',
                    'jadwalpetugas' => 'JadwalPetugasController',
                    'aset' => 'AsetController',
                    'jamaah' => 'JamaahMgmtController',
                    'donasi' => 'DonasiMgmtController',
                    'donasimgmt' => 'DonasiMgmtController'
                ];
                $target = strtolower($url[0] ?? '');
                if (isset($map[$target])) {
                    $this->controller = $map[$target];
                    array_shift($url);
                } elseif (!empty($url) && file_exists($controllerPath . ucfirst($url[0]) . 'Controller.php')) {
                    $this->controller = ucfirst($url[0]) . 'Controller';
                    array_shift($url);
                } else {
                    $this->controller = 'DashboardController';
                }
            }
        } elseif (!empty($url)) {
            // Public controller lookup
            $potential = ucfirst($url[0]) . 'Controller';
            if (file_exists($controllerPath . $potential . '.php')) {
                $this->controller = $potential;
                array_shift($url);
            }
        }

        // Include controller file
        if (!file_exists($controllerPath . $this->controller . '.php')) {
            $this->controller = 'HomeController';
            $controllerPath = ROOT_PATH . '/app/controllers/';
        }

        require_once $controllerPath . $this->controller . '.php';
        $controllerInstance = new $this->controller();

        // Determine method
        if (!empty($url)) {
            if (method_exists($controllerInstance, $url[0])) {
                $this->method = $url[0];
                array_shift($url);
            } elseif ($this->controller === 'MasjidController' && !empty($url[0])) {
                // /masjid/{slug} maps to detail($slug)
                $this->method = 'detail';
            } elseif ($this->controller === 'KegiatanController' && !empty($url[0]) && is_numeric($url[0])) {
                // /kegiatan/{id} maps to detail($id)
                $this->method = 'detail';
            } elseif ($this->controller === 'ArtikelController' && !empty($url[0])) {
                // /artikel/{slug} maps to detail($slug)
                $this->method = 'detail';
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
