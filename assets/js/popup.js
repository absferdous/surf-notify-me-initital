document.addEventListener('DOMContentLoaded', function () {
    const popup = document.getElementById('ssn-popup');
    if (popup) {
        popup.style.position = 'fixed';
        popup.style.bottom = '20px';
        popup.style.left = '20px';
        popup.style.padding = '12px 18px';
        popup.style.backgroundColor = '#1e87f0';
        popup.style.color = '#fff';
        popup.style.borderRadius = '8px';
        popup.style.boxShadow = '0 2px 8px rgba(0,0,0,0.2)';
        popup.style.zIndex = '9999';

        setTimeout(() => popup.remove(), 6000);
    }
});