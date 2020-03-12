<?php

//load composer modules
require 'vendor/autoload.php';
 
// Using Medoo namespace
use Medoo\Medoo;
 
$cliOptions = getopt('',['shalen::']);

if (isset($cliOptions['shalen'])) {
  $shaLengt =  $cliOptions['shalen'];
  echo 'Set length to '.$cliOptions['shalen'].PHP_EOL;
} else {
    echo 'Set length to default of 17. Use --shalen=17 to define length.'.PHP_EOL;
    $shaLengt = 17;
};

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

for ($i=0; $i < 50000 ; $i++) {
	echo 'record '.$i."\r";

	$cittySha = substr(hash("sha256",$i),0,$shaLengt);

    $found = $database->has("shaTable", ["sha" =>$cittySha]);

    if (!$found) {
        $database->insert("shaTable", [
            "sha" => $cittySha,
            "count" => 0,
        ]);
    } else {
        $database->update("shaTable", [
            "count[+]"=>1
        ],
          ["sha" => $cittySha]
    	);
    }
};
echo PHP_EOL;

$avg_result = $database->avg("shaTable", ["count"
        ],
          ["count[>]"=>0,
          "ORDER" => ["sha"],
        ]
      );

$sum_result = $database->sum("shaTable", ["count"
        ],
          ["count[>]"=>0,
          "ORDER" => ["sha"],
        ]
      );

echo 'Totaal dubbele records ='.$sum_result.' with avarage dubble records '.$avg_result.PHP_EOL;

?>