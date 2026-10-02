(() => {
    document.querySelectorAll('.flash').forEach((flash) => {
        window.setTimeout(() => {
            flash.classList.add('fade-out');
            window.setTimeout(() => flash.remove(), 280);
        }, 5000);
    });
})();
