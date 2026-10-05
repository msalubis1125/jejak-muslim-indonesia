<?php
// Roles
define('ROLE_SUPER_ADMIN', 'super_admin');
define('ROLE_TAKMIR', 'takmir');
define('ROLE_JAMAAH', 'jamaah');

// Statuses
define('STATUS_PENDING', 'pending');
define('STATUS_VERIFIED', 'verified');
define('STATUS_SUSPENDED', 'suspended');

// File Upload Constraints
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png']);
define('ALLOWED_IMAGE_EXTENSIONS', ['jpg', 'jpeg', 'png']);

// Rate Limiting
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_DURATION', 900); // 15 minutes
