<?php

    class Baraniuk_IAI_Model_Import_Parser_Validator
    {

        private $validationFunctions =
            array(
                "sku" => "validateSku",
                "url" => "validateUrl"
            );

        public function validate(array $row): ?bool
        {
            foreach ($row as $key => $item) {

                $validationFunction =
                    isset($this->validationFunctions[ $key ]) ?
                        $this->validationFunctions[ $key ] : null;

                if ($validationFunction !== null) {
                    if (method_exists($this, $validationFunction)) {
                        return (bool) $this->{$validationFunction}($item);
                    } else {
                        return null;
                    }
                }
            }

            return null;
        }

        public function validateSku ($sku): bool {

            $product = Mage::getModel('catalog/product')->getCollection()
                ->addFieldToFilter("sku", array("eq"=>$sku));

            return !empty($product->getData());
        }

        public function validateUrl($url): bool {
            return filter_var($url, FILTER_VALIDATE_URL);
        }

    }
