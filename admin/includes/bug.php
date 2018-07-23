<?php
class Bug{
    var $id; 
    var $priority;
    var $bug_title;
    var $assignee_email;
    var $bug_status;
    var $bug_lastupdate;
    var $reporter_id;
    
    function __construct($row){
        $this->id = $row['bug_id'];
        $this->priority= $row['priority'];
        $this->title = $row['bug_title'];
        $this->assignee_email = $_SESSION['email'];
        $this->status = $row['status'];
        $this->lastupdate = $row['lastupdate'];
        $this->reporter_id = $row['bug_reporter_id'];
    }
}

?>