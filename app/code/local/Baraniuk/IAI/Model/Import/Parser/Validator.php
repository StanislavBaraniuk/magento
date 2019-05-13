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

        /**
         * @param array $userAttributes Attributes you wants to compare with required attributes
         * @param bool $rigidity
         *          Use TRUE for check by inputted values, FALSE if you will use required attributes as a main checker
         *          $rigidity = FALSE: $requiredAttributes = "sku", $userAttributes = "sku", "url" : return True
         *          $rigidity = TRUE: $requiredAttributes = "sku", $userAttributes = "sku", "url" : return False
         *
         * @return Baraniuk_IAI_Model_Import_Parser_Validator_Entity_AttributesExist
         *          TRUE if attributes is correct, FALSE if attributes is incorrect
         */
//        public function attributesExist(
//            array $userAttributes,
//            array $requiredAttributes,
//            $rigidity = false
//        ): Baraniuk_IAI_Model_Import_Parser_Validator_Entity_AttributesExist {
//
//            $checkByAttributeKit = $rigidity ? $userAttributes : $requiredAttributes;
//            $checkOnAttributeKit = $rigidity ? $requiredAttributes : $userAttributes;
//
//            $incorrectAttributes = array();
//
//            foreach ($checkByAttributeKit as $attribute) {
//                if (!in_array($attribute, $checkOnAttributeKit)) {
//                    array_push($incorrectAttributes, $attribute);
//                }
//            }
//
//            return new Baraniuk_IAI_Model_Import_Parser_Validator_Entity_AttributesExist($incorrectAttributes, $requiredAttributes);
//        }

        public function validateSku ($sku): bool {

            $product = Mage::getModel('catalog/product')->getCollection()
                ->addFieldToFilter("sku", array("eq"=>$sku));

            return !empty($product->getData());
        }

        public function validateUrl($url): bool {
            return filter_var($url, FILTER_VALIDATE_URL);
        }

    }
