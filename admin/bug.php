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
<script>
    //Dynamic Priority Option
    var priorityLen = 
        document.getElementById("bugPriority").options.length;
    var str = <?php echo json_encode($bug_pre_priority) ?>;
    for (var i = 0; i < priorityLen; i++) {
        if(document.getElementById("bugPriority").options[i].text == str){
            document.getElementById("bugPriority").options[i].selected = true;
        }
    }
    //Reassign
    var reassignLen = document.getElementById("reassign").options.length;
    var str = <?php echo json_encode($assignee_email) ?>;

    for (var i = 0; i < priorityLen; i++) {
        if(document.getElementById("reassign").options[i].text == str){
            document.getElementById("reassign").options[i].selected = true;
        }
    }
    //Dynamic Status Option
    var statusLen = document.getElementById("bugStatus").options.length;
    var str = <?php echo json_encode($bug_pre_status) ?>;
    for (var i = 0; i < statusLen; i++) {
        if(document.getElementById("bugStatus").options[i].text == str){
            document.getElementById("bugStatus").options[i].selected = true;
        }
    }
    //Dynamic Serverity Option
    var serverityLen = document.getElementById("bugServerity").options.length;
    var str = <?php echo json_encode($bug_pre_severity) ?>;
    for (var i = 0; i < serverityLen; i++) {
        if(document.getElementById("bugServerity").options[i].text == str){
            document.getElementById("bugServerity").options[i].selected = true;
        }
    }        
</script>