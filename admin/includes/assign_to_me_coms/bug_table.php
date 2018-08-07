<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>
               <a href="assign_to_me.php?source=sortById">Id</a>
            </th>
            <th>
                <a href="assign_to_me.php?source=sortByPriority">
                    Priority
                </a>
            </th>
            <th>Title</th>
            <th>Reporter</th>
            <th>Assignee</th>
            <th>Status</th>
            <th>
                <a href="assign_to_me.php?source=sortByLastModifiedTime">
                    LastModified
                </a>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
            // Pageination;
            include "../dispaly_constant.php";

            $page_num = '';
            if (isset($_GET['page'])) {
                $page_num = $_GET['page'];
            }
            if ($page_num == '' || $page_num == 1){
                $each_page_display_num = 0;
            } else {
                $each_page_display_num = 
                    get_each_page_display_num(
                        $DISPLAY_PER_PAGE, $page_num);
            }

            $total_page_count = get_total_page_count($_SESSION['user_id']);
            // Query all bugs assigned to login suser
            $query = "SELECT * FROM bug WHERE bug_assignee_id 
                = $_SESSION[user_id] ";

            if (isset($_GET['source'])) {
                $source = $_GET['source'];
            } else {
                $source = '';
            }
            $query = appendSortBy($query, $source);
            $query .= "LIMIT $each_page_display_num, $DISPLAY_PER_PAGE";

            $bugs = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($bugs)) {
                $currentBug = new Bug($row);
                $user = search_user_by_id($currentBug->reporter_id); 
                $reporter_email = mysqli_fetch_assoc($user)['user_email'];

                echo "<tr>";
                echo "<td> $currentBug->id</td>";
                echo "<td> $currentBug->priority</td>";
                echo "<td><a href='bug.php?b_id=
                    {$currentBug->id}'>$currentBug->title</a></td>";
                echo "<td> $reporter_email</td>";
                echo "<td>$_SESSION[email]</td>";
                echo "<td>$currentBug->status</td>";
                echo "<td>$currentBug->lastupdate</td>";
                echo "<tr>";             
            }
        ?>
    </tbody>
</table>