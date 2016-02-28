<?php

namespace FinanCalc\Calculators {

    use DateTime;
    use Exception;
    use FinanCalc\Constants\AnnuityPaymentTypes;
    use FinanCalc\Constants\AnnuityValueTypes;
    use FinanCalc\Interfaces\Calculator\CalculatorAbstract;
    use FinanCalc\Utils\Helpers;
    use FinanCalc\Utils\Lambdas;
    use FinanCalc\Utils\MathFuncs;
    use FinanCalc\Utils\Time\TimeSpan;
    use FinanCalc\Utils\Time\TimeUtils;

    /**
     * Class AnnuityCalculator
     * @package FinanCalc\Calculators
     */
    class AnnuityCalculator extends CalculatorAbstract
    {

        // amount of each individual payment = 'K'
        protected $annuitySinglePaymentAmount;
        // number of periods pertaining to the interest compounding = 'n'
        // if 'n = 0', the annuity is considered a perpetuity
        protected $annuityNoOfCompoundingPeriods;
        // length of a single period as a FinanCalc\Utils\Time\TimeSpan object
        /** @var  TimeSpan */
        protected $annuityPeriodLength;
        // the interest rate by which the unpaid balance is multiplied (i.e., a decimal number) = 'i'
        protected $annuityInterest;

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
        public function __construct(
            $annuitySinglePaymentAmount,
            $annuityNoOfCompoundingPeriods,
            TimeSpan $annuityPeriodLength,
            $annuityInterest
        ) {
            $this->setAnnuitySinglePaymentAmount($annuitySinglePaymentAmount);
            $this->setAnnuityNoOfCompoundingPeriods($annuityNoOfCompoundingPeriods);
            $this->setAnnuityPeriodLength($annuityPeriodLength);
            $this->setAnnuityInterest($annuityInterest);
        }

        /**
         * @param $annuitySinglePaymentAmount
         */
        public function setAnnuitySinglePaymentAmount($annuitySinglePaymentAmount)
        {
            $this->setProperty("annuitySinglePaymentAmount", $annuitySinglePaymentAmount, Lambdas::checkIfPositive());
        }

        /**
         * @param $annuityNoOfCompoundingPeriods
         */
        public function setAnnuityNoOfCompoundingPeriods($annuityNoOfCompoundingPeriods)
        {
            $this->setProperty("annuityNoOfCompoundingPeriods", $annuityNoOfCompoundingPeriods,
                Lambdas::checkIfNotNegative());

            if ($this->annuityPeriodLength !== null) {
                $this->setAnnuityPeriodLength($this->annuityPeriodLength);
            }
        }

        /**
         * @param $annuityPeriodLength
         */
        public function setAnnuityPeriodLength(TimeSpan $annuityPeriodLength)
        {
            if (Helpers::checkIfNotNegativeNumberOrThrowAnException((string)$annuityPeriodLength)) {
                if (Helpers::checkIfZero($this->annuityNoOfCompoundingPeriods)) {
                    $annuityPeriodLength = TimeSpan::asDuration(0);
                }

                $this->setProperty("annuityPeriodLength", $annuityPeriodLength);
            }
        }

        /**
         * @param $annuityInterest
         */
        public function setAnnuityInterest($annuityInterest)
        {
            $this->setProperty("annuityInterest", $annuityInterest, Lambdas::checkIfPositive());
        }

        /**
         * @return mixed
         */
        public function getAnnuitySinglePaymentAmount()
        {
            return $this->annuitySinglePaymentAmount;
        }

        /**
         * @return mixed
         */
        public function getAnnuityNoOfCompoundingPeriods()
        {
            return $this->annuityNoOfCompoundingPeriods;
        }

        /**
         * @return TimeSpan
         */
        public function getAnnuityPeriodLength()
        {
            return $this->annuityPeriodLength;
        }

        /**
         * @return string
         */
        public function getAnnuityPeriodLengthInYears()
        {
            return $this->annuityPeriodLength->toYears();
        }

        /**
         * @return string
         */
        public function getAnnuityPeriodLengthInMonths()
        {
            return $this->annuityPeriodLength->toMonths();
        }

        /**
         * @return string
         */
        public function getAnnuityPeriodLengthInDays()
        {
            return $this->annuityPeriodLength->toDays();
        }

        /**
         * @return mixed
         */
        public function getAnnuityInterest()
        {
            return $this->annuityInterest;
        }

        /**
         * @return string
         * @throws Exception
         */
        public function getAnnuityLengthInYears()
        {
            return MathFuncs::div(
                $this->getAnnuityLengthInDays(),
                TimeUtils::getCurrentDayCountConvention()['days_in_a_year']
            );
        }

        /**
         * @return string
         * @throws Exception
         */
        public function getAnnuityLengthInMonths()
        {
            return MathFuncs::div(
                $this->getAnnuityLengthInDays(),
                TimeUtils::getCurrentDayCountConvention()['days_in_a_month']
            );
        }

        /**
         * @return string
         */
        public function getAnnuityLengthInDays()
        {
            return MathFuncs::mul(
                $this->annuityNoOfCompoundingPeriods,
                $this->annuityPeriodLength->toDays()
            );
        }

        /**
         * @param DateTime $startDate
         * @return DateTime
         */
        public function getAnnuityEndDate(DateTime $startDate)
        {
            return TimeSpan
                ::asDurationWithStartDate($startDate, 0, 0, (int)$this->getAnnuityLengthInDays())
                ->getEndDate();
        }

        /**
         * @param AnnuityPaymentTypes $annuityType
         * @return null|string
         */
        public function getAnnuityPresentValue(AnnuityPaymentTypes $annuityType = null)
        {
            return $this
                ->getAnnuityValue(
                    $annuityType,
                    new AnnuityValueTypes(AnnuityValueTypes::PRESENT_VALUE)
                );
        }

        /**
         * @return null|string
         */
        public function getAnnuityPresentValueInAdvance()
        {
            return $this
                ->getAnnuityPresentValue(
                    new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE)
                );
        }

        /**
         * @return null|string
         */
        public function getAnnuityPresentValueInArrears()
        {
            return $this
                ->getAnnuityPresentValue(
                    new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS)
                );
        }

        /**
         * @param AnnuityPaymentTypes $annuityType
         * @return null|string
         */
        public function getAnnuityFutureValue(AnnuityPaymentTypes $annuityType = null)
        {
            return $this
                ->getAnnuityValue(
                    $annuityType,
                    new AnnuityValueTypes(AnnuityValueTypes::FUTURE_VALUE)
                );
        }

        /**
         * @return null|string
         */
        public function getAnnuityFutureValueInAdvance()
        {
            return $this
                ->getAnnuityFutureValue(
                    new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE)
                );
        }

        /**
         * @return null|string
         */
        public function getAnnuityFutureValueInArrears()
        {
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
        public function getAnnuityValue(
            AnnuityPaymentTypes $annuityPaymentType = null,
            AnnuityValueTypes $annuityValueType
        ) {
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
            // the $annuityPaymentType is not null
            if (Helpers::checkIfNotNull($annuityPaymentType)) {

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
                    return
                        // PV|FV = K*(PV|FV of unit annuity)
                        MathFuncs::mul(
                            MathFuncs::div(
                                $numerator,
                                $denominator),
                            $this->annuitySinglePaymentAmount);
                }
            }

            return null;
        }
    }
}
