<?php
function scrapeTable($ID, $fileext) {
    $front = DOKU_URL;
    $front = str_replace (DOKU_BASE,'',$front);
    $url =   $front. wl($ID); 

    $raw = file_get_contents($url);
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($raw));
       
    $start = strpos($content,'<table class="inline">');
    $end = strpos($content,'</table>',$start) + 8;
    $table = substr($content,$start,$end-$start);
    
    preg_match_all("|<tr(.*)</tr>|U",$table,$rows);
    
    $fp = fopen($fileext, 'w');
    $row_index=0;
    foreach ($rows[0] as $row){
        if ((strpos($row,'<th')===false))
          preg_match_all("|<td(.*)</td>|U",$row,$cells);
        else
		  preg_match_all("|<t(.*)</t(.*)>|U",$row,$cells);
		  
		$cell_index=0;
		foreach ($cells[0] as $cell) {
    		$mycells[$row_index][$cell_index] = trim(strip_tags($cell));
    		++$cell_index;
    	}
    	fputcsv($fp, $mycells[$row_index]);
    	++$row_index;
    }
    fclose($fp);
    $csv_data = array_to_csv($mycells,false);
    return $csv_data;
}

/**
* Generatting CSV formatted string from an array.
* By Sergey Gurevich.
*/
function array_to_csv($array, $header_row = true, $col_sep = ",", $row_sep = "\n", $qut = '"')
{
	if (!is_array($array) or !is_array($array[0])) return false;
	
	//Header row.
	if ($header_row)
	{
		foreach ($array[0] as $key => $val)
		{
			//Escaping quotes.
			$key = str_replace($qut, "$qut$qut", $key);
			$output .= "$col_sep$key";
		}
		$output = substr($output, 1)."\n";
	}
	//Data rows.
	foreach ($array as $key => $val)
	{
		$tmp = '';
		foreach ($val as $cell_key => $cell_val)
		{
			//Escaping quotes.
			$cell_val = str_replace($qut, "$qut$qut", $cell_val);
			$tmp .= "$col_sep$cell_val";
		}
		$output .= substr($tmp, 1).$row_sep;
	}
	
	return $output;
}
          
