/**
 * Global App JS Utilities
 */
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const sidebar = document.getElementById('sidebar');
    if (mobileMenuBtn && sidebar) {
        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    }

    // Alert/Toast auto-dismiss
    const alerts = document.querySelectorAll('.auto-dismiss');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Modal handlers
    window.openModal = function(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.querySelector('.modal-content').classList.remove('scale-95', 'opacity-0');
                modal.querySelector('.modal-content').classList.add('scale-100', 'opacity-100');
            }, 10);
        }
    };

    window.closeModal = function(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.querySelector('.modal-content').classList.remove('scale-100', 'opacity-100');
            modal.querySelector('.modal-content').classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }
    };

    // Close modal on outside click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function() {
            const modalId = this.closest('.modal-container').id;
            closeModal(modalId);
        });
    });

    // Confirm delete
    document.querySelectorAll('[data-confirm]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm(this.dataset.confirm || 'Apakah Anda yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        });
    });

    // Tab switching
    document.querySelectorAll('[data-tab]').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.dataset.tab;
            const tabGroup = this.dataset.tabGroup || 'default';
            
            // Deactivate all tabs in group
            document.querySelectorAll(`[data-tab][data-tab-group="${tabGroup}"]`).forEach(t => {
                t.classList.remove('border-primary-500', 'text-primary-600');
                t.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Hide all content in group
            document.querySelectorAll(`[data-tab-content][data-tab-group="${tabGroup}"]`).forEach(c => {
                c.classList.add('hidden');
            });
            
            // Activate current tab
            this.classList.remove('border-transparent', 'text-gray-500');
            this.classList.add('border-primary-500', 'text-primary-600');
            
            // Show target content
            document.getElementById(targetId).classList.remove('hidden');
        });
    });

    // File input preview
    document.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
        input.addEventListener('change', function() {
            const previewId = this.dataset.preview;
            const previewEl = document.getElementById(previewId);
            
            if (this.files && this.files[0] && previewEl) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewEl.tagName === 'IMG') {
                        previewEl.src = e.target.result;
                    } else {
                        previewEl.style.backgroundImage = `url(${e.target.result})`;
                    }
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
});

// Format Rupiah
window.formatRupiah = function(number) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(number);
};

// Fetch wrapper with CSRF
window.apiFetch = async function(url, options = {}) {
    // Add CSRF token if it's a mutation method
    const method = options.method ? options.method.toUpperCase() : 'GET';
    if (['POST', 'PUT', 'DELETE', 'PATCH'].includes(method)) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        
        if (!options.headers) options.headers = {};
        
        if (options.body instanceof FormData) {
            options.body.append('csrf_token', csrfToken);
        } else if (typeof options.body === 'string') {
            try {
                let data = JSON.parse(options.body);
                data.csrf_token = csrfToken;
                options.body = JSON.stringify(data);
                options.headers['Content-Type'] = 'application/json';
            } catch (e) {
                // Not JSON, perhaps URL encoded
            }
        }
    }
    
    return fetch(url, options);
};
