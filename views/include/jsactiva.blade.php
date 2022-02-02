<script>
function jsactiva() {
     var IDr1 = document.getElementById("activa").checked;
     var IDr2 = document.getElementById("activao");
     IDr2.value = "0";
     if (IDr1) {        
        IDr2.value = "1";
     }
}
</script>