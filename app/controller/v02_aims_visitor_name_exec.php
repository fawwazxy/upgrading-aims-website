<?php
require "../model/v02_aims_visitor_function.php";

$ic_number = $_POST['ic_number'];

$visitor_name = getVisitorByIc($ic_number)->fetch_object()->name;

echo $visitor_name;