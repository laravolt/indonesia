<?php

namespace Laravolt\Indonesia\Seeds;

class CsvtoArray
{
	function csv_to_array($filename='', $header)
    {
        $delimiter=',';
        if(!file_exists($filename) || !is_readable($filename))
            return FALSE;
     
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        
        return $data;
    }

}