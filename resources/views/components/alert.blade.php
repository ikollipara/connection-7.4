<script>
    window.addEventListener('success', event => {
        window.success(event.detail.message)
    });
    window.addEventListener('error', event => {
        window.error(event.detail.message)
    });
</script>
