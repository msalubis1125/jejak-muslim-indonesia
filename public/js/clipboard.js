/**
 * Clipboard Utilities
 */
document.addEventListener('DOMContentLoaded', function() {
    const copyButtons = document.querySelectorAll('[data-copy]');
    
    copyButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const textToCopy = this.getAttribute('data-copy');
            const originalText = this.innerHTML;
            
            // Clipboard API
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(textToCopy).then(() => {
                    showSuccess(this, originalText);
                });
            } else {
                // Fallback for older browsers
                const textArea = document.createElement("textarea");
                textArea.value = textToCopy;
                textArea.style.position = "fixed";
                textArea.style.left = "-999999px";
                textArea.style.top = "-999999px";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    showSuccess(this, originalText);
                } catch (err) {
                    console.error('Fallback: Oops, unable to copy', err);
                }
                textArea.remove();
            }
        });
    });
    
    function showSuccess(btn, originalHTML) {
        // Change button appearance
        btn.innerHTML = '<i class="fas fa-check mr-2"></i> Tersalin!';
        btn.classList.add('bg-green-100', 'text-green-700', 'border-green-200');
        btn.classList.remove('bg-gray-50', 'text-gray-700');
        
        // Show toast if container exists
        showToast('Nomor rekening berhasil disalin');
        
        // Revert after 2 seconds
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.classList.remove('bg-green-100', 'text-green-700', 'border-green-200');
            btn.classList.add('bg-gray-50', 'text-gray-700');
        }, 2000);
    }
    
    function showToast(message) {
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'fixed bottom-4 left-1/2 transform -translate-x-1/2 z-50 flex flex-col gap-2';
            document.body.appendChild(toastContainer);
        }
        
        const toast = document.createElement('div');
        toast.className = 'bg-gray-800 text-white px-4 py-2 rounded-full text-sm shadow-lg transform transition-all duration-300 translate-y-10 opacity-0 flex items-center gap-2';
        toast.innerHTML = `<i class="fas fa-info-circle text-primary-400"></i> ${message}`;
        
        toastContainer.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-y-10', 'opacity-0');
        }, 10);
        
        // Animate out
        setTimeout(() => {
            toast.classList.add('translate-y-10', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
});
