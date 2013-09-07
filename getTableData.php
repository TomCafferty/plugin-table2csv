<?php
function scrapeTable2Csv($dokuPageId, $fileext, $startMarker) {

    $csv_data = '';
    $file = wikiFN($dokuPageId);
    $data = io_readWikiPage($file, $dokuPageId, $rev=false);
    $raw = p_render('xhtml',p_get_instructions($data),$info);
    if ($raw == false) {
        msg(sprintf('Failed to read page ' . $dokuPageId));
       return false;
    }
   
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($raw));
       
    $start = strpos($content,$startMarker);
    $content = substr($content,$start);
 
    $start = strpos($content,'<table ');
    $end = strpos($content,'</table>',$start) + 8;
    $table = substr($content,$start,$end-$start);
    
    preg_match_all("|<tr(.*)</tr>|U",$table,$rows);
    
    $fp = @fopen($fileext, 'w');
    if ($fp === false) {
       msg(sprintf('Failed to open write file ' . $fileext));
       return false;
    }
    $row_index=0;
    $numHeadings = 0;
    foreach ($rows[0] as $row){
        if ((strpos($row,'<th')===false))
          preg_match_all("|<td(.*)</td>|U",$row,$cells);
        else
		  $numHeadings = preg_match_all("|<t(.*)</t(.*)>|U",$row,$cells);
    	if ($row_index == 0) 
    	  $numCols = $numHeadings;
		  
		$cell_index=0;
		foreach ($cells[0] as $cell) {
    		$mycells[$row_index][$cell_index] = trim(strip_tags($cell));
    		++$cell_index;
    	}
    	if ($mycells[$row_index] != '') {
    	fputcsv($fp, $mycells[$row_index]);
        	$csv_data .= strput2csv($mycells[$row_index], $numCols-1);
        }
    	++$row_index;
    }
    fclose($fp);
    return $csv_data;
}

    function strput2csv($fields = array(), $numheadings, $delimiter = ',', $enclosure = '"') {
        $i = 0;
        $csvline = '';
        $escape_char = '\\';
        $field_cnt = count($fields)-1;
        $enc_is_quote = in_array($enclosure, array('"',"'"));
        reset($fields);

        foreach( $fields AS $field ) {
            /* enclose a field that contains a delimiter, an enclosure character, or a newline */
            if( is_string($field) && (
                strpos($field, $delimiter)!==false ||
                strpos($field, $enclosure)!==false ||
                strpos($field, $escape_char)!==false ||
                strpos($field, "\n")!==false ||
                strpos($field, "\r")!==false ||
                strpos($field, "\t")!==false ||
                strpos($field, ' ')!==false ) ) {

                $field_len = strlen($field);
                $escaped = 0;
                $csvline .= $enclosure;
                for( $ch = 0; $ch < $field_len; $ch++ )    {
                    if( $field[$ch] == $escape_char && $field[$ch+1] == $enclosure && $enc_is_quote ) {
                        continue;
                    }elseif( $field[$ch] == $escape_char ) {
                        $escaped = 1;
                    }elseif( !$escaped && $field[$ch] == $enclosure ) {
                        $csvline .= $enclosure;
                    }else{
                        $escaped = 0;
                    }
                    $csvline .= $field[$ch];
                }
                $csvline .= $enclosure;
            } else {
                $csvline .= $field;
            }
            if( $i++ != $field_cnt ) {
                $csvline .= $delimiter;
            }
        }
		if ($field_cnt < $numheadings) {
    		for ($i=$field_cnt+1; $i<=$numheadings;  $i++) {
        		$csvline .= $delimiter;
		}
	}
	
        $csvline .= "\n";
        return $csvline;
}
