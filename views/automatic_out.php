
<body class="no-skin">
    <?php //include "partials/navbar.php";?>

    <div class="main-container ace-save-state" id="main-container">
        <script type="text/javascript">
            try{ace.settings.loadState('main-container')}catch(e){}
        </script>

        <?php //include "partials/sidebar.php";?>
        <div class="main-content">
            <div class="main-content-inner">
                <div class="page-content">
                    <h2>Automatic Out</h2>
                </div>
            </div>
        </div>
        <?php include "partials/footer.php";?>
        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>
    </div>
    <!-- JavaScript -->
    <!-- <script src="/<?php echo $rootFolder; ?>/script/Record.js?v=<?php echo $generateRandomNumber; ?>"></script> -->
    <script>
        
        setInterval(() => {

            $.ajax({
                url: 'php/controllers/Allocation/AutomaticOutAttendance.php', 
                type: 'POST',
                data:{
                    
                },
                success: function(data) {
                    
                    console.log(data);
            
                },
                error: function(err) {
                    console.log("Error:"+JSON.stringify(err));
                }
            });

        }, 600000); //10 minutues

        


    </script>

