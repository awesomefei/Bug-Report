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