<?php
session_start();
?>
<script>
        alert("<?php echo $_SESSION["message"]; ?>");
        window.location.href = "<?php echo $_SESSION["nextPage"];?>"
</script>