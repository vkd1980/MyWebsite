<?php 
/* 
 * number_to_word.php 
 *  
 * Copyright 2014 Hardik Kachhia 
 *  
 * This program is free software; you can redistribute it and/or modify 
 * it under the terms of the GNU General Public License as published by 
 * the Free Software Foundation; either version 2 of the License, or 
 * (at your option) any later version. 
 *  
 * This program is distributed in the hope that it will be useful, 
 * but WITHOUT ANY WARRANTY; without even the implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
 * GNU General Public License for more details. 
 *  
 * You should have received a copy of the GNU General Public License 
 * along with this program; if not, write to the Free Software 
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, 
 * MA 02110-1301, USA. 
 *  
 * This class is crate for convert number to word for india 
 * 
 * http://stackoverflow.com/users/1220955/harry 
 */ 

  

class num_to_string { 
    #code 
     
    function get_string($number){ 
         
        //A function to convert numbers into Indian readable words with Cores, Lakhs and Thousands. 
    $words = array( 
    '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five', 
    '6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten', 
    '11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fourteen','15' => 'fifteen', 
    '16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty', 
    '30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy', 
    '80' => 'eighty','90' => 'ninty'); 
     
    //First find the length of the number 
    $num_arr=explode(".",$number); 
     
    $number_length = strlen($num_arr[0]); 
    //Initialize an empty array 
    $number_array = array(0,0,0,0,0,0,0,0,0);         
    $received_number_array = array(); 
     
    //Store all received numbers into an array 
    for($i=0;$i<$number_length;$i++){    $received_number_array[$i] = substr($num_arr[0],$i,1);    } 
     
    //Populate the empty array with the numbers received - most critical operation 
    for($i=9-$number_length,$j=0;$i<9;$i++,$j++){ $number_array[$i] = $received_number_array[$j]; } 
     
    //print_r($number_array); 
    echo "<br>"; 
    $number_to_words_string = "";         
    //Finding out whether it is teen ? and then multiplying by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
    for($i=0,$j=1;$i<9;$i++,$j++){ 
        if($i==0 || $i==2 || $i==4 || $i==7){ 
            if($number_array[$i] > 0){ 
                $number_array[$j] = ($number_array[$i]*10)+$number_array[$j]; 
                $number_array[$i] = 0; 
            }         
        } 
    } 
    //print_r($number_array); 
    $value = ""; 
    for($i=0;$i<9;$i++){ 
        if($i==0 || $i==2 || $i==4 || $i==7){ 
                $value = $number_array[$i]*10;  
        } 
        else{ 
             $value = $number_array[$i];     
        }             
    //    echo "<Br>". $value; 
        if($value!=0){  
            if(array_key_exists($value,$words)) 
            { 
                $number_to_words_string.= $words["$value"]." "; 
            } 
            else 
            { 
                $num=floor($value/10); 
                $num=$num * 10; 
                $number_to_words_string.= $words["$num"]." ";     
                $num=$value%10; 
                $number_to_words_string.= $words["$num"]." "; 
            } 
         } 
        if($i==1 && $value!=0){    $number_to_words_string.= "Crores "; } 
        if($i==3 && $value!=0){    $number_to_words_string.= "Lakhs ";    } 
        if($i==5 && $value!=0){    $number_to_words_string.= "Thousand "; } 
        if($i==6 && $value!=0){    $number_to_words_string.= "Hundred "; } 
    } 
    if($number_length>9){ $number_to_words_string = "Sorry This does not support more than 99 Crores"; } 
     
    //echo $number_to_words_string; 
    if (isset($num_arr[1]) && null !== $num_arr[1] && is_numeric($num_arr[0])) { 
        $number_to_words_string .= "And "; 
        $words_fraction = array(); 
        foreach (str_split((string) $num_arr[1]) as $number) { 
            $words_fraction[] = $words[$number]; 
        } 
        $number_to_words_string .= implode(" ", $words_fraction); 
		return ucwords(strtolower($number_to_words_string)." Paise Only."); 
    } 
     
    return ucwords(strtolower($number_to_words_string)." Only."); 
    } 
} 

//$get_num_str= new num_to_string(); 
//echo $get_num_str->get_string(9999.99); 
?>