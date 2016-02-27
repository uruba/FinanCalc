<?php

namespace FinanCalc\Utils\Serializers {

    use FinanCalc\Interfaces\Serializer\SerializerInterface;

    /**
     * Class JSONSerializer
     * @package FinanCalc\Utils\Serializers
     */
    class JSONSerializer implements SerializerInterface
    {

        /**
         * @param array $inputArray
         * @return mixed
         */
        public static function serializeArray(array $inputArray)
        {
            return json_encode($inputArray, JSON_PRETTY_PRINT);
        }
    }
}