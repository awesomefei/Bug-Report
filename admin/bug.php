<?php include "includes/admin_header.php" ?>
<?php include "includes/bug_class.php" ?>
<?php include "includes/user.php" ?>
<?php include "includes/comment.php" ?>

<div id="wrapper">
<?php include "../admin/includes/admin_navigation.php" ?>        
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <!-- Bug Table -->
                 <?php 
                    include 
                    "includes/assign_to_me_coms/single_bug_info.php" 
                ?>    
                <!-- Posted Comments -->
                <?php 
                    include 
                    "includes/assign_to_me_coms/display_comments.php" 
                ?>       

                <!-- Comments Form -->
                <?php include 
                    "includes/assign_to_me_coms/create_comment.php" 
                ?>       
            </div>
            <!-- Update Bug -->           
            <?php include "includes/assign_to_me_coms/update_bug.php" ?>             
        </div>
    </div>
</div>

<?php include "../admin/includes/admin_footer.php" ?>
