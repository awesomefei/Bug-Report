<?php

class Comment{
    var $comment_id;
    var $bug_id;
    var $user_id;
    var $comment_content;
    var $comment_date;
    var $image;
    var $role;
    var $level;
    var $component_id;
    
     function __construct($row){
        $this->comment_id = $row['comment_id'];
        $this->bug_id= $row['bug_id'];
        $this->user_id = $row['user_id'];
        $this->comment_content = $row['comment_content'];
        $this->comment_date = $row['comment_date'];
     }
}

?>