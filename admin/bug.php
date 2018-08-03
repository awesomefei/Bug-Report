<?php include "includes/admin_header.php" ?>
<?php include "includes/bug_class.php" ?>
<?php include "includes/user.php" ?>
<?php include "includes/comment.php" ?>


<div id="wrapper">
    <!-- Navigation -->
<?php include "../admin/includes/admin_navigation.php" ?>        
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
<!-- Display the exact bug -->
<?php
    if(isset($_GET['b_id'])){
        $the_bug_id = $_GET['b_id'];
    }

    $select_bug_query = get_bug_by_id($the_bug_id);
    while($row = mysqli_fetch_assoc($select_bug_query)){
        $current_bug = new Bug($row);
        //for javascript
        $bug_pre_status = $current_bug->status;
        $bug_pre_priority = $current_bug->priority;
        $bug_pre_severity = $current_bug->severity;
        $bug_pre_assignee_id = $current_bug->assignee_id;
        
        //get bug_reporter info by reporter_id
        $reporter_query = search_user_by_id($current_bug->reporter_id);
        while($selected_reporter_row = mysqli_fetch_assoc($reporter_query)
             ){
             $reporter = new User($selected_reporter_row);
        }
        //get bug_assignee info by assignee_id
        $selected_assignee = search_user_by_id($bug_pre_assignee_id);
        $assignee_row = mysqli_fetch_assoc($selected_assignee);
        $assignee_email = $assignee_row['user_email'];
?>
                <!-- Bug Table -->
        <div class="col-lg-2">
            <h4 class="page-header">
              ID:<?php echo $the_bug_id ?>
            </h4>
        </div>
        <div class="col-lg-7">
            <h4 class="page-header">
              Title:
               <?php
                    echo $current_bug->title;
                ?>
            </h4>
        </div>
        <div class="col-lg-3">
            <a href="dataAnalysis.php"><h4 class="page-header">
            <i class="fas fa-chart-bar fa-lg"></i>
            </a></h4>
        </div> 
    </div>
        
    <div class="row">
    <div class="col-lg-9">   
        <div class="row">
            <div class="media col-lg-9">
              <img class="align-self-start mr-3" 
              src="../image/profile.jpg" alt="Generic placeholder image" 
              style="width:50px;height:50px;">
              <div class="media-body">
                <h5 class="mt-0">
                   <?php 
                        echo "Author: " . $reporter->firstname 
                            . " " . $reporter->lastname; 
                    ?>
                </h5>
              </div>
            </div>
            <div class="col-lg-3">
             <p><span class="glyphicon glyphicon-time"></span> 
                           <?php
                                echo $current_bug->open_date;
                            ?>
             </p>
            </div>
        </div>
        
        <p><font size="3">
            <?php
                echo nl2br($current_bug->description);
            ?>
        </font></p>
        <hr>
        
   <?php } ?>
<!-- Posted Comments -->
<?php
$bug_comment_count_show = 1;
$query = "SELECT * FROM comment WHERE bug_id = {$the_bug_id} ";
$query .= "ORDER BY comment_id DESC ";
                
$comment_query = mysqli_query($connection, $query);
              
while($row = mysqli_fetch_array($comment_query)){
    $comment = new Comment($row);

    //get comment author info by user id
    $selcted_user_query = search_user_by_id($comment->user_id);
    while($selcted_user_row = mysqli_fetch_array($selcted_user_query)){
        $user = new User($selcted_user_row);

?>
<!-- Comment -->
         <div class="row">
            <div class="media col-lg-10">
              <img class="align-self-start mr-3" src="../image/<?php
            echo $user->image
            ?>" alt="Generic placeholder image" 
             style="width:50px;height:50px;">
              <div class="media-body">
                <h5 class="mt-0">
                <?php echo $user->firstname . " " . $user->lastname; ?>
                <a href="#">#<?php 
                    echo $bug_comment_count_show++;
                    ?></a>
                </h5>
              </div>
            </div>
            
            <div class="col-lg-2">
             <p><span class="glyphicon glyphicon-time"></span> 
                   <?php
                        echo $comment->comment_date;
                    ?>
             </p>
            </div>
        </div>
    <p font="3"><?php echo nl2br($comment->comment_content) ?></p>
     <?php               
    }  
}
?>

<!-- Blog Comments -->
<?php
if(isset($_POST['create_comment'])){
    $the_bug_id = $_GET['b_id'];
    $comment_content = $_POST['comment_content'];
    if(!empty($comment_content)){
       create_comment($auto_comment_content, 
                      $the_bug_id,$_SESSION[user_id]);
        increase_comment_query($bug_comment_count,$the_bug_id);    
        redirect("/BugReport/admin/bug.php?b_id={$the_bug_id}");
    }else{
        echo"<script>alert('Bug Comment Fields cannot be empty')</script>";
    }
}

if(isset($_POST['update_bug'])){
    $arr = array();

    $bug_new_status = $_POST['bug_status'];
    $bug_new_priority = $_POST['bug_priority'];        
    $bug_new_severity = $_POST['bug_serverity'];
    $user_email = $_POST['user_email'];
    
//get bug_assignee_id by user_email   

    $bug_assignee_id = get_user_id_by_email($user_email);   
    $comment_content =$_SESSION['email'] . " changed ";
    $auto_comment_content = "";

    if($current_bug->status != $bug_new_status){ 
        $tempString = $comment_content . "status from " 
            . $current_bug->status . " to ". $bug_new_status;
        array_push($arr, $tempString);
        }
    if($bug_pre_priority != $bug_new_priority){
        $tempString = $comment_content . "priority from " 
            . $bug_pre_priority. " to ". $bug_new_priority;
        array_push($arr, $tempString);
    }
    if($bug_pre_severity != $bug_new_severity){
        $tempString = $comment_content . "severity from " 
            . $bug_pre_severity . " to ". $bug_new_severity;
        array_push($arr, $tempString);
    }
    if($bug_pre_assignee_id != $bug_assignee_id){
        $tempString = $comment_content . "asignee from " 
            . $assignee_email . " to ". $user_email;
        array_push($arr, $tempString);
    }

    for($i = 0; $i < count($arr); $i++){        
        $auto_comment_content = $auto_comment_content . $arr[$i] . "\n"; 
    }
    
    if($auto_comment_content == ''){
            echo"<script>alert('Fields cannot be empty')</script>";
    }else{
        $query = "UPDATE bug SET ";
        $query .="status = '{$bug_new_status}', ";
        $query .="priority = '{$bug_new_priority}', ";
        $query .="bug_severity = '{$bug_new_severity}', ";
        $query .="lastupdate = now(), ";
        $query .="bug_assignee_id = '{$bug_assignee_id}' ";
        $query .= "WHERE bug_id = {$the_bug_id} ";
        $update_bug = mysqli_query($connection,$query);
        confirmQuery($update_bug);
        redirect("/BugReport/admin/bug.php?b_id={$the_bug_id}");
    }

//create comment automatically
    if(!empty($auto_comment_content)){
        create_comment($auto_comment_content, $the_bug_id,
                       $_SESSION[user_id]);
        increase_comment_query($bug_comment_count,$the_bug_id);    
        redirect("/BugReport/admin/bug.php?b_id={$the_bug_id}");
    }   
}
?>
                <!-- Comments Form -->
    <div class="well">
        <form role="form" action="" method="post">

            <div class="form-group">
                <textarea name="comment_content" class="form-control" 
                rows="10" id="body"></textarea>

            </div>

            <button type="submit" name="create_comment" 
            class="btn btn-primary">Send</button>
        </form>
    </div>
<hr>
</div>
           
    <div class="col-lg-3 well">
       <form role="form" action="" method="post">
        <div class="form-group">
            <label for="status">Status: </label>
            <select class="custom-select custom-select-lg mb-3" 
              name="bug_status" id="bugStatus">
               <?php
                $enumList = iterate_enum_in_table('bug', 'status');
                 foreach($enumList as $value)
                    echo "<option value='{$value}'>$value</option>";

                ?>
              
            </select>
        </div>  
        
        <div class="form-group">
            <label for="ETS">ETS: 
            <?php
                echo $current_bug->close_date;
            ?>
            </label>            
        </div>  
        
        <div class="form-group">
            <label for="status">Reassign to: </label>   
            <select class="custom-select custom-select-lg mb-3" 
              name='user_email' id="reassign"> 
               <?php
                $user_query = get_all_users();
                while($row = mysqli_fetch_assoc($user_query)){
                    $user_email = $row[user_email];
                    echo "<option value='{$user_email}'>
                    $user_email</option>";
                }
                ?>
            </select>         
        </div>
        
      <div class="form-group">
       
        <label for="status">Priority: </label>   
        <select name="bug_priority" id="bugPriority">
         <option value="1">1</option>
         <option value="2">2</option>
         <option value="3">3</option>
         </select>

      </div>
                
         <div class="form-group">
            <label for="status">Severity: </label>   
            <select class="custom-select custom-select-lg mb-3" 
              name="bug_serverity" id="bugServerity">
               <?php

                $enumList = iterate_enum_in_table('bug', 'bug_severity');
                 foreach($enumList as $value)
                    echo "<option value='{$value}'>$value</option>";
                ?>
            </select>         
        </div>  
           <div class="form-group">
            <label for="status">Bloked by: </label>   
            <select class="custom-select custom-select-lg mb-3" name="">
               <?php
                $users_query = get_all_users();
                while($row = mysqli_fetch_assoc($users_query)){
                    $user_email = $row[user_email];
                    echo "<option value='{$user_email}'>$user_email
                    </option>";
                }
 

                ?>
            </select>         
        </div>  
        <div class="form-group">
          <input class="btn btn-primary" type="submit" name="update_bug" 
          value="Update Bug" >
        </div>
   
        </form>
        <!-- Dynamic Options -->
        <script>
            //Dynamic Priority Option
            var priorityLen = 
                document.getElementById("bugPriority").options.length;
            var str = <?php echo json_encode($bug_pre_priority) ?>;
            for ( var i = 0; i < priorityLen; i++ ) {
                if(document.getElementById("bugPriority").options[i].text 
                   == str){
                    document.getElementById("bugPriority").options[i].selected = true;
                   }
            }
            //reassign
            var reassignLen = document.getElementById("reassign").options.length;
            var str = <?php echo json_encode($assignee_email) ?>;

            for ( var i = 0; i < priorityLen; i++ ) {
                if(document.getElementById("reassign").options[i].text == str){
                    document.getElementById("reassign").options[i].selected = true;
                   }
            }
            //Dynamic Status Option
            var statusLen = document.getElementById("bugStatus").options.length;
            var str = <?php echo json_encode($bug_pre_status) ?>;
            for ( var i = 0; i < statusLen; i++ ) {
                if(document.getElementById("bugStatus").options[i].text == str){
                    document.getElementById("bugStatus").options[i].selected = true;
                   }
            }
            //Dynamic Serverity Option
            var serverityLen = document.getElementById("bugServerity").options.length;
            var str = <?php echo json_encode($bug_pre_severity) ?>;
            for ( var i = 0; i < serverityLen; i++ ) {
                if(document.getElementById("bugServerity").options[i].text == str){
                    document.getElementById("bugServerity").options[i].selected = true;
                   }
            }           
        </script> 
         
    </div>
           
</div>
                <!-- /.row -->

</div>
            <!-- /.container-fluid -->

</div>
        <!-- /#page-wrapper -->

<?php include "../admin/includes/admin_footer.php" ?>

