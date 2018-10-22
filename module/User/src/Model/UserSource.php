<?php

namespace User\Model;

class UserSource
{
    const USERSOURCE_TYPE_CSVFILE = 1;

    public $user_source_id;
    public $type;
    public $config;
    public $field_map;
    public $date_format;
    public $date_null;
    public $encoding;
    public $is_enabled;

    public function isJson($string){
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    public function exchangeArray($data)
    {
        $this->user_source_id = !empty($data['user_source_id']) ? $data['user_source_id'] : null;
        $this->type = !empty($data['type']) ? $data['type'] : null;
        $this->config = !empty($data['config']) ? $data['config'] : null;
        $this->config = $this->isJson($data['config']) ? json_decode($data['config']) : $data['config'];
        $this->field_map = !empty($data['field_map']) ? $data['field_map'] : null;
        $this->field_map = $this->isJson($data['field_map']) ? json_decode($data['field_map']) : $data['field_map'];
        $this->date_format = !empty($data['date_format']) ? $data['date_format'] : null;
        $this->date_null = !empty($data['date_null']) ? $data['date_null'] : null;
        $this->encoding = !empty($data['encoding']) ? $data['encoding'] : null;
        $this->is_enabled = !empty($data['is_enabled']) ? $data['is_enabled'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'user_source_id' => $this->user_source_id,
            'type' => $this->type,
            'config' => $this->config,
            'field_map' => $this->field_map,
            'date_format' => $this->date_format,
            'date_null' => $this->date_null,
            'encoding' => $this->encoding,
            'is_enabled' => $this->is_enabled,
        ];
    }

    public function getData()
    {
        if ($this->type == self::USERSOURCE_TYPE_CSVFILE) {
            return $this->processCsvFile();
        }
    }

    public function processCsvFile()
	{

        $input_dir = getcwd() .  '/data/files/input/';
        $output_dir = getcwd() .  '/data/files/processed/';

        $files = glob($input_dir . $this->config->pattern);
        rsort($files);
        $src_file = $files[0];
        $dst_file = $$output_dir . basename($src_file);

        $data = [];
        $counter = 1;
        if (($handle = fopen($src_file, "r")) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $this->config->delimiter)) !== FALSE) {

                if ($counter == 1 AND $this->config->header) {
                    $counter++;
                    continue;
                }

                $fields = get_object_vars($this->field_map);
                array_walk($fields, [$this, 'map_fields'], $row);

                $data[] = $fields;

            }

            fclose($handle);
        }


        return $data;
	}

    private function map_fields(&$value, $key, $row)
    {
        $dates = ['birthday_date', 'hiring_date', 'resignation_date'];
        $value = $this->convertEncoding($row[$value]);

        if (in_array($key, $dates)) {
            $value = $this->convertDate($value);
        }
    }

    private function convertEncoding($string)
    {
        if ($this->encoding != 'UTF-8') {
            return mb_convert_encoding($string, "UTF-8", $this->encoding);
        }
        return $string;
    }

    private function convertDate($date)
	{
		if ($date == $this->date_null) {
			return null;
		}

		$datetime = \DateTime::createFromFormat($this->date_format, $date);
		return date_format($datetime, 'Y-m-d');
	}
}
