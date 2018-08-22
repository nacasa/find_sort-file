<?php
include "exo.php";
include "emails.php";
$array = load_from_file('QCM_CUI_2019.csv');
var_dump(sort_array($array,13, false));

?>
