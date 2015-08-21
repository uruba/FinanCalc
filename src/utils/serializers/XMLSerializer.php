<?php

namespace FinanCalc\Utils\Serializers {

    use FinanCalc\Interfaces\Serializer\SerializerInterface;
    use FinanCalc\Utils\Config;

    /**
     * Class XMLSerializer
     * @package FinanCalc\Utils\Serializers
     */
    class XMLSerializer implements SerializerInterface {


        /**
         * @param array $inputArray
         * @return mixed
         *
         * inspired by http://stackoverflow.com/questions/9152176/convert-an-array-to-xml-or-json
         */
        public static function serializeArray(array $inputArray)
        {
            $domDocument = new \DOMDocument('1.0', 'UTF-8');
            $domDocument->formatOutput = true;

            $rootElem = $domDocument->createElement(
                Config::getConfigField('serializers_root_elem_name')
            );
            $domDocument->appendChild($rootElem);

            $funcArrayToXML =
                function(\DOMElement $parentNode, $inputArray)
                use ($domDocument, &$funcArrayToXML) {
                    foreach ($inputArray as $key => $value) {
                        $key = str_replace(' ', '_', $key);
                        $isValueArray = is_array($value);

                        $elem = $domDocument->createElement($key, (!$isValueArray) ? $value : null);
                        $parentNode->appendChild($elem);

                        if ($isValueArray) {
                            $funcArrayToXML($elem, $value);
                        }
                    }
                };

            $funcArrayToXML($rootElem, $inputArray);

            return $domDocument->saveXML();
        }
    }
}