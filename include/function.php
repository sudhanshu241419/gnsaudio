<?php
function validate($text){
    return htmlspecialchars(strip_tags(trim($text)));
}

?>