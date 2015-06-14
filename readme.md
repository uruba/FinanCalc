#FinanCalc

A lightweight, simple and easy PHP library for calculating annuities (e.g., mortgages) according to various input data

## Requirements
* PHP 5.3+
* BCMath module
* PHPUnit for testing

## Features
* Annuity present and future value calculator
* Debt amortization calculator

Much more to come – including calculators for discount securities, bond valuation, duration, stock pricing...

**Please bear in mind that this is an ALPHA version containing incomplete features. The codebase is prone to drastic changes during its way out of the alpha stage.**

## Learning the ropes

### Place the library files into you directory structure

Just copy all the files somewhere appropriate, like a dedicated "vendor" or "lib" directory (so that it doesn't make a mess out of your directory hierarchy). Nothing more is needed.

### Include it in your project

The initialization is dead simple. Just include the main **FinanCalc.php** file and you are good to go!

```php
require_once dirname(__FILE__) . '/lib/FinanCalc/FinanCalc.php'; // replace the example path with yours
```

Alternatively, you can obtain the library as a package via Composer, in which case the autoloader takes care of everything for you.

### Instantiation

You have two choices as to how to instantiate the appropriate class to get your results:

#### Factory methods

Since the library automatically keeps track of pre-defined factory methods (in the namespace *FinanCalc\Calculators\Factories*), it's very easy and straightforward to utilize them.

```php
$annuityCalculatorFactory = \FinanCalc\FinanCalc
    ::getInstance()
    ->getFactory('DebtAmortizationFactory')
    ->newYearlyDebtAmortizationInArrears(
        40000,
        6,
        0.12);
```

#### Direct instantiation

The second option is to instantiate the calculator class of your choice directly by calling its constructor with appropriate parameters.

```php
$annuityCalculatorDirect = new FinanCalc\Calculators\DebtAmortizator(
        40000,
        6,
        0.12,
        360,
        new FinanCalc\Constants\AnnuityPaymentTypes(\FinanCalc\Constants\AnnuityPaymentTypes::IN_ARREARS));
```

### Getting results

It's very simple to retrieve the results. Every calculator class implementing the *CalculatorInterface* has a getter method *getResult()*, which enables you to get an appropriate object representing the result of the calculation according to the data passed earlier to the constructor/factory method of a given calculator class.

We'll demonstrate the process again on our *AnnuityCalculator* – step by step, day by day

1. step is to instantiate the appropriate calculator class, either by constructor or by a factory method (refer to the previous chapter for more information)

```php
// Instantiation by a factory method 
// – in our case we calculate a yearly-compounded annuity
// with a duration of 6 periods (here years),
// 40000 money units paid out per period
// and a compounding interest rate of 0.12 (i.e., 12%)
$annuityCalculatorObject = \FinanCalc\FinanCalc
                                ::getInstance()
                                ->getFactory('DebtAmortizationFactory')
                                ->newYearlyDebtAmortizationInArrears(
                                    40000,
                                    6,
                                    0.12);
```

2. step is to get the mentioned "result" object:

```php
$result = $annuityCalculatorObject->getResult();
```

3. step is to get the result by exploiting appropriate getter methods (for a detailed list of available gettter methods please refer to the **Reference** chapter)

```php
// get the present value of the annuity in arrears
// (as a string)
$PV = $result->getPresentValue(
                    new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS)
                );
// get the future value of the annuity in arrears
// (as a string)
$FV = $result->getFutureValue(
                    new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS)
                );
```

This concludes the process.


### Configuration

The configuration capabilities are currently very limited so there's next to nothing to tinker with.

The default configuration values are currently to be found in the "*constants/Default.php*" file, but in the future there will be a possibility to use an easily accessible JSON configuration file.

### Tests

The library includes a "*test*" subdirectory which contains all the basic tests. For your peace of mind, feel free to give them a run on your setup (provided that you have PHPUnit good and ready) and ensure that everything checks out.

The test currently cover only ~70% of the library's code so they're also a subject of necessary future improvements.

## Reference

*To be added.*

### AnnuityCalculator

*To be added.*

### DebtAmortizator

*To be added.*



