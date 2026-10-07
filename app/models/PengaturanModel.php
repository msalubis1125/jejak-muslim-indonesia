<?php

class PengaturanModel extends Model {
    protected $table = 'pengaturan';

    public function get($key, $default = null) {
        $stmt = $this->db->prepare("SELECT `value` FROM {$this->table} WHERE `key` = :key");
        $stmt->execute(['key' => $key]);
        $row = $stmt->fetch();
        return $row !== false && $row['value'] !== null ? $row['value'] : $default;
    }

    public function set($key, $value) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (`key`, `value`) 
            VALUES (:key, :val) 
            ON DUPLICATE KEY UPDATE `value` = :val_update, `updated_at` = NOW()
        ");
        return $stmt->execute([
            'key' => $key,
            'val' => $value,
            'val_update' => $value
        ]);
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT `key`, `value` FROM {$this->table}");
        $rows = $stmt->fetchAll();
        $result = [];
        foreach ($rows as $r) {
            $result[$r['key']] = $r['value'];
        }
        return $result;
    }

    public function getQrisWebsiteSettings() {
        $image = $this->get('qris_website_image', '');
        if (empty($image)) {
            $imageUrl = 'https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg';
        } elseif (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            $imageUrl = $image;
        } else {
            $imageUrl = BASE_URL . '/' . ltrim($image, '/');
        }

        return [
            'title' => $this->get('qris_website_title', 'Infaq & Donasi Pengembangan Website'),
            'desc' => $this->get('qris_website_desc', 'Dukung keberlanjutan dan pengembangan fitur portal Jejak Muslim Indonesia melalui donasi QRIS.'),
            'image' => $imageUrl,
            'raw_image' => $image,
            'atas_nama' => $this->get('qris_website_atas_nama', 'Jejak Muslim Indonesia'),
            'footer' => $this->get('qris_website_footer', 'Setiap infaq dan donasi Anda menjadi amal jariyah untuk kemakmuran masjid digital di Indonesia.'),
            'is_active' => (string)$this->get('qris_website_is_active', '1') === '1'
        ];
    }

    public function updateQrisWebsiteSettings($data) {
        if (isset($data['title'])) {
            $this->set('qris_website_title', trim($data['title']));
        }
        if (isset($data['desc'])) {
            $this->set('qris_website_desc', trim($data['desc']));
        }
        if (isset($data['atas_nama'])) {
            $this->set('qris_website_atas_nama', trim($data['atas_nama']));
        }
        if (isset($data['footer'])) {
            $this->set('qris_website_footer', trim($data['footer']));
        }
        if (isset($data['is_active'])) {
            $this->set('qris_website_is_active', $data['is_active'] ? '1' : '0');
        }
        if (!empty($data['image'])) {
            $this->set('qris_website_image', $data['image']);
        }
        return true;
    }

    public function getPlatformProfile() {
        return [
            'app_name' => $this->get('app_name', 'Jejak Muslim Indonesia'),
            'app_tagline' => $this->get('app_tagline', 'Pusat Ekosistem Digital Masjid Nusantara'),
            'app_about' => $this->get('app_about', 'Jejak Muslim Indonesia adalah platform digital terpadu yang menghubungkan masjid, takmir, dan jamaah di seluruh nusantara. Kami menyediakan pencarian masjid berbasis GIS, jadwal shalat akurat, agenda kegiatan dakwah, transparansi keuangan kas masjid, serta kemudahan infaq digital.'),
            'app_email' => $this->get('app_email', 'kontak@jejakmuslim.id'),
            'app_phone' => $this->get('app_phone', '0812-3456-7890'),
            'app_address' => $this->get('app_address', 'Jakarta, Indonesia'),
            'app_facebook' => $this->get('app_facebook', 'https://facebook.com/jejakmuslim.id'),
            'app_instagram' => $this->get('app_instagram', 'https://instagram.com/jejakmuslim.id'),
            'app_youtube' => $this->get('app_youtube', 'https://youtube.com/@jejakmuslimid'),
            'app_whatsapp' => $this->get('app_whatsapp', 'https://wa.me/6281234567890')
        ];
    }

    public function updatePlatformProfile($data) {
        $keys = [
            'app_name', 'app_tagline', 'app_about', 'app_email', 
            'app_phone', 'app_address', 'app_facebook', 'app_instagram', 
            'app_youtube', 'app_whatsapp'
        ];
        foreach ($keys as $k) {
            if (isset($data[$k])) {
                $this->set($k, trim($data[$k]));
            }
        }
        return true;
    }
}
