<?php

namespace FinanCalc\Interfaces\Serializer {

    /**
     * Interface SerializerInterface
     * @package FinanCalc\Interfaces\Serializer
     */
    interface SerializerInterface
    {

        /**
         * @param array $inputArray
         * @return mixed
         */
        public static function serializeArray(array $inputArray);
    }
}