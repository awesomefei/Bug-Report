<?php
class Bug{
    var $id; 
    var $priority;
    var $title;
    var $assignee_email;
    var $status;
    var $lastupdate;
    var $description;
    var $open_date;
    var $close_date;
    var $severity;
    var $comment_count;
    
    function __construct($row){
        $this->id = $row['bug_id'];
        $this->priority= $row['priority'];
        $this->title = $row['bug_title'];
        $this->assignee_id = $row['bug_assignee_id'];
        $this->status = $row['status'];
        $this->lastupdate = $row['lastupdate'];
        $this->reporter_id = $row['bug_reporter_id'];
        $this->description = $row['description'];
        $this->open_date = $row['bug_open_date'];
        $this->close_date = $row['bug_close_date'];
        $this->severity = $row['bug_severity'];
        $this->comment_count = $row['comment_count'];

    }
}

?>