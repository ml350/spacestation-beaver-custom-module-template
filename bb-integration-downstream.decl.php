<?php
add_action ('init', function(){
    if (class_exists("FlBuilder")) {
        require_once "bw-module-name/bw-module-name.php";
    }
}, 15);
