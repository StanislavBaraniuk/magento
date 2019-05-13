<?php

    class Baraniuk_IAI_Model_Import_Parser_Entity_CsvArrayKeeper
    {
        public $array;
        public $attributes;

        public function __construct(array $formattedArray, array $attributes)
        {
            $this->attributes = $attributes;
            $this->array = $formattedArray;
        }
    }