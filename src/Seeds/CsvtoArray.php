<?php

namespace Laravolt\Indonesia\Seeds;

class CsvtoArray
{
    public function csv_to_array($filename, $header)
    {
        $delimiter = ',';
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $data = [];
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }
}
