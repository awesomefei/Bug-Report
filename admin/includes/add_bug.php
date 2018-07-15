<?php

if(isset($_POST['create_bug'])) {
    $bug_title = $_POST['bug_title'];
    
    $assignee_query="SELECT user_id FROM users WHERE user_email = '$_POST[bug_assignee_email]'";
    $bug_assignee = mysqli_query($connection, $assignee_query);  
    confirmQuery($bug_assignee);
    
    while($row = mysqli_fetch_assoc($bug_assignee)){
         $bug_assignee_id = $row['user_id'];
        }
    $bug_type = $_POST['bug_type'];
    
    $bug_description       = $_POST['bug_description'];

     $bug_reporter_id        = $_SESSION['user_id'];

    $bug_close_date         = $_POST['bug_close_date'];
    
    $bug_priority = $_POST['bug_priority'];

    $query = "INSERT INTO bug(bug_title, bug_assignee_id, bug_open_date, lastupdate, priority, bug_close_date, bug_reporter_id, description) ";

    $query .= "VALUES('{$bug_title}',{$bug_assignee_id},now(), now(),'{$bug_priority}','{$bug_close_date}', {$bug_reporter_id}, '{$bug_description}') "; 

    $create_bug_query = mysqli_query($connection, $query);  

    confirmQuery($create_bug_query);
   }    
?> 
<form action="" method="post" enctype="multipart/form-data">    
 <div class="form-group">
     <label for="title">Bug Title</label>
      <input type="text" class="form-control" name="bug_title">
</div>

<div class="form-group">
     <label for="title">Bug Assignee</label>
      <input type="text" class="form-control" name="bug_assignee_email">
</div>

<div class="form-group">
    <label for="bug_priority">Bug Priority</label>
     <select name="bug_priority" id="">
         <option value="1">1</option>
         <option value="2">2</option>
         <option value="3">3</option>
     </select>
</div>

<div class="form-group">
    <label for="related_department">Related Department </label>
     <select name="related_department" id="">
     
     <?php
        $query = "SELECT * FROM department";
        $department_query = mysqli_query($connection,$query);
        confirmQuery($department_query);
        while($row = mysqli_fetch_assoc($department_query)){
            $dep_title = $row['department_title'];
            $dep_id = $row['department_id']; 
            echo "<option value='{$dep_id}'>{$dep_title}</option>";
        }
     ?>
     </select>
             
       
</div>
 
 <div class="form-group">
    <label for="bug_type">Bug Type</label>
     <select name="bug_type" id="">
     
     <?php
        $query = "SELECT COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME = 'bug' AND COLUMN_NAME = 'bug_type'";
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
    <label for="bug_close_date">Bug Close Date</label>
    <input class="form-control" type="date" value="" id="example-date-input" name="bug_close_date">

</div>

<div class="form-group">
 <label for="post_content">Bug Description</label>
 <textarea class="form-control" name="bug_description" id="body" cols="30" rows="10">
 </textarea>
</div>
    
     
<div class="form-group">
  <input class="btn btn-primary" type="submit" name="create_bug" value="Create Bug">
</div>

  

</form>