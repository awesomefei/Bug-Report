<?php
    if(isset($_POST['create_comment'])){
        $the_bug_id = $_GET['b_id'];
        $comment_content = $_POST['comment_content'];
        if(!empty($comment_content)){
           create_comment($comment_content, 
                          $the_bug_id,$_SESSION[user_id]);

            increase_comment_query($bug_comment_count,$the_bug_id);    
            redirect("/BugReport/admin/bug.php?b_id={$the_bug_id}");
        }else{
            echo"<script>alert('Bug Comment Fields cannot be empty')</script>";
        }
    }
?>

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
