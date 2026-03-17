</div><!-- end .app-container -->

<script>
    function formatRupiah(angka) { return 'Rp' + Number(angka).toLocaleString('id-ID'); }
    function escHtml(str) { if (!str) return ''; var d=document.createElement('div'); d.appendChild(document.createTextNode(str)); return d.innerHTML; }
</script>
</body>
</html>
