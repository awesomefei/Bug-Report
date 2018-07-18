<?php include "includes/admin_header.php" ?>
<div id="wrapper">
        <!-- Navigation -->
<?php include "includes/admin_navigation.php" ?>        
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome
                            <small>
                        <?php
                        if(isset($_SESSION['username'])){
                            echo $_SESSION['username'];
                        }
                        ?></small>
                        </h1>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
           <th><a href="assign_to_me.php?source=sortById">Id</a></th>
            <th><a href="assign_to_me.php?source=sortByPriority">Priority</a></th>
            <th>Title</th>
            <th>Reporter</th>
            <th>Assignee</th>
            <th>Status</th>
            <th><a href="assign_to_me.php?source=sortByLastModifiedTime">LastModified</a></th>
        </tr>
    </thead>
    <tbody>
    
 <?php
$targetUserId;
$targetUseremail;
$targetUserInfo = "SELECT user_id FROM users WHERE username = '$_SESSION[username]'";

$select_targetUserId = mysqli_query($connection,$targetUserInfo);
while($row = mysqli_fetch_assoc($select_targetUserId)){
    $targetUserId = $row['user_id'];
}
//pagination
$dispay_per_page = 9;
if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = '';
}
if($page == '' ||$page == 1){
    $page1 = 0;
}else{
    $page1 = ($page * $dispay_per_page) - $dispay_per_page;
}
$bug_count = "SELECT * FROM bug WHERE bug_assignee_id = $targetUserId ";
$find_count = mysqli_query($connection,$bug_count);
$count = mysqli_num_rows($find_count);
$count = ceil($count/$dispay_per_page);
//query all bus assigned to login suser       
$query = "SELECT * FROM bug WHERE bug_assignee_id = $targetUserId ";
$query .= "ORDER BY bug_id DESC LIMIT $page1, 9";
if(isset($_GET['source'])){
    $source = $_GET['source'];
}else{
    $source = '';
}
$query = appendSortBy($query, $source);

$select_bugs = mysqli_query($connection,$query);
while($row = mysqli_fetch_assoc($select_bugs)){
    $targetBugId = $row['bug_id'];
    $targetBugPriority= $row['priority'];
    $targetBugtitle = $row['bug_title'];
    //reporter id  
    $bugReorterQuery="SELECT user_email FROM users WHERE user_id = '$row[bug_reporter_id]'";
    $select_user_firstname = mysqli_query($connection,$bugReorterQuery);
    while($row1 = mysqli_fetch_assoc($select_user_firstname)){
         $targetUseremail = $row1['user_email'];
    }
    $assigneeEmail = $_SESSION['email'];
    $targetBugStatus = $row['status'];
    $targetBugLastupdate = $row['lastupdate'];

echo "<tr>";
echo "<td> $targetBugId</td>";
echo "<td> $targetBugPriority</td>";
echo "<td><a href='bug.php?b_id={$targetBugId}'>$targetBugtitle</a></td>";
echo "<td>$targetUseremail</td>";
echo "<td>$assigneeEmail</td>";
echo "<td>$targetBugStatus</td>";
echo "<td>$targetBugLastupdate</td>";
echo "<tr>";             
    }
?>
    </tbody>
</table>

            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<ul class="pager">
<?php
for($i = 1; $i <= $count ; $i++){
    if($i == $page){
        echo "<li><a class='active_link' href='assign_to_me.php?page={$i}'>{$i}</a></li>";
    }else{
            echo "<li><a href='assign_to_me.php?page={$i}'>{$i}</a></li>";

    }
}
?>
   
</ul>
<?php include "includes/admin_footer.php" ?>

