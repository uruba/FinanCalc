<?php

namespace FinanCalc\Calculators {

    use Exception;
    use FinanCalc\Constants\AnnuityPaymentTypes;
    use FinanCalc\Constants\AnnuityValueTypes;
    use FinanCalc\Constants\Defaults;
    use FinanCalc\Interfaces\Calculator\CalculatorAbstract;
    use FinanCalc\Utils\Helpers;
    use FinanCalc\Utils\MathFuncs;

    /**
     * Class AnnuityCalculator
     * @package FinanCalc\Calculators
     */
    class AnnuityCalculator extends CalculatorAbstract {

        // amount of each individual payment = 'K'
        private $annuitySinglePaymentAmount;
        // number of periods pertaining to the interest compounding = 'n'
        // if 'n = 0', the annuity is considered a perpetuity
        private $annuityNoOfCompoundingPeriods;
        // length of a single period in days
        private $annuityPeriodLength;
        // the interest rate by which the unpaid balance is multiplied (i.e., a decimal number) = 'i'
        private $annuityInterest;

        // props returned by the getResultAsArray method by default
        protected $propResultArray = [
            "annuitySinglePaymentAmount",
            "annuityNoOfCompoundingPeriods",
            "annuityInterest",
            "annuityPeriodLength" =>
                [
                    "years" => "annuityPeriodLengthInYears",
                    "months" => "annuityPeriodLengthInMonths",
                    "days" => "annuityPeriodLengthInDays"
                ],
            "annuityPresentValue" =>
                [
                    "in_advance" => "annuityPresentValueInAdvance",
                    "in_arrears" => "annuityPresentValueInArrears"
                ],
            "annuityFutureValue" =>
                [
                    "in_advance" => "annuityFutureValueInAdvance",
                    "in_arrears" => "annuityFutureValueInArrears"
                ],
        ];

        /**
         * @param $annuitySinglePaymentAmount
         * @param $annuityNoOfCompoundingPeriods
         * @param $annuityPeriodLength
         * @param $annuityInterest
         */
        function __construct($annuitySinglePaymentAmount,
                             $annuityNoOfCompoundingPeriods,
                             $annuityPeriodLength,
                             $annuityInterest) {
            $this->setAnnuitySinglePaymentAmount($annuitySinglePaymentAmount);
            $this->setAnnuityNoOfCompoundingPeriods($annuityNoOfCompoundingPeriods);
            $this->setAnnuityPeriodLength($annuityPeriodLength);
            $this->setAnnuityInterest($annuityInterest);
        }

        /**
         * @param $annuitySinglePaymentAmount
         */
        public function setAnnuitySinglePaymentAmount($annuitySinglePaymentAmount) {
            if (Helpers::checkIfPositiveNumberOrThrowAnException($annuitySinglePaymentAmount)) {
                $this->annuitySinglePaymentAmount = (string)$annuitySinglePaymentAmount;
            }
        }

        /**
         * @param $annuityNoOfCompoundingPeriods
         */
        public function setAnnuityNoOfCompoundingPeriods($annuityNoOfCompoundingPeriods) {
            if (Helpers::checkIfNotNegativeNumberOrThrowAnException($annuityNoOfCompoundingPeriods)) {
                $this->annuityNoOfCompoundingPeriods = (string)$annuityNoOfCompoundingPeriods;
            }

            if (Helpers::checkIfPositiveNumber($this->annuityPeriodLength) || Helpers::checkIfZero($this->annuityPeriodLength)
            ) {
                $this->setAnnuityPeriodLength($this->annuityPeriodLength);
            }
        }

        /**
         * @param $annuityPeriodLength
         */
        public function setAnnuityPeriodLength($annuityPeriodLength) {
            if (Helpers::checkIfNotNegativeNumberOrThrowAnException($annuityPeriodLength)) {
                if (Helpers::checkIfZero($this->annuityNoOfCompoundingPeriods)) {
                    $this->annuityPeriodLength = INF;
                } else {
                    $this->annuityPeriodLength = (string)$annuityPeriodLength;
                }
            }
        }

        /**
         * @param $annuityInterest
         */
        public function setAnnuityInterest($annuityInterest) {
            if (Helpers::checkIfPositiveNumberOrThrowAnException($annuityInterest)) {
                $this->annuityInterest = (string)$annuityInterest;
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
         * @return mixed
         */
        public function getAnnuityInterest() {
            return $this->annuityInterest;
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
         * @return null|string
         */
        public function getAnnuityPresentValueInAdvance() {
            return $this
                ->getAnnuityPresentValue(
                    new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE)
                );
        }

        /**
         * @return null|string
         */
        public function getAnnuityPresentValueInArrears() {
            return $this
                ->getAnnuityPresentValue(
                    new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS)
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
         * @return null|string
         */
        public function getAnnuityFutureValueInAdvance() {
            return $this
                ->getAnnuityFutureValue(
                    new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE)
                );
        }

        /**
         * @return null|string
         */
        public function getAnnuityFutureValueInArrears() {
            return $this->getAnnuityFutureValue(
                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS)
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

                if (isset($numerator) && isset($denominator)) {
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