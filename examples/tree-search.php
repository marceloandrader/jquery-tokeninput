<?php

$query = $_GET['q'];

$arr = [['id' => rand(1,100), 'name' => $query]];

# JSON-encode the response
$json_response = json_encode($arr);

# Optionally: Wrap the response in a callback function for JSONP cross-domain support
if(isset($_GET["callback"]) && $_GET['callback']) {
    $json_response = $_GET["callback"] . "(" . $json_response . ")";
}

# Return the response
echo $json_response;


