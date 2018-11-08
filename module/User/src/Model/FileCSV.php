<?php

namespace User\Model;

class FileCSV
{
    public $type;
    public $header;
    public $pattern;
    public $delimiter;

    public function __construct($config = [])
    {
        if (! empty($config)) {
            $this->exchangeArray($config);
        }
    }

    public function exchangeArray($data)
    {
        $this->type = !empty($data['type']) ? $data['type'] : null;
        $this->header = !empty($data['header']) ? $data['header'] : null;
        $this->pattern = !empty($data['pattern']) ? $data['pattern'] : null;
        $this->delimiter = !empty($data['delimiter']) ? $data['delimiter'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'type' => $this->type,
            'header' => $this->header,
            'pattern' => $this->pattern,
            'delimiter' => $this->delimiter,
        ];
    }

    public function pull()
    {
        $input_dir = getcwd() .  '/data/files/input/';
        $output_dir = getcwd() .  '/data/files/processed/';

        $files = glob($input_dir . $this->pattern);
        rsort($files);

        $src_file = $files[0];
        $dst_file = $output_dir . basename($src_file);

        if (!copy($src_file, $dst_file)) {
            $errors = error_get_last();
            throw new \Exception($errors['message'], 1);
        }

        $data = [];
        $counter = 1;
        if (($handle = fopen($dst_file, "r")) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $this->delimiter)) !== FALSE) {

                if ($counter == 1 AND $this->header) {
                    $counter++;
                    continue;
                }

                $data[] = $row;
            }
            fclose($handle);
        }

        return $data;
    }

}
