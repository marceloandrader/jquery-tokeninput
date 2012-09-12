<?php

$data = [
	['id' => 1, 'name' => 'Parent 1', 'children' => [
		['id' => 2, 'name' => '1 Child of Parent 1', 'children' => []],
		['id' => 3, 'name' => '2 Child of Parent 1', 'children' => []]
		]
		],
	['id' => 4, 'name' => 'Parent 2', 'children' => [
		['id' => 5, 'name' => '1 Child of Parent 2', 'children' => []],
		['id' => 6, 'name' => '2 Child of Parent 2', 'children' => []]
		]
	]
];

$query = $_GET['q'];
$previous = $_GET['previous'];

function search_on_tree($data, $previous, $query)
{
	$result = [];
	foreach($data as $item)
	{
		if ($previous == 0)
		{
			// not check parent_id 
			if (strstr($item['name'], $query)!==false)
				$result[] = ['id' => $item['id'], 'name' => $item['name']];
			$result = array_merge($result, search_on_tree($item['children'], $previous, $query));
		}
		elseif ($item['id'] == $previous)
		{
			$result = array_merge($result, search_on_tree($item['children'], 0, $query));
		}
	}
	return $result;
}


$arr = search_on_tree($data, intval($previous), $query);

# JSON-encode the response
$json_response = json_encode($arr);

# Optionally: Wrap the response in a callback function for JSONP cross-domain support
if(isset($_GET["callback"]) && $_GET['callback']) {
    $json_response = $_GET["callback"] . "(" . $json_response . ")";
}

# Return the response
echo $json_response;


