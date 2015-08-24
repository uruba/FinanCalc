<?php

namespace FinanCalc\Calculators {
    use FinanCalc\Calculators\AnnuityCalculator\AnnuityInstance;
    use FinanCalc\Constants\AnnuityPaymentTypes;
    use FinanCalc\Constants\Defaults;
    use FinanCalc\Interfaces\CalculatorAbstract;

    /**
     * Class AnnuityCalculator
     * @package FinanCalc\Calculators
     */
    class AnnuityCalculator extends CalculatorAbstract {
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


        /**
         * @return array
         */
        public function getResultAsArray()
        {
            $annuityInstance = $this->getResult();

            return
                [
                    "annuitySinglePaymentAmount" => $annuityInstance->getAnnuitySinglePaymentAmount(),
                    "annuityNoOfCompoundingPeriods" => $annuityInstance->getAnnuityNoOfCompoundingPeriods(),
                    "annuityInterest" => $annuityInstance->getAnnuityInterest(),
                    "annuityPeriodLength" =>
                        [
                            "years" => $annuityInstance->getAnnuityPeriodLengthInYears(),
                            "months" => $annuityInstance->getAnnuityPeriodLengthInMonths(),
                            "days" => $annuityInstance->getAnnuityPeriodLengthInDays()
                        ],
                    "annuityPresentValue" =>
                        [
                            "in_advance" => $annuityInstance->getAnnuityPresentValue(
                                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE)
                            ),
                            "in_arrears" => $annuityInstance->getAnnuityPresentValue(
                                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS)
                            )
                        ],
                    "annuityFutureValue" =>
                        [
                            "in_advance" => $annuityInstance->getAnnuityFutureValue(
                                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE)
                            ),
                            "in_arrears" => $annuityInstance->getAnnuityFutureValue(
                                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS)
                            )
                        ],
                ];
        }
    }
}

namespace FinanCalc\Calculators\AnnuityCalculator {

    use Exception;
    use FinanCalc\Constants\AnnuityPaymentTypes;
    use FinanCalc\Constants\AnnuityValueTypes;
    use FinanCalc\Constants\Defaults;
    use FinanCalc\Utils\Helpers;
    use FinanCalc\Utils\MathFuncs;
    use InvalidArgumentException;

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

        /**
         * @param $annuitySinglePaymentAmount
         */
        public function setAnnuitySinglePaymentAmount($annuitySinglePaymentAmount) {
            if(Helpers::checkIfPositiveNumberOrThrowAnException($annuitySinglePaymentAmount)) {
                $this->annuitySinglePaymentAmount = (string)$annuitySinglePaymentAmount;
            }
        }

        /**
         * @param $annuityNoOfCompoundingPeriods
         */
        public function setAnnuityNoOfCompoundingPeriods($annuityNoOfCompoundingPeriods) {
            if(Helpers::checkIfNotNegativeNumberOrThrowAnException($annuityNoOfCompoundingPeriods)) {
                $this->annuityNoOfCompoundingPeriods = (string)$annuityNoOfCompoundingPeriods;
            }

            if (Helpers::checkIfPositiveNumber($this->annuityPeriodLength) || Helpers::checkIfZero($this->annuityPeriodLength)
            ) {
                $this->setAnnuityPeriodLength($this->annuityPeriodLength);
            }
        }

        /**
         * @param $annuityInterest
         */
        public function setAnnuityInterest($annuityInterest) {
            if(Helpers::checkIfPositiveNumberOrThrowAnException($annuityInterest)) {
                $this->annuityInterest = (string)$annuityInterest;
            }
        }

        /**
         * @param $annuityPeriodLength
         */
        public function setAnnuityPeriodLength($annuityPeriodLength) {
            if(Helpers::checkIfNotNegativeNumberOrThrowAnException($annuityPeriodLength)) {
                if (Helpers::checkIfZero($this->annuityNoOfCompoundingPeriods)) {
                    $this->annuityPeriodLength = INF;
                } else {
                    $this->annuityPeriodLength = (string)$annuityPeriodLength;
                }
            }
        }

        /**
         * @return mixed
         */
        public function getAnnuitySinglePaymentAmount() {
            return $this->annuitySinglePaymentAmount;
        }

        /**
         * @return mixed
         */
        public function getAnnuityNoOfCompoundingPeriods() {
            return $this->annuityNoOfCompoundingPeriods;
        }

        /**
         * @return mixed
         */
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

        /**
         * @return mixed
         */
        public function getAnnuityPeriodLengthInDays() {
            return MathFuncs::div(
                $this->annuityPeriodLength,
                Defaults::LENGTH_DAY_360_30
            );
        }

        /**
         * @param AnnuityPaymentTypes $annuityType
         * @return null|string
         */
        public function getAnnuityPresentValue(AnnuityPaymentTypes $annuityType = null) {
            return $this
                ->getAnnuityValue(
                    $annuityType,
                    new AnnuityValueTypes(AnnuityValueTypes::PRESENT_VALUE)
                );
        }

        /**
         * @param AnnuityPaymentTypes $annuityType
         * @return null|string
         */
        public function getAnnuityFutureValue(AnnuityPaymentTypes $annuityType = null) {
            return $this
                ->getAnnuityValue(
                    $annuityType,
                    new AnnuityValueTypes(AnnuityValueTypes::FUTURE_VALUE)
                );
        }

        /**
         * @param AnnuityPaymentTypes $annuityPaymentType
         * @param AnnuityValueTypes $annuityValueType
         * @return null|string
         * @throws Exception
         */
        public function getAnnuityValue(AnnuityPaymentTypes $annuityPaymentType = null, AnnuityValueTypes $annuityValueType) {
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