<?php
header('HTTP/1.0 403 Forbidden');

require(__FILE__ . '/../db.php');

$character_set = '23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
$existing_strings = "";
$string_length = 8;
$number_of_strings = 300;
$codes = createRandomStringCollection($string_length, $number_of_strings, $character_set, $existing_strings);

// foreach($codes as $key => $value){
// 	$salt =  md5(uniqid());
// 	$query = "INSERT INTO codes (code, salt) VALUES ('$value', '$salt')";
// 	if(!mysql_query($query, $link)){
// 		echo mysql_error();
// 	}
// }

function createRandomString($string_length, $character_set) {
  $random_string = array();
  for ($i = 1; $i <= $string_length; $i++) {
    $rand_character = $character_set[rand(0, strlen($character_set) - 1)];
    $random_string[] = $rand_character;
  }
  shuffle($random_string);
  return implode('', $random_string);
}

function validUniqueString($string_collection, $new_string, $existing_strings='') {
  if (!strlen($string_collection) && !strlen($existing_strings))
    return true;
  $combined_strings = $string_collection . ", " . $existing_strings;
  return (strlen(strpos($combined_strings, $new_string))) ? false : true;
}

function createRandomStringCollection($string_length, $number_of_strings, $character_set, $existing_strings = '') {
  $string_collection = '';
  for ($i = 1; $i <= $number_of_strings; $i++) {
    $random_string = createRandomString($string_length, $character_set);
    while (!validUniqueString($string_collection, $random_string, $existing_strings)) {
      $random_string = createRandomString($string_length, $character_set);
    }
    $string_collection .= ( !strlen($string_collection)) ? $random_string : "," . $random_string;
  }
	$arr = explode(',', $string_collection);
  return $arr;
}

?>