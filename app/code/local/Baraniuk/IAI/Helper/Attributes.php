<?php

    class Baraniuk_IAI_Helper_Attributes extends Mage_Core_Helper_Abstract
    {

        /**
         * @return array Imported .csv file should to contain returned attributes
         */
        public function getRequiredAttributes()
        {

            return array('sku', 'url');
        }

        /**
         * @param array $userAttributes Attributes you wants to compare with required attributes
         * @param bool $rigidity
         *          Use TRUE for check by inputted values, FALSE if you will use required attributes as a main checker
         *          $rigidity = FALSE: $requiredAttributes = "sku", $userAttributes = "sku", "url" : return True
         *          $rigidity = TRUE: $requiredAttributes = "sku", $userAttributes = "sku", "url" : return False
         *
         * @return Baraniuk_IAI_Helper_Attributes_AttributesExist
         *          TRUE if attributes is correct, FALSE if attributes is incorrect
         */
        public function attributesExist(
            array $userAttributes,
            $rigidity = false
        ): Baraniuk_IAI_Helper_Attributes_AttributesExist {

            $requiredAttributes = $this->getRequiredAttributes();

            $checkByAttributeKit = $rigidity ? $userAttributes : $requiredAttributes;
            $checkOnAttributeKit = $rigidity ? $requiredAttributes : $userAttributes;

            $incorrectAttributes = array();

            foreach ($checkByAttributeKit as $attribute) {
                if (!in_array($attribute, $checkOnAttributeKit)) {
                    array_push($incorrectAttributes, $attribute);
                }
            }

            return new Baraniuk_IAI_Helper_Attributes_AttributesExist($incorrectAttributes);
        }

    }
