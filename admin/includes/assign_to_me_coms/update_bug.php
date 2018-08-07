<?php
if(isset($_POST['update_bug'])){
    

    $arr = array();

    $bug_new_status = $_POST['bug_status'];
    $bug_new_priority = $_POST['bug_priority'];        
    $bug_new_severity = $_POST['bug_serverity'];
    $user_email = $_POST['user_email'];
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

    //Create comment automatically
    if(!empty($auto_comment_content)){
        create_comment($auto_comment_content, $the_bug_id,
                       $_SESSION[user_id]);
        increase_comment_query($bug_comment_count,$the_bug_id);    
        redirect("/BugReport/admin/bug.php?b_id={$the_bug_id}");
    }   
}
?>

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
                    foreach($enumList as $value) {
                        echo "<option value='{$value}'>$value</option>";
                    }
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
</div>


