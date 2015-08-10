<?php

namespace FinanCalc\Calculators {
    use FinanCalc\Calculators\AnnuityCalculator\AnnuityInstance;
    use FinanCalc\Constants\Defaults;
    use FinanCalc\Interfaces\CalculatorInterface;

    /**
     * Class AnnuityCalculator
     * @package FinanCalc\Calculators
     */
    class AnnuityCalculator implements CalculatorInterface {
        private $annuityInstance;

        /**
         * @param $annuitySinglePaymentAmount
         * @param $annuityNoOfCompoundingPeriods
         * @param $annuityInterest
         * @param $annuityPeriodLength
         */
        function __construct($annuitySinglePaymentAmount,
                             $annuityNoOfCompoundingPeriods,
                             $annuityInterest,
                             $annuityPeriodLength = Defaults::LENGTH_YEAR_360_30) {

            $this->annuityInstance = new AnnuityInstance($annuitySinglePaymentAmount,
                                                         $annuityNoOfCompoundingPeriods,
                                                         $annuityInterest,
                                                         $annuityPeriodLength);
        }

        /**
         * @return AnnuityInstance
         */
        public function getResult()
        {
            return $this->annuityInstance;
        }
    }
}

namespace FinanCalc\Calculators\AnnuityCalculator {
    use FinanCalc\Constants\AnnuityPaymentTypes;
    use FinanCalc\Constants\AnnuityValueTypes;
    use FinanCalc\Constants\Defaults;
    use FinanCalc\Utils\Helpers;
    use FinanCalc\Utils\InvalidArgumentException;
    use FinanCalc\Utils\MathFuncs;

    /**
     * Class AnnuityInstance
     * @package FinanCalc\Calculators\AnnuityCalculator
     */
    class AnnuityInstance {

        // amount of each individual payment = 'K'
        private $annuitySinglePaymentAmount;
        // number of periods pertaining to the interest compounding = 'n'
        // if 'n = 0', the annuity is considered a perpetuity
        private $annuityNoOfCompoundingPeriods;
        // the interest rate by which the unpaid balance is multiplied (i.e., a decimal number) = 'i'
        private $annuityInterest;
        // length of a single period in days
        private $annuityPeriodLength;

        /**
         * @param $annuitySinglePaymentAmount
         * @param $annuityNoOfCompoundingPeriods
         * @param $annuityInterest
         * @param $annuityPeriodLength
         * @throws InvalidArgumentException
         */
        function __construct($annuitySinglePaymentAmount,
                             $annuityNoOfCompoundingPeriods,
                             $annuityInterest,
                             $annuityPeriodLength) {
            $this->setAnnuitySinglePaymentAmount($annuitySinglePaymentAmount);
            $this->setAnnuityNoOfCompoundingPeriods($annuityNoOfCompoundingPeriods);
            $this->setAnnuityInterest($annuityInterest);
            $this->setAnnuityPeriodLength($annuityPeriodLength);
        }

        public function setAnnuitySinglePaymentAmount($annuitySinglePaymentAmount) {
            if(Helpers::checkIfPositiveNumberOrThrowAnException($annuitySinglePaymentAmount)) {
                $this->annuitySinglePaymentAmount = $annuitySinglePaymentAmount;
            }
        }

        public function setAnnuityNoOfCompoundingPeriods($annuityNoOfCompoundingPeriods) {
            if(Helpers::checkIfNotNegativeNumberOrThrowAnException($annuityNoOfCompoundingPeriods)) {
                $this->annuityNoOfCompoundingPeriods = $annuityNoOfCompoundingPeriods;
            }

            if (
                Helpers::checkIfPositiveNumber($this->annuityPeriodLength)
                ||
                Helpers::checkIfZero($this->annuityPeriodLength)
            ) {
                $this->setAnnuityPeriodLength($this->annuityPeriodLength);
            }
        }

        public function setAnnuityInterest($annuityInterest) {
            if(Helpers::checkIfPositiveNumberOrThrowAnException($annuityInterest)) {
                $this->annuityInterest = $annuityInterest;
            }
        }

        public function setAnnuityPeriodLength($annuityPeriodLength) {
            if(Helpers::checkIfNotNegativeNumberOrThrowAnException($annuityPeriodLength)) {
                if (Helpers::checkIfZero($this->annuityNoOfCompoundingPeriods)) {
                    $this->annuityPeriodLength = INF;
                } else {
                    $this->annuityPeriodLength = $annuityPeriodLength;
                }
            }
        }

        public function getAnnuitySinglePaymentAmount() {
            return $this->annuitySinglePaymentAmount;
        }

        public function getAnnuityNoOfCompoundingPeriods() {
            return $this->annuityNoOfCompoundingPeriods;
        }

        public function getAnnuityInterest() {
            return $this->annuityInterest;
        }

        /**
         * @return string
         */
        public function getAnnuityPeriodLengthInYears() {
            return MathFuncs::div(
                $this->annuityPeriodLength,
                Defaults::LENGTH_YEAR_360_30
            );
        }

        /**
         * @return string
         */
        public function getAnnuityPeriodLengthInMonths() {
            return MathFuncs::div(
                $this->annuityPeriodLength,
                Defaults::LENGTH_MONTH_360_30
            );
        }

        public function getAnnuityPeriodLengthInDays() {
            return $this->annuityPeriodLength;
        }

        /**
         * @param AnnuityPaymentTypes $annuityType
         * @return null|string
         */
        public function getPresentValue(AnnuityPaymentTypes $annuityType = null) {
            return $this
                ->getValue(
                    $annuityType,
                    new AnnuityValueTypes(AnnuityValueTypes::PRESENT_VALUE)
                );
        }

        /**
         * @param AnnuityPaymentTypes $annuityType
         * @return null|string
         */
        public function getFutureValue(AnnuityPaymentTypes $annuityType = null) {
            return $this
                ->getValue(
                    $annuityType,
                    new AnnuityValueTypes(AnnuityValueTypes::FUTURE_VALUE)
                );
        }

        /**
         * @param AnnuityPaymentTypes $annuityPaymentType
         * @param AnnuityValueTypes $annuityValueType
         * @return null|string
         * @throws \FinanCalc\Utils\Exception
         */
        public function getValue(AnnuityPaymentTypes $annuityPaymentType = null, AnnuityValueTypes $annuityValueType) {
            // if the number of the annuity's compounding periods
            // is set to zero, we're dealing with a perpetuity
            if (Helpers::checkIfZero($this->annuityNoOfCompoundingPeriods)) {
                // we cannot calculate FV of a perpetuity, we therefore return null
                // in case such a value is demanded
                if ($annuityValueType->getValue() == AnnuityValueTypes::FUTURE_VALUE) {
                    return null;
                }

                // PV of a perpetuity = K/i
                return Helpers::roundMoneyForDisplay(
                    MathFuncs::div(
                        $this->annuitySinglePaymentAmount,
                        $this->annuityInterest)
                );
            }

            // when the annuity is not a perpetuity, we first need to check that
            // $annuityPaymentType is not null and is of a correct type
            if (
                Helpers::checkIfInstanceOfAClassOrThrowAnException($annuityPaymentType, AnnuityPaymentTypes::class)
                &&
                Helpers::checkIfInstanceOfAClassOrThrowAnException($annuityValueType, AnnuityValueTypes::class)
            ) {

                // discount factor 'v = 1/(1+i)'
                $discountFactor = MathFuncs::div(
                    1,
                    MathFuncs::add(
                        1,
                        $this->annuityInterest
                    )
                );

                if ($annuityValueType->getValue() == AnnuityValueTypes::PRESENT_VALUE) {
                   // PV numerator = 1-v^n
                   $numerator = MathFuncs::sub(
                       1,
                       MathFuncs::pow(
                           $discountFactor,
                           $this->annuityNoOfCompoundingPeriods
                       )
                   );
                } elseif ($annuityValueType->getValue() == AnnuityValueTypes::FUTURE_VALUE) {
                   // FV numerator = (1+i)^n-1
                   $numerator = MathFuncs::sub(
                       MathFuncs::pow(
                           MathFuncs::add(
                               1,
                               $this->annuityInterest
                           ),
                           $this->annuityNoOfCompoundingPeriods
                       ),
                       1
                   );
                }

                if ($annuityPaymentType->getValue() == AnnuityPaymentTypes::IN_ADVANCE) {
                   // in advance denom. = 1-v
                   $denominator = MathFuncs::sub(1, $discountFactor);
                } elseif ($annuityPaymentType->getValue() == AnnuityPaymentTypes::IN_ARREARS) {
                   // in arrears denom. = i
                   $denominator = $this->annuityInterest;
                }

                if(isset($numerator) && isset($denominator)) {
                    return Helpers::roundMoneyForDisplay(
                        // PV|FV = K*(PV|FV of unit annuity)
                        MathFuncs::mul(
                            MathFuncs::div(
                                $numerator,
                                $denominator),
                            $this->annuitySinglePaymentAmount));
                }

                return null;
            }

            return null;
        }


    }
}