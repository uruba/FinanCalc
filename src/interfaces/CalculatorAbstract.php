<?php

namespace FinanCalc\Interfaces {

    use FinanCalc\Interfaces\Serializer\SerializerInterface;

    /**
     * Interface CalculatorAbstract
     * @package FinanCalc\Interfaces
     */
    abstract class CalculatorAbstract {
        public abstract function getResult();
        public abstract function getResultAsArray();

        /**
         * @param SerializerInterface $serializer
         * @return mixed
         */
        public function getSerializedResult(SerializerInterface $serializer) {
            return $serializer->serializeArray($this->getResultAsArray());
        }
    }
}
