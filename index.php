<?php
error_reporting(E_ALL);
     ini_set('display_errors', 1);
/*
$data = '{
	"name": "Aragorn",
	"race": "Human"
}';

$character = json_decode($data);
echo $character->name;

$url = 'data.json'; // path to your JSON file
$data = file_get_contents($url); // put the contents of the file into a variable
$characters = json_decode($data, true); // decode the JSON feed and make an associative array
echo $characters[0]['race'];
foreach ($characters as $character) {
	echo $character['race'] . "<br>";
}

$url = 'wizards.json';
$data = file_get_contents($url);
$wizards = json_decode($data, true);

foreach ($wizards as $wizard) {
	echo '<br>' . $wizard['name'] . '\'s wand is ' .
			 $wizard['wand'][0]['wood'] . ', ' .
		   $wizard['wand'][0]['length'] . ', with a ' .
		   $wizard['wand'][0]['core'] . ' core. <br>' ;
}*/
/*
$url = 'http://api.wolframalpha.com/v2/query?appid=2RV7G5-H2Y6LK8J25&input=weather%2027/10/2015%20Tak,Thailand%20temperature%20humidinity&includepodid=Result&output=json';
$data = file_get_contents($url);
$characters = json_decode($data, true);
echo $characters['queryresult']['pods'][0]['subpods'][0]['plaintext'];
$str = $characters['queryresult']['pods'][0]['subpods'][0]['plaintext'];
print_r (explode(" ",$str));
$temperature = explode(" ",$str);
echo $temperature [7] . '<br>' . $temperature [10] . '<br>';
$humidity = explode("%",$temperature[10]);
echo $humidity[0];
*/
$readfile = fopen("CleanedDataset_Melaria.csv", "r") or die("Unable to open file!");
$writefile = fopen("final.csv", "w") or die("Unable to open file!");
fgets($readfile);
while(!feof($readfile)) {
//for($r = 0; $r < 10; $r++) {
  //echo fgets($myfile) . "<br>";
  $arrData = explode(",", fgets($readfile));

  //echo $arrData[1] . '<br>' . $arrData[2] . '<br>' . $arrData[3];

$i = 1;
$k = 13;
$writeStr = '';
 for ($i = 1; $i < 6; $i++) {
   if($arrData[$i] == '') {
     break;
   }
    $url = 'http://api.wolframalpha.com/v2/query?appid=2RV7G5-H2Y6LK8J25&input=weather%20';
    $url .= $arrData[$i] . '%20Tak,Thailand%20temperature%20humidinity&includepodid=Result&output=json';
    //echo $arrData[$i] . '<br>';
    $data = file_get_contents($url);
    $json = json_decode($data, true);
    //echo $json['queryresult']['pods'][0]['subpods'][0]['plaintext'] . '<br>';
    $temperature = explode(" ",$json['queryresult']['pods'][0]['subpods'][0]['plaintext']);
    //echo $temperature[7] . '<br>' ;
    $humidity = explode("%",$temperature[10]);
    //echo $humidity[0];
    $arrData[$i + $k] = $temperature[7];
    $k++;
    $arrData[$i + $k] = $humidity[0];


  }
  for($j = 0; $j < count($arrData); $j++) {
    if($j == count($arrData) - 1) {
      $writeStr .= $arrData[$j];
      break;
    }
    $writeStr .= $arrData[$j] . ',';
  }
  fwrite($writefile, $writeStr);

}
fclose($writefile);
fclose($readfile);


?>
