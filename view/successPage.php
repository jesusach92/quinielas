<?php
session_start();
?>
<script>
    const exito = Number(<?php echo isset($_SESSION["exito"]) ? $_SESSION["exito"] : 0; ?>);
    if (exito === 1) {
        alert("La acción fue exitosa.");
        window.location.href = "<?php echo $_SESSION["nextPage"];?>"
    } else {
        alert("La acción no fue exitosa.");
        window.location.href = "<?php echo $_SESSION["nextPage"];?>"
    }
</script>