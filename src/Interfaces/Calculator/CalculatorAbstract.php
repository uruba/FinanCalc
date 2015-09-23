<?php

namespace FinanCalc\Interfaces\Calculator {

    use FinanCalc\Interfaces\Serializer\SerializerInterface;

    /**
     * Interface CalculatorAbstract
     * @package FinanCalc\Interfaces
     */
    abstract class CalculatorAbstract {
        protected $propResultArray = null;

        /**
         * @param $name
         * @param $value
         * @param null $callbackBefore
         * @param null $callbackAfter
         */
        protected function setProperty($name, $value, $callbackBefore = null, $callbackAfter = null) {
            if (is_callable($callbackBefore)) {
                $callbackBefore($value);
            }

            if (is_object($value) || is_null($value)) {
                $this->$name = $value;
            } else {
                $this->$name = (string) $value;
            }

            if (is_callable($callbackAfter)) {
                $callbackAfter($value);
            }
        }

        /**
         * @param array $propResultArray
         * @return array
         */
        public function getResultAsArray(array $propResultArray = null) {
            if ($propResultArray === null) {
                if ($this->propResultArray !== null && is_array($this->propResultArray)) {
                    $propResultArray = $this->propResultArray;
                } else {
                    error_log('$propResultArray has not been supplied – neither by the argument, nor by the class field');
                    return false;
                }
            }

            $processArray = function ($inputArray) use (&$processArray) {
                $processedArray = array();
                foreach ($inputArray as $key => $prop) {
                    if (is_string($prop)) {
                        $propGetter = "get" . ucfirst($prop);
                        if (method_exists($this, $propGetter)) {
                            $processedArray[is_string($key) ? $key : $prop] = call_user_func(array($this, $propGetter));
                        } else {
                            error_log("Method '" . $propGetter . "()' doesn't exist in the class " . get_class($this));
                        }
                    }
                    if (is_array($prop)) {
                        $processedArray[$key] = $processArray($prop);
                    }
                }

                return $processedArray;
            };


            return $processArray($propResultArray);
        }

        /**
         * @param SerializerInterface $serializer
         * @return mixed
         */
        public function getSerializedResult(SerializerInterface $serializer) {
            return $serializer->serializeArray($this->getResultAsArray());
        }
    }
}
