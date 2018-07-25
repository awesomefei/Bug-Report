<?php

class User{
    var $id;
    var $firstname;
    var $lastname;
    var $username;
    var $email;
    var $image;
    var $role;
    var $level;
    var $component_id;
    
     function __construct($row){
        $this->id = $row['user_id'];
        $this->firstname= $row['user_firstname'];
        $this->lastname = $row['user_lastname'];
        $this->username = $row['username'];
        $this->email = $row['user_email'];
        $this->image = $row['user_image'];
        $this->role = $row['user_role'];
        $this->level = $row['user_level'];
        $this->component_id = $row['component_id'];

     }
}

?>