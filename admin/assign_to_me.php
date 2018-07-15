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
                            Welcome to Admin
                            <small><?php
                        if(isset($_SESSION['username'])){
                            echo $_SESSION['username'];
                        }
                        ?></small>
                        </h1>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
           <th>Id</th>
            <th>Priority</th>
            <th>Title</th>
            <th>Reporter</th>
            <th>Assignee</th>
            <th>Status</th>
            <th>LastModified</th>
            
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
        $query = "SELECT * FROM bug WHERE bug_assignee_id = $targetUserId";
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
        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php" ?>

