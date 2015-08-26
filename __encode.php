<?php

$str = file_get_contents("tpl/interna.html");
echo mb_detect_encoding($str, mb_list_encodings(), true);

?>