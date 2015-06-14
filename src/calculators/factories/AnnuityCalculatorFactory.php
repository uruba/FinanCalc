<?php

namespace FinanCalc\Calculators\Factories {
    use FinanCalc\Calculators\AnnuityCalculator;
    use FinanCalc\Constants\Defaults;
    use FinanCalc\Interfaces\CalculatorFactoryAbstract;

    class AnnuityCalculatorFactory extends CalculatorFactoryAbstract {
        const MANUFACTURED_CLASS_NAME = 'FinanCalc\\Calculators\\AnnuityCalculator';

        public function newYearlyAnnuity($annuitySinglePaymentAmount, $annuityNoOfCompoundingPeriods, $annuityInterest) {
            return new AnnuityCalculator(
                $annuitySinglePaymentAmount,
                $annuityNoOfCompoundingPeriods,
                $annuityInterest,
                Defaults::LENGTH_YEAR_360_30);
        }

        public function newMonthlyAnnuity($annuitySinglePaymentAmount, $annuityNoOfCompoundingPeriods, $annuityInterest) {
            return new AnnuityCalculator(
                $annuitySinglePaymentAmount,
                $annuityNoOfCompoundingPeriods,
                $annuityInterest,
                Defaults::LENGTH_MONTH_360_30);
        }

        public function newDailyAnnuity($annuitySinglePaymentAmount, $annuityNoOfCompoundingPeriods, $annuityInterest) {
            return new AnnuityCalculator(
                $annuitySinglePaymentAmount,
                $annuityNoOfCompoundingPeriods,
                $annuityInterest,
                Defaults::LENGTH_DAY_360_30);
        }

        public function newPerpetuity($annuitySinglePaymentAmount, $annuityInterest) {
            return new AnnuityCalculator(
                $annuitySinglePaymentAmount,
                0,
                $annuityInterest);
        }
    }
}