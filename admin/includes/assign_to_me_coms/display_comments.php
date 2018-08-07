<?php
$bug_comment_count_show = 1;
$query = "SELECT * FROM comment WHERE bug_id = {$the_bug_id} ";
$query .= "ORDER BY comment_id DESC ";
                
$comment_query = mysqli_query($connection, $query);
              
while($row = mysqli_fetch_array($comment_query)){
    $comment = new Comment($row);

    $selcted_user_query = search_user_by_id($comment->user_id);
    while($selcted_user_row = mysqli_fetch_array($selcted_user_query)){
        $user = new User($selcted_user_row);

?>
<div class="row">
    <div class="media col-lg-10">
      <img class="align-self-start mr-3" src="../image/
      <?php echo $user->image ?>" alt="Generic placeholder image" 
          style="width:50px;height:50px;">
      <div class="media-body">
        <h5 class="mt-0">
            <?php echo $user->firstname . " " . $user->lastname; ?>
            <a href="#">#<?php echo $bug_comment_count_show++;?>
            </a>
        </h5>
      </div>
    </div>

    <div class="col-lg-2">
        <p><span class="glyphicon glyphicon-time"></span> 
           <?php echo $comment->comment_date;?>
        </p>
    </div>
</div>
<p font="3"><?php echo nl2br($comment->comment_content) ?></p>
<?php               
    }  
}
?>