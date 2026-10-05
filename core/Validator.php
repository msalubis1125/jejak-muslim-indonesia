<?php
class Validator {
    public static function validate($data, $rules) {
        $errors = [];
        $valid = true;
        
        $db = Database::getInstance()->getConnection();

        foreach ($rules as $field => $ruleString) {
            $ruleArray = explode('|', $ruleString);
            $value = $data[$field] ?? null;

            foreach ($ruleArray as $rule) {
                $param = null;
                if (strpos($rule, ':') !== false) {
                    list($rule, $param) = explode(':', $rule);
                }

                if ($rule === 'required' && ($value === null || trim($value) === '')) {
                    $errors[$field][] = "Kolom $field wajib diisi.";
                    $valid = false;
                }
                if ($value !== null && trim($value) !== '') {
                    if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[$field][] = "Format email tidak valid.";
                        $valid = false;
                    }
                    if ($rule === 'numeric' && !is_numeric($value)) {
                        $errors[$field][] = "Kolom $field harus berupa angka.";
                        $valid = false;
                    }
                    if ($rule === 'integer' && !filter_var($value, FILTER_VALIDATE_INT)) {
                        $errors[$field][] = "Kolom $field harus berupa bilangan bulat.";
                        $valid = false;
                    }
                    if ($rule === 'min' && $value < $param) {
                        $errors[$field][] = "Kolom $field minimal bernilai $param.";
                        $valid = false;
                    }
                    if ($rule === 'max' && $value > $param) {
                        $errors[$field][] = "Kolom $field maksimal bernilai $param.";
                        $valid = false;
                    }
                    if ($rule === 'min_length' && strlen($value) < $param) {
                        $errors[$field][] = "Panjang karakter $field minimal $param.";
                        $valid = false;
                    }
                    if ($rule === 'max_length' && strlen($value) > $param) {
                        $errors[$field][] = "Panjang karakter $field maksimal $param.";
                        $valid = false;
                    }
                    if ($rule === 'in') {
                        $allowed = explode(',', $param);
                        if (!in_array($value, $allowed)) {
                            $errors[$field][] = "Nilai $field tidak valid.";
                            $valid = false;
                        }
                    }
                    if ($rule === 'unique') {
                        list($table, $column) = explode(',', $param);
                        $stmt = $db->prepare("SELECT id FROM $table WHERE $column = :val LIMIT 1");
                        $stmt->execute([':val' => $value]);
                        if ($stmt->fetch()) {
                            $errors[$field][] = "$field sudah digunakan.";
                            $valid = false;
                        }
                    }
                    if ($rule === 'confirmed' && $value !== ($data[$field . '_confirmation'] ?? null)) {
                        $errors[$field][] = "Konfirmasi $field tidak cocok.";
                        $valid = false;
                    }
                    if ($rule === 'date' && !strtotime($value)) {
                        $errors[$field][] = "Format tanggal tidak valid.";
                        $valid = false;
                    }
                    if ($rule === 'url' && !filter_var($value, FILTER_VALIDATE_URL)) {
                        $errors[$field][] = "Format URL tidak valid.";
                        $valid = false;
                    }
                    if ($rule === 'file_type' && isset($_FILES[$field]) && $_FILES[$field]['error'] !== UPLOAD_ERR_NO_FILE) {
                        $types = explode(',', $param);
                        $fileExt = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
                        if (!in_array($fileExt, $types)) {
                            $errors[$field][] = "Tipe file harus " . implode(', ', $types) . ".";
                            $valid = false;
                        }
                    }
                    if ($rule === 'file_size' && isset($_FILES[$field]) && $_FILES[$field]['error'] !== UPLOAD_ERR_NO_FILE) {
                        $maxSize = (int)$param * 1024; // KB to bytes
                        if ($_FILES[$field]['size'] > $maxSize) {
                            $errors[$field][] = "Ukuran file maksimal $param KB.";
                            $valid = false;
                        }
                    }
                }
            }
        }
        return ['valid' => $valid, 'errors' => $errors];
    }
}
