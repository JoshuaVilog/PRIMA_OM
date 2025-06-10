<?php 
//include "path.php";
include "config/path.php";
?>

<script src="/<?php echo $pluginFolder; ?>/js/jquery-2.1.4.min.js?v=<?php echo $generateRandomNumber; ?>"></script>

<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='/<?php echo $pluginFolder; ?>/js/jquery.mobile.custom.min.js?v=<?php echo $generateRandomNumber; ?>'>"+"<"+"/script>");
</script>
<script src="/<?php echo $pluginFolder; ?>/js/bootstrap.min.js?v=<?php echo $generateRandomNumber; ?>"></script>
<script src="/<?php echo $pluginFolder; ?>/js/select2.min.js?v=<?php echo $generateRandomNumber; ?>"></script>

<!-- ace scripts -->
<script src="/<?php echo $pluginFolder; ?>/js/ace-elements.min.js?v=<?php echo $generateRandomNumber; ?>"></script>
<script src="/<?php echo $pluginFolder; ?>/js/ace.min.js?v=<?php echo $generateRandomNumber; ?>"></script>

<!-- MAIN JS -->
<script src="/<?php echo $rootFolder; ?>/script/main.js?v=<?php echo $generateRandomNumber; ?>"></script>


<!-- <script src="/<?php echo $rootFolder; ?>/User.js?v=<?php echo $generateRandomNumber; ?>"></script> -->
<!-- <script src="/<?php echo $rootFolder; ?>/main.js?v=<?php echo $generateRandomNumber; ?>"></script> -->
<!-- <script src="/<?php echo $rootFolder; ?>/getRecords.js?v=<?php echo $generateRandomNumber; ?>"></script> -->
<!-- <script src="/<?php echo $rootFolder; ?>/validation.js?v=<?php echo $generateRandomNumber; ?>"></script> -->
<!-- <script src="/<?php echo $rootFolder; ?>/userAccess.js?v=<?php echo $generateRandomNumber; ?>"></script> -->

