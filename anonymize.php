<?php

//load composer modules
require 'vendor/autoload.php';
 
// Using Medoo namespace
use Medoo\Medoo;
 

//connect to database Sqlite
$database = new Medoo([
	'database_type' => 'sqlite',
	//'database_file' => 'sha_database.db',
	'database_file' => ':memory:'
]);

//drop table 
$database->drop("shaTable");

//Create table if not exits
$database->create("shaTable", [
	"sha" => [
		"VARCHAR(17)",
		"NOT NULL",
		"PRIMARY KEY"
	],
	"count" => [
		"INTEGER",
	]]);

echo 'Start  '.date("h:i:sa").PHP_EOL;

for ($i=0; $i < 5000 ; $i++) {
	echo 'record '.$i."\r";

	$cittySha = substr(hash("sha256",$i),0,17);

    $found = $database->has("shaTable", ["sha" =>$cittySha]);

    if (!$found) {
        $database->insert("shaTable", [
            "sha" => $cittySha,
            "count" => 0,
        ]);
    } else {
    	//echo 'Found sha, add +1 - '.$cittySha.PHP_EOL;
        $database->update("shaTable", [
            "count[+]"=>1
        ],
          ["sha" => $cittySha]
    	);
    }
};
echo PHP_EOL;
// calculate all double 
$result = $database->select("shaTable", ["sha",	"count"
        ],
          ["count[>]"=>0,
          "ORDER" => ["sha"],
  			]
    	);


foreach ($result as $row) {
	echo $row['sha'].' has '.$row['count'].PHP_EOL;
	$total +=	$row['count'];
};

echo 'Totaal dubbele records ='.$total.PHP_EOL;

?>