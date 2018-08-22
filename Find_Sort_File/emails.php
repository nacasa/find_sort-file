<?php

/**
*   This function reads each line from the given file
*   and returns an array of all correct rows.
*
*   A correct row is a row that contains a single ';' AND a single '@'
*   EXCEPT for the first one, which is a header.
*   Each line contains an email and a mark.
*
*   @param string $filename
*
*   @return array|bool. exemple :
*   [
*       'email1' => mark1,
*       'email2' => mark2,
*       'email3' => mark3,
*       ...
*   ]
*/
function load_from_file($filename)
{//;
   if(is_file($filename))
   {
	   $file = fopen($filename, 'r');
	   $line = false;
	   $row = 0;
	   $rows = array();

	   do {
		   $line = fgets($file);
		   $has_semicolon = str_contains_char($line, ';');
		   $email = str_contains_char($line, '@');
		   if ($has_semicolon === true && $email === true) {
			   array_push($rows, trim($line));
		   }
		   $row++;
	   } while ($line !== false);
	   $rows = parse_rows($rows);
	   return $rows;
   }
}

/**
*   This function parses all rows and creates
*   an array of email and mark as key and value
*
*   @param array $rows
*
*   @return array
*/
function parse_rows($rows)
{
   $parsed = array();

   foreach ($rows as $row) {
       $exploded = explode(';', $row);
       $parsed[ $exploded[0] ] = floatval($exploded[1]);
   }

   return $parsed;
}
/**
*   This function checks if a string $str contains a given char $char
*
*   @param string $str
*   @param string $char
*
*   @return bool
*/
function str_contains_char($str, $char)
{
   for ($i = 0; $i < strlen($str); $i++) {
       if ($str[$i] === $char) {
           return true;
       }
   }
   return false;
}
