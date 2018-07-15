<?php include "includes/admin_header.php" ?>
<div id="wrapper">

    <!-- Navigation -->
<?php include "../admin/includes/admin_navigation.php" ?>        
        <div id="page-wrapper">
            <div class="container-fluid">

                <!-- Page Heading -->
    <div class="row">

<?php
    $targetUseremail;
    $targetFirstname;
    $targetLastname;
    $bug_comment_count;
    $bug_close_date;
    if(isset($_GET['b_id'])){
        $the_bug_id = $_GET['b_id'];
    }

    $query = "SELECT * FROM bug WHERE bug_id = $the_bug_id ";
    $select_all_bugs_query = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_all_bugs_query)){
        $bug_title = $row['bug_title'];
        $bug_description = $row['description'];
        $bug_comment_count = $row['comment_count'];
        $bug_close_date = date($row['bug_close_date']);
        //bug_reporter_id
        $bugReorterQuery="SELECT * FROM users WHERE user_id = '$row[bug_reporter_id]'";
            $select_user = mysqli_query($connection,$bugReorterQuery);
            while($row1 = mysqli_fetch_assoc($select_user)){
                 $targetUseremail = $row1['user_email'];
                 $targetFirstname = $row1['user_firstname'];
                 $targetLastname = $row1['user_lastname'];
            }
        //bug_assignee_id
//        $bug_priority = $row['priority'];
        $bug_status = $row['status'];
        $bug_lastupdate = $row['lastupdate'];
?>
                <!-- First Blog Post -->
        <div class="col-lg-2">
            <h4 class="page-header">
              ID:<?php echo $the_bug_id ?>
        </h4>
        </div>
        <div class="col-lg-6">
            <h4 class="page-header">
              Title:
               <?php
                    echo $bug_title;
                ?>
        </h4>
        </div>
        <div class="col-lg-4">
            <a href="dataAnalysis.php"><h4 class="page-header"><i class="fas fa-chart-bar fa-lg"></i>
            </a></h4>
        </div> 
    </div>
        
     <div class="row">
        <div class="col-lg-8">   
    <div class="row">
        <div class="media col-lg-10">
          <img class="align-self-start mr-3" src="../image/profile.jpg" alt="Generic placeholder image" style="width:50px;height:50px;">
          <div class="media-body">
            <h5 class="mt-0"><?php echo "Author: " . $targetFirstname . " " . $targetLastname; ?></h5>
          </div>
        </div>
        <div class="col-lg-2">
         <p><span class="glyphicon glyphicon-time"></span> 
                       <?php
                            echo $bug_lastupdate;
                        ?>
         </p>
        </div>
    </div>
        
        <p><font size="3">
            <?php
                echo nl2br($bug_description);
            ?>
        </font></p>
        <hr>
        
   <?php } ?>
                   <!-- Posted Comments -->
<?php
$bug_comment_count_show = 1;
$query = "SELECT * FROM comment WHERE bug_id = {$the_bug_id} ";
$query .= "ORDER BY comment_id DESC ";
                
$selct_comment_query = mysqli_query($connection, $query);
if(!$selct_comment_query){
    die("message is" .mysqli_error($connection));
}                
while($row = mysqli_fetch_array($selct_comment_query)){
    $comment_date = $row['comment_date'];
    $comment_content = $row['comment_content'];
    $comment_author_id = $row['user_id'];
    $userQuery = "SELECT * FROM users WHERE user_id = {$comment_author_id} ";
    $selct_user_query = mysqli_query($connection, $userQuery);
    while($row1 = mysqli_fetch_array($selct_user_query)){
        $selct_user_firstname = $row1['user_firstname'];
        $selct_user_lastname = $row1['user_lastname'];

        $selct_user_email = $row1['user_email'];
        $selct_user_Image = $row1['user_image'];

?>

   <!-- Comment -->
 <div class="row">
        <div class="media col-lg-10">
          <img class="align-self-start mr-3" src="../image/<?php
        echo $selct_user_Image
        ?>" alt="Generic placeholder image" style="width:50px;height:50px;">
          <div class="media-body">
            <h5 class="mt-0"><?php echo $selct_user_firstname . " " . $selct_user_lastname; ?>
            <a href="#">#<?php 
                echo $bug_comment_count_show++;
                ?></a>
            </h5>
          </div>
        </div>
        <div class="col-lg-2">
         <p><span class="glyphicon glyphicon-time"></span> 
               <?php
                    echo $comment_date;
                ?>
         </p>
        </div>
    </div>
    <p font="3"><?php echo $comment_content ?></p>
     <?php               
    }  
}
?>

 <!-- Blog Comments -->
<?php
if(isset($_POST['create_comment'])){
    $the_bug_id = $_GET['b_id'];
    $comment_author = $_SESSION['firstname'];
    $comment_content = $_POST['comment_content'];
    if(!empty($comment_content)){
        
        $query = "INSERT INTO comment (bug_id, user_id, comment_content, comment_date) ";
    
        $query .= "VALUES ($the_bug_id , '$_SESSION[user_id]', '{$comment_content}', now())";
        $create_comment_query = mysqli_query($connection, $query);
        if(!$create_comment_query){
            die('QUERY FAILED' . mysqli_error($connection));
        }
    $bug_comment_count_query = "UPDATE bug SET comment_count = $bug_comment_count+1 ";
    $increase_comment_query = mysqli_query($connection, $bug_comment_count_query);
    if(!$increase_comment_query){
        die('QUERY FAILED' . mysqli_error($connection));
    }
    redirect("/BugReport/admin/bug.php?b_id={$the_bug_id}");
        
    }else{
        echo"<script>alert('Bug Comment Fields cannot be empty')</script>";
    }
}

    if(isset($_POST['update_bug'])){
        $bug_pre_status = '';
        $bug_pre_priority = '';
        $bug_pre_severity = '';
        $bug_pre_assignee_id = 0;
        $targetUseremail1 = '';
        $arr = array();
        $exsiting_query = "SELECT * FROM bug WHERE bug_id = {$the_bug_id} ";
        $selected_bug_query = mysqli_query($connection, $exsiting_query);
        if(confirmQuery($selected_bug_query)){
                    echo "<h1>'hello'</h1>";
        }
        while($row = mysqli_fetch_assoc($selected_bug_query)){
            echo $bug_pre_status = $row['status'];
            echo $bug_pre_priority = $row['priority'];
            echo $bug_pre_severity = $row['bug_severity'];
            echo $bug_pre_assignee_id = $row['bug_assignee_id'];
            
            $bugAassigneeQuery="SELECT * FROM users WHERE user_id = $row[$bug_pre_assignee_id]";
            $select_user1 = mysqli_query($connection,$bugReorterQuery);
            while($row1 = mysqli_fetch_assoc($select_user1)){
                 $targetUseremail1 = $row1['user_email'];
            }            
        }
        
        $bug_status = $_POST['bug_status'];
        $bug_priority = $_POST['bug_priority'];        
        $bug_severity = $_POST['bug_serverity'];
        $user_email = $_POST['user_email'];
    //bug_assignee_id    
        $query1 = "SELECT user_id FROM users WHERE user_email = '{$user_email}'";
        $query_user_id = mysqli_query($connection,$query1);
        while($row = mysqli_fetch_assoc($query_user_id)){
                 $bug_assignee_id = $row['user_id'];   
            }

        $query = "UPDATE bug SET ";
        $query .="status = '{$bug_status}', ";
        $query .="priority = '{$bug_priority}', ";
        $query .="bug_severity = '{$bug_severity}', ";
        $query .="lastupdate = now(), ";
        $query .="bug_assignee_id = '{$bug_assignee_id}' ";
        $query .= "WHERE bug_id = {$the_bug_id} ";

        $update_bug = mysqli_query($connection,$query);
        confirmQuery($update_bug);
        
        //echo "<p class='bg-success'> Post Update. </p>";
        
        //create comment automatically
        $comment_content =$_SESSION['email'] . " changed ";
        $auto_comment_content = "";
        
        if($bug_pre_status != $bug_status){ 
                $tempString = $comment_content . "status from " . $bug_pre_status . " to". $bug_status;
                array_push($arr, $tempString);
            }
        if($bug_pre_priority != $bug_priority){
            $tempString = $comment_content . "priority from " . $bug_pre_priority. " to". $bug_priority;
            array_push($arr, $tempString);
        }
        if($bug_pre_severity != $bug_severity){
            $tempString = $comment_content . "severity from " . $bug_pre_severity . " to". $bug_severity;
            array_push($arr, $tempString);
        }
        if($bug_pre_assignee_id != $bug_assignee_id){
            $tempString = $comment_content . "asignee from " . $targetUseremail1 . " to". $user_email;
            array_push($arr, $tempString);
        }
        
        $comQuery = "INSERT INTO comment (bug_id, user_id, comment_content, comment_date) ";
        $comQuery .= "VALUES ($the_bug_id , '$_SESSION[user_id]', '{$comment_content}', now())";  
        
        for($i = 0; $i < count($arr); $i++){
            $auto_comment_content = $auto_comment_content . $arr[$i] . "\n"; 
        }
        
        if(!empty($auto_comment_content)){

            $query = "INSERT INTO comment (bug_id, user_id, comment_content, comment_date) ";

            $query .= "VALUES ($the_bug_id , '$_SESSION[user_id]', '{$auto_comment_content}', now())";
            $create_comment_query = mysqli_query($connection, $query);
            if(!$create_comment_query){
                die('QUERY FAILED' . mysqli_error($connection));
            }
            $bug_comment_count_query1 = "UPDATE bug SET comment_count = $bug_comment_count+1 ";
            $increase_comment_query1 = mysqli_query($connection, $bug_comment_count_query1);
            if(!$increase_comment_query1){
                die('QUERY FAILED' . mysqli_error($connection));
            }
            //redirect("/BugReport/admin/bug.php?b_id={$the_bug_id}");

        }else{
            echo"<script>alert('Fields cannot be empty')</script>";
        }
    }
?>                
                <!-- Comments Form -->
    <div class="well">
        <form role="form" action="" method="post">

            <div class="form-group">
                <textarea name="comment_content" class="form-control" rows="10" id="body"></textarea>

            </div>

            <button type="submit" name="create_comment" class="btn btn-primary">Send</button>
        </form>
    </div>
<hr>
</div>
           
    <div class="col-lg-4 well">
       <form role="form" action="" method="post">
        <div class="form-group">
            <label for="status">Status: </label>
            <select class="custom-select custom-select-lg mb-3" name="bug_status">
               <?php

                $query = "SELECT COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME = 'bug' AND COLUMN_NAME = 'status'";
                $bug_type_query = mysqli_query($connection,$query);
                confirmQuery($bug_type_query);
                $row = mysqli_fetch_assoc($bug_type_query);
                $enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));
                 foreach($enumList as $value)
                    echo "<option value='{$value}'>$value</option>";

                ?>
              
            </select>
        </div>  
        
        <div class="form-group">
            <label for="status">ETS: 
            <?php
                echo $bug_close_date;
            ?>
            </label>            
        </div>  
        
        <div class="form-group">
            <label for="status">Reassign to: </label>   
            <select class="custom-select custom-select-lg mb-3" name='user_email'> 
               <?php

                $query = "SELECT * FROM users";
                $user_query = mysqli_query($connection,$query);
                confirmQuery($user_query);
                while($row = mysqli_fetch_assoc($user_query)){
                    $user_email = $row[user_email];
                    echo "<option value='{$user_email}'>$user_email</option>";
                }

                ?>
            </select>         
        </div>
        
      <div class="form-group">
        <label for="status">Priority: </label>   
        <select name="bug_priority" id="">
         <option value="1">1</option>
         <option value="2">2</option>
         <option value="3">3</option>
     </select>      
        </div>    
        
         <div class="form-group">
            <label for="status">Severity: </label>   
            <select class="custom-select custom-select-lg mb-3" name="bug_serverity">
               <?php

                $query = "SELECT COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME = 'bug' AND COLUMN_NAME = 'bug_severity'";
                $bug_type_query = mysqli_query($connection,$query);
                confirmQuery($bug_type_query);
                $row = mysqli_fetch_assoc($bug_type_query);
                $enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));
                 foreach($enumList as $value)
                    echo "<option value='{$value}'>$value</option>";

                ?>
            </select>         
        </div>  
           <div class="form-group">
            <label for="status">Bloked by: </label>   
            <select class="custom-select custom-select-lg mb-3" name="">
               <?php

                $query = "SELECT * FROM users";
                $user_query = mysqli_query($connection,$query);
                confirmQuery($user_query);
                while($row = mysqli_fetch_assoc($user_query)){
                    $user_email = $row[user_email];
                    echo "<option value='{$user_email}'>$user_email</option>";
                }

                ?>
            </select>         
        </div>  
        <div class="form-group">
          <input class="btn btn-primary" type="submit" name="update_bug" value="Update Bug">
        </div>
        </form>
    </div>       
</div>
                <!-- /.row -->

</div>
            <!-- /.container-fluid -->

</div>
        <!-- /#page-wrapper -->

<?php include "../admin/includes/admin_footer.php" ?>

