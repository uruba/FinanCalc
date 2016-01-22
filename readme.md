#FinanCalc

A lightweight, simple and easy PHP library for calculating annuities (e.g., mortgages) and other financial instruments according to various input data.

[![Composer package](https://img.shields.io/packagist/v/uruba/financalc.svg)](https://packagist.org/packages/uruba/financalc)
[![Build Status](https://travis-ci.org/uruba/FinanCalc.svg?branch=master)](https://travis-ci.org/uruba/FinanCalc)
[![codecov.io](http://codecov.io/github/uruba/FinanCalc/coverage.svg?branch=master)](http://codecov.io/github/uruba/FinanCalc?branch=master)

## Requirements
* PHP 5.4+
* BCMath module

Optional:
* PHPUnit (*for testing*)

## Features
* Simple interest calculator
* Simple discount calculator
* Annuity present and future value calculator
* Debt amortization calculator
* Bond fair value calculator
* Bond Yield-to-Maturity (YTM) calculator
* Bond duration calculator
* Dividend Discount Model (DDM) calculator
* Investment ratios calculator for stocks/shares

Much more to come – including calculators for discount securities *(NOTE: can now be calculated with help of the simple discount calculator)*, ~~bond valuation~~, ~~duration~~, ~~stock pricing~~...
Also looking into other optimizations and improvements. Current hot ideas:
* ~~utilization of reflection in the getters of the calculators' result array for easier and less error-prone implementation of new calculator classes~~ (this has already been tackled by the means of utilizing a helper array of property names)
* ~~time functions for determining the exact dates of events pertaining to calculated instruments~~ (implemented via a TimeSpan object and appropriate getter methods in applicable classes)
* ability to create unpopulated calculator objects (which can then be populated via setters), obviating the need to pass in all the data via constructor and thus providing more flexibility
* support for various day count conventions (this has been in consideration from the jump but it has not been implemented yet)
* better modularity with a straightforward and easy-to-understand workflow (~ a plugin system)
* deserializers (as a part of an I/O package)

>**Please bear in mind that this is an ALPHA version containing incomplete features. The codebase is prone to drastic changes during its way out of the alpha stage.**

## Learning the ropes

### Place the library files into your directory structure

Just copy all the files somewhere appropriate, like a dedicated "*vendor*" or "*lib*" directory (so that it doesn't make a mess out of your directory hierarchy). Nothing more is needed.

Alternatively, you can obtain the library as a package via Composer. It's hosted on [Packagist](https://packagist.org/packages/uruba/financalc)

### Include it in your project

The initialization is dead simple. Just include the **init.php** file in the main directory and you are good to go!

```php
// replace the example Composer-bound path with yours
require_once 'vendor/uruba/financalc/init.php';
```

Or, if you are using Composer, you can use its `autoload.php` file instead.

```php
require_once 'vendor/autoload.php';
```

### Instantiation

You have two choices as to how to instantiate the appropriate class to get your results:

#### Factory methods

Since the library automatically keeps track of pre-defined factory methods (contained in the classes which are members of the namespace *FinanCalc\Calculators\Factories*), it's very easy and straightforward to utilize them.

From the main *FinanCalc* object (whose instance you get by calling its static method *getInstance()*) you have to call the *getFactory()* method, which takes in the name of the factory class as a parameter of type *string* (you can find all the included factory classes in the *src/calculators/factories* directory).

This method yields you the final calculator object on which you can call the appropriate methods to retrieve your results (as described in the next chapter) or change the input parameters via its setters.

```php
use FinanCalc\FinanCalc;

...

$annuityCalculatorFactory = FinanCalc
    ::getInstance()
    ->getFactory('DebtAmortizatorFactory')
    ->newYearlyDebtAmortization(
        40000,
        6,
        0.12);
```

#### Direct instantiation

The second option is to instantiate the calculator class of your choice directly by calling its constructor with appropriate parameters (you can find all the included calculator classes in the *src/calculators* directory).

```php
use FinanCalc\Calculators\DebtAmortizator;
use FinanCalc\Utils\Time\TimeUtils;

...

$annuityCalculatorDirect = new DebtAmortizator(
                                       40000,
                                       6,
                                       TimeSpan::asDuration(1),
                                       0.12);
```

### Getting results

You have three options of retrieving raw results of the calculations.

#### Directly accessible result object

It's very simple to retrieve the results just by calling the appropriate getter methods. ~~Every calculator class implementing the *CalculatorAbstract* has a getter method `getResult()`, which enables you to get an appropriate object representing the result of the calculation according to the data passed earlier to the constructor/factory method of a given calculator class~~ *(this intermediate step is unneeded since the version 0.3.0, please update your code by removing the calls of the getResult() method if you're upgrading from any of the earlier versions)*.

We'll demonstrate the process on our *AnnuityCalculator* – step by step, day by day:

1. step is to instantiate the appropriate calculator class, either by constructor or by a factory method (refer to the previous chapter for more information)

    ```php
    use FinanCalc\FinanCalc;
    
    ...
    
    // Instantiation by a factory method 
    // – 
    // in our case we calculate a yearly-compounded annuity
    // with a duration of 5 periods (here years),
    // 100000 money units paid out per period
    // and a compounding interest rate of 0.15 (i.e., 15%)
    $annuityCalculatorObject = FinanCalc
                                    ::getInstance()
                                    ->getFactory('AnnuityCalculatorFactory')
                                    ->newYearlyAnnuity(
                                        100000, 
                                        5, 
                                        0.15);
    ```

2. step is to get the desired value by exploiting appropriate getter methods (for a detailed list of available gettter methods please refer to the **Reference** chapter)

    ```php
    // get the present value of the annuity in arrears
    // (as a string)
    $PV = $annuityCalculatorObject->getPresentValue(
                        new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS)
                    );
    // get the future value of the annuity in arrears
    // (as a string)
    $FV = $annuityCalculatorObject->getFutureValue(
                        new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS)
                    );
    ```

Therewith the process is concluded and you can now use the obtained results in any way you see fit.

#### Serialized output

If you want to get the marshaled object representation of the result, you can utilize the built-in `getSerializedResult(SerializerInterface $serializer)` which is implemented in the base abstract class from which every calculator class inherits. You just have to pass a serializer object (i.e., one which implements the *SerializerInterface* interface).

We'll again demonstrate the process on our venerable *AnnuityCalculator* using the *XMLSerializer*:

1. step is the same – instantiate the appropriate calculator class, either by constructor or by a factory method (refer to the previous chapter for more information)

    ```php
    use FinanCalc\FinanCalc;
    use FinanCalc\Utils\Serializers\XMLSerializer;

    ...

    // Instantiation by a factory method
    // –
    // in our case we calculate a yearly-compounded annuity
    // with a duration of 5 periods (here years),
    // 100000 money units paid out per period
    // and a compounding interest rate of 0.15 (i.e., 15%)
    $annuityCalculatorObject = FinanCalc
                                    ::getInstance()
                                    ->getFactory('AnnuityCalculatorFactory')
                                    ->newYearlyAnnuity(
                                        100000,
                                        5,
                                        0.15);
    ```

2. step is to get the serialized result object

    ```php
    $result = $annuityCalculatorObject->getSerializedResult(new XMLSerializer());
    ```

3. now we have the comprehensive representation of the result object in the target format. In our example it looks like this:

    ```xml
    <?xml version="1.0" encoding="UTF-8"?>
    <root>
      <annuitySinglePaymentAmount>100000</annuitySinglePaymentAmount>
      <annuityNoOfCompoundingPeriods>5</annuityNoOfCompoundingPeriods>
      <annuityInterest>0.15</annuityInterest>
      <annuityPeriodLength>
        <years>1.00000000</years>
        <months>12.00000000</months>
        <days>360.00000000</days>
      </annuityPeriodLength>
      <annuityPresentValue>
        <in_advance>385497.83</in_advance>
        <in_arrears>335215.53</in_arrears>
      </annuityPresentValue>
      <annuityFutureValue>
        <in_advance>775373.79</in_advance>
        <in_arrears>674238.12</in_arrears>
      </annuityFutureValue>
    </root>
    ```

NOTE: The name of the "root" element in the XML output can be customized by the config property `serializers_root_elem_name`. In the future, it will be automatically assigned according to the type of the result object.

You can easily create your own serializer classes by implementing the *SerializerInterface*. A minimal example of a serializer (in this particular demonstrative case to the YAML format) is here – [FinanCalc-YAMLSerializer](https://github.com/uruba/FinanCalc-YAMLSerializer).

#### Array

You can also get a result's representation as an array. This representation is primarily used to pass the calculator object's properties to a serializer. The output should therefore be equivalent except for the semantic representation. It also enables you to easily implement your own serializer classes.

Let's demonstrate the process for the last time on our *AnnuityCalculator*:

1. step is the same – instantiate the appropriate calculator class, either by constructor or by a factory method (refer to the previous chapter for more information)

    ```php
    use FinanCalc\FinanCalc;

    ...

    // Instantiation by a factory method
    // –
    // in our case we calculate a yearly-compounded annuity
    // with a duration of 5 periods (here years),
    // 100000 money units paid out per period
    // and a compounding interest rate of 0.15 (i.e., 15%)
    $annuityCalculatorObject = FinanCalc
                                    ::getInstance()
                                    ->getFactory('AnnuityCalculatorFactory')
                                    ->newYearlyAnnuity(
                                        100000,
                                        5,
                                        0.15);
    ```

2. step is to get the result array

    ```php
    $result = $annuityCalculatorObject->getResultAsArray();
    ```

3. the result array will look like this (the "var_export" representation):

    ```php
    array (
      'annuitySinglePaymentAmount' => '100000',
      'annuityNoOfCompoundingPeriods' => '5',
      'annuityInterest' => '0.15',
      'annuityPeriodLength' =>
      array (
        'years' => '1.00000000',
        'months' => '12.00000000',
        'days' => '360.00000000',
      ),
      'annuityPresentValue' =>
      array (
        'in_advance' => '385497.83',
        'in_arrears' => '335215.53',
      ),
      'annuityFutureValue' =>
      array (
        'in_advance' => '775373.79',
        'in_arrears' => '674238.12',
      ),
    )
    ```

### Configuration

The configuration capabilities are currently very limited so there's next to nothing to tinker with.

The default configuration values are currently to be found in the "*constants/Default.php*" file, but there will be a possibility to use an easily accessible JSON (or PHP) configuration file in the future.

### Tests

The library includes a "*test*" subdirectory which contains all the basic tests. For your peace of mind, feel free to give them a run on your setup (provided that you have PHPUnit good and ready) and ensure that everything checks out.

The test-case examples are adapted directly from the lectures of a university course "*[4ST608 - Introduction to Financial and Insurance Mathematics](https://isis.vse.cz/katalog/syllabus.pl?predmet=62055;lang=en)*" taught at the University of Economics in Prague by Prof. RNDr. Tomáš Cipra, DrSc., to whom goes all the credit.

## Reference

Here you can find the documentation for each of the vanilla calculator types.

The implicit type of setters'/constructors' arguments as well as getters' returned values is String if not stated otherwise.

### AnnuityCalculator
namespace `FinanCalc\Calculators`
* **__construct($annuitySinglePaymentAmount, $annuityNoOfCompoundingPeriods, TimeSpan $annuityPeriodLength, $annuityInterest)**
  * *$annuitySinglePaymentAmount* = **'K'** – the amount of each individual payment (number greater than zero)
  * *$annuityNoOfCompoundingPeriods* = **'n'** – the number of periods pertaining to the interest compounding; if 'n = 0', the annuity is considered a perpetuity
  * *$annuityPeriodLength* = the length of a single period as a TimeSpan object
  * *$annuityInterest* = **'i'** – the interest rate *per a single payment period* by which the unpaid balance is multiplied (i.e., a decimal number typically lower than 1 and greater than 0)

##### Setters
* **setAnnuitySinglePaymentAmount($annuitySinglePaymentAmount)** – sets K
* **setAnnuityNoOfCompoundingPeriods($annuityNoOfCompoundingPeriods)** – sets n
* **setAnnuityPeriodLength(TimeSpan $annuityPeriodLength)** – sets the length of each compounding period in days
* **setAnnuityInterest($annuityInterest)** – sets i

##### Getters
* **getAnnuitySinglePaymentAmount()** – gets K
* **getAnnuityNoOfCompoundingPeriods()** – gets n
* **getAnnuityPeriodLength()** – gets the length of each compounding period as a TimeSpan object
* **getAnnuityPeriodLengthInYears()** – gets the length of each compounding period in years
* **getAnnuityPeriodLengthInMonths()** – gets the length of each compounding period in months
* **getAnnuityPeriodLengthInDays()** – gets the length of each compounding period in days
* **getAnnuityInterest()** – gets i
* **getAnnuityLengthInYears()** – gets the length of the annuity in years
* **getAnnuityLengthInMonths()** – gets the length of the annuity in months
* **getAnnuityLengthInDays()** – gets the length of the annuity in days
* **getAnnuityEndDate(DateTime $startDate)** – gets the ending date of the annuity as a DateTime object, based on the starting date passed in as a parameter
* **getAnnuityPresentValue(AnnuityPaymentTypes $annuityType)** – gets the present value of the annuity
  * *AnuityPaymentTypes $annuityType* = determines whether the payments are made either at the beginning or the end of each of the annuity's periods
    [*optional for perpetuities*]
* **getAnnuityPresentValueInAdvance()** – shorthand for *getAnnuityPresentValue(new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE))*
* **getAnnuityPresentValueInArrears()** – shorthand for *getAnnuityPresentValue(new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS))*
* **getAnnuityFutureValue(AnnuityPaymentTypes $annuityType)** – gets the future value of the annuity
  * *AnuityPaymentTypes $annuityType* = determines whether the payments are made either at the beginning or the end of each of the annuity's periods
    [*optional for perpetuities*]
* **getAnnuityFutureValueInAdvance()** – shorthand for *getAnnuityFutureValue(new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE))*
* **getAnnuityFutureValueInArrears()** – shorthand for *getAnnuityFutureValue(new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS))*
* **getAnnuityValue(AnnuityPaymentTypes $annuityPaymentType, AnnuityValueTypes $annuityValueType)** – gets either the present or the future value of the annuity
  * *AnuityPaymentTypes $annuityPaymentType* = determines whether the payments are made either at the beginning or the end of each of the annuity's periods
    [*optional for perpetuities*]
  * *AnuityValueTypes $annuityValueType* = determines whether the result is the present or the future value of the annuity
* **getResultAsArray(array $propResultArray = null)** – gets the array of the pertinent property values which you can specify (e.g., if you want only a specified subset thereof) via the optional argument
* **getSerializedResult(SerializerInterface $serializer)** – gets the serialized result, according to the passed SerializerInterface object

#### AnnuityCalculatorFactory (*AnnuityCalculator's factory object*)
namespace `FinanCalc\Calculators\Factories`
* **newYearlyAnnuity($annuitySinglePaymentAmount, $annuityNoOfCompoundingPeriods, $annuityInterest)**
* **newMonthlyAnnuity($annuitySinglePaymentAmount, $annuityNoOfCompoundingPeriods, $annuityInterest)**
* **newDailyAnnuity($annuitySinglePaymentAmount, $annuityNoOfCompoundingPeriods, $annuityInterest)**
* **newPerpetuity($annuitySinglePaymentAmount, $annuityInterest)**

#### AnnuityPaymentTypes
namespace `FinanCalc\Constants`
* *IN_ADVANCE* = 1
* *IN_ARREARS* = 2

#### AnnuityValueTypes
namespace `FinanCalc\Constants`
* *PRESENT_VALUE* = 1
* *FUTURE_VALUE* = 2

* * *

### DebtAmortizator
namespace `FinanCalc\Calculators`
* **__construct($debtPrincipal, $debtNoOfCompoundingPeriods, TimeSpan $debtPeriodLength, $debtInterest)**
  * *$debtPrincipal* = **'PV'** – the principal of the debt (number greater than zero)
  * *$debtNoOfCompoundingPeriods* = **'n'** – the count of the debt's compounding periods (number greater than zero)
  * *$debtPeriodLength* = the length of each of the debt's compounding periods as a TimeSpan object
  * *$debtInterest* = **'i'** – the interest per a compounding period, by which the outstanding balance is multiplied (i.e., a decimal number typically lower than 1 and greater than 0)

##### Setters
* **setDebtPrincipal($debtPrincipal)** – sets PV
* **setDebtNoOfCompoundingPeriods($debtNoOfCompoundingPeriods)** – sets n
* **setDebtPeriodLength(TimeSpan $debtPeriodLength)** – sets the length of each compounding period
* **setDebtInterest($debtInterest)** – sets i

##### Getters
* **getDebtDiscountFactor()** – gets the value of the debt's discount factor = **'v'**
* **getDebtSingleRepayment()** – gets the amount of a single repayment = **'K'**
* **getDebtPrincipal()** – gets PV
* **getDebtNoOfCompoundingPeriods()** – gets n
* **getDebtPeriodLength()** – gets the length of each compounding period as a TimeSpan object
* **getDebtPeriodLengthInYears()**  – gets the length of each compounding period in years
* **getDebtPeriodLengthInMonths()**  – gets the length of each compounding period in months
* **getDebtPeriodLengthInDays()** – gets the length of each compounding period in days
* **getDebtLengthInYears()** – gets the length of the debt in years
* **getDebtLengthInMonths()** – gets the length of the debt in months
* **getDebtLengthInDays()** – gets the length of the debt in days
* **getDebtEndDate(DateTime $startDate)** – gets the ending date of the debt as a DateTime object, based on the starting date passed in as a parameter
* **getDebtInterest()** – gets i
* **getDebtRepayments()** – gets the **array of RepaymentInstance** objects representing all the individual payments within the debt comprised into an array
* **getDebtRepaymentsAsArrays()** – gets the **array of associative arrays** (i.e., an array of RepaymentInstances converted to arrays) representing all the individual payments within the debt
* **getResultAsArray(array $propResultArray = null)** – gets the array of the pertinent property values which you can specify (e.g., if you want only a specified subset thereof) via the optional argument
* **getSerializedResult(SerializerInterface $serializer)** – gets the serialized result, according to the passed SerializerInterface object

#### DebtAmortizatorFactory (*DebtAmortizator's factory object*)
namespace `FinanCalc\Calculators\Factories`
* **newYearlyDebtAmortization($debtPrincipal, $debtNoOfPeriods, $debtInterest)**
* **newMonthlyDebtAmortization($debtPrincipal, $debtNoOfPeriods, $debtInterest)**
* **newDailyDebtAmortization($debtPrincipal, $debtNoOfPeriods, $debtInterest)**
* **newDebtAmortizationCustomPeriodLength($debtPrincipal, $debtNoOfPeriods, $debtInterest, $debtSinglePeriodLength)**

#### RepaymentInstance
namespace `FinanCalc\Calculators\DebtAmortizator`
* **getPrincipalAmount()** – gets the amount of the debt's principal covered by this single repayment
* **getInterestAmount()** – gets the amount of the debt's interest covered by this single repayment
* **getTotalAmount()** – gets the total amount covered by this individual repayment (both the "principal" and "interest" part)

* * *

### BondFairValueCalculator
namespace `FinanCalc\Calculators`
* **__construct($bondFaceValue, $bondAnnualCouponRate, $bondVIR, $bondYearsToMaturity, $bondPaymentFrequency = 1)**
  * *$bondFaceValue* = **'F'** – the face value of the bond (number greater than zero)
  * *$bondAnnualCouponRate* = **'c'** – the annual coupon rate of the bond (i.e., a decimal number typically lower than 1 and greater than 0)
  * *$bondVIR* = **'i' or 'VIR'** – the valuation interest rate of the bond (i.e., a decimal number typically lower than 1 and greater than 0)
  * *bondYearsToMaturity* = the number of years to the maturity of the bond (number greater than zero, can be a decimal number)
  * *bondPaymentFrequency* = the frequency of bond payments (expressed in a divisor of 12 months ~ 1 year); e.g.: divisor 2 means semi-annual payments

##### Setters
* **setBondFaceValue($bondFaceValue)** – sets F
* **setBondAnnualCouponRate($bondAnnualCouponRate)** – sets c
* **setBondVIR($bondVIR)** – sets i/VIR
* **setBondYearsToMaturity($bondYearsToMaturity)** – sets the number of years to the maturity of the bond
* **setBondPaymentFrequency($bondPaymentFrequency)** – sets the frequency of bond payments

##### Getters
* **getBondFaceValue()** – gets F
* **getBondAnnualCouponRate()** – gets c
* **getBondVIR()** – gets i/VIR
* **getBondYearsToMaturity()** – gets the number of years to the maturity of the bond
* **getBondPaymentFrequency()** – gets the frequency of bond payments
* **getBondNoOfPayments()** – gets the total number of payments during the lifespan of the bond
* **getBondFairValue()** – gets the fair value of the bond [calculated as present value of future cashflows corresponding to the bond by means of the valuation interest rate]
* **getResultAsArray(array $propResultArray = null)** – gets the array of the pertinent property values which you can specify (e.g., if you want only a specified subset thereof) via the optional argument
* **getSerializedResult(SerializerInterface $serializer)** – gets the serialized result, according to the passed SerializerInterface object

#### BondFairValueCalculatorFactory (*BondFairValueCalculator's factory object*)
namespace `FinanCalc\Calculators\Factories`
* **newAnnualCouponsBond($bondFaceValue, $bondAnnualCouponRate, $bondVIR, $bondYearsToMaturity)**
* **newSemiAnnualCouponsBond($bondFaceValue, $bondAnnualCouponRate, $bondVIR, $bondYearsToMaturity)**
* **newQuarterlyCouponsBond($bondFaceValue, $bondAnnualCouponRate, $bondVIR, $bondYearsToMaturity)**
* **newMonthlyCouponsBond($bondFaceValue, $bondAnnualCouponRate, $bondVIR, $bondYearsToMaturity)**
* **newCustomCouponFrequencyBond($bondFaceValue, $bondAnnualCouponRate, $bondVIR, $bondYearsToMaturity, $bondPaymentFrequency)**

* * *

### BondYTMCalculator
namespace `FinanCalc\Calculators`
* **__construct($bondFaceValue, $bondMarketValue, $bondAnnualCouponRate, $bondYearsToMaturity, $bondPaymentFrequency = 1)**
  * *$bondFaceValue* = **'F'** – the face value of the bond (number greater than zero)
  * *$bondMarketValue* = **'P'** – the market value (i.e., price) of the bond (number greater than zero)
  * *$bondAnnualCouponRate* = **'c'** – the annual coupon rate of the bond (i.e., a decimal number typically lower than 1 and greater than 0)
  * *bondYearsToMaturity* = the number of years to the maturity of the bond (number greater than zero, can be a decimal number)
  * *bondPaymentFrequency* = the frequency of bond payments (expressed in a divisor of 12 months ~ 1 year); e.g.: divisor 2 means semi-annual payments

##### Setters
* **setBondFaceValue($bondFaceValue)** – sets F
* **setBondMarketValue($bondMarketValue)** – sets the market value of the bond
* **setBondAnnualCouponRate($bondAnnualCouponRate)** – sets c
* **setBondYearsToMaturity($bondYearsToMaturity)** – sets the number of years to the maturity of the bond
* **setBondPaymentFrequency($bondPaymentFrequency)** – sets the frequency of bond payments

##### Getters
* **getBondFaceValue()** – gets F
* **getBondMarketValue()** – gets the market value of the bond
* **getBondAnnualCouponRate()** – gets c
* **getBondYearsToMaturity()** – gets the number of years to the maturity of the bond
* **getBondPaymentFrequency()** – gets the frequency of bond payments
* **getBondNoOfPayments()** – gets the total number of payments during the lifespan of the bond
* **getApproxBondYTM()** – gets the approximate value of the bond's yield to maturity in the form of a decimal number [it is the internal rate of return of the bond]
* **getResultAsArray(array $propResultArray = null)** – gets the array of the pertinent property values which you can specify (e.g., if you want only a specified subset thereof) via the optional argument
* **getSerializedResult(SerializerInterface $serializer)** – gets the serialized result, according to the passed SerializerInterface object

#### BondYTMCalculatorFactory (*BondYTMCalculator's factory object*)
namespace `FinanCalc\Calculators\Factories`
* **newAnnualCouponsBond($bondFaceValue, $bondMarketValue, $bondAnnualCouponRate, $bondYearsToMaturity)**
* **newSemiAnnualCouponsBond($bondFaceValue, $bondMarketValue, $bondAnnualCouponRate, $bondYearsToMaturity)**
* **newQuarterlyCouponsBond($bondFaceValue, $bondMarketValue, $bondAnnualCouponRate, $bondYearsToMaturity)**
* **newMonthlyCouponsBond($bondFaceValue, $bondMarketValue, $bondAnnualCouponRate, $bondYearsToMaturity)**
* **newCustomCouponFrequencyBond($bondFaceValue, $bondMarketValue, $bondAnnualCouponRate, $bondYearsToMaturity, $bondPaymentFrequency)**

* * *

### BondDurationCalculator
namespace `FinanCalc\Calculators`
* **__construct($bondFaceValue, $bondAnnualCouponRate, $bondAnnualYield, $bondYearsToMaturity, $bondPaymentFrequency = 1)**
  * *$bondFaceValue* = **'F'** – the face value of the bond (number greater than zero)
  * *$bondAnnualCouponRate* = **'c'** – the annual coupon rate of the bond (i.e., a decimal number typically lower than 1 and greater than 0)
  * *$bondAnnualYield* = the annual yield of the bond (calculated as an interest rate divided by the bond's' value)
  * *bondYearsToMaturity* = the number of years to the maturity of the bond (number greater than zero, can be a decimal number)
  * *bondPaymentFrequency* = the frequency of bond payments (expressed in a divisor of 12 months ~ 1 year); e.g.: divisor 2 means semi-annual payments

##### Setters
* **setBondFaceValue($bondFaceValue)** – sets F
* **setBondAnnualCouponRate($bondAnnualCouponRate)** – sets c
* **setBondAnnualYield($bondAnnualYield)** – sets the annual yield of the bond
* **setBondYearsToMaturity($bondYearsToMaturity)** – sets the number of years to the maturity of the bond
* **setBondPaymentFrequency($bondPaymentFrequency)** – sets the frequency of bond payments

##### Getters
* **getBondFaceValue()** – gets F
* **getBondAnnualCouponRate()** – gets c
* **getBondAnnualYield()** – gets the annual yield of the bond
* **getBondYieldPerPaymentPeriod()** – gets the yield of the bond per a payment period
* **getBondYearsToMaturity()** – gets the number of years to the maturity of the bond
* **getBondPaymentFrequency()** – gets the frequency of bond payments
* **getBondNoOfPayments()** – gets the total number of payments during the lifespan of the bond
* **getBondNominalCashFlows()** – gets an array of the bond's nominal cash flows (coupons; in the last payment = coupon + face value)
* **getBondDiscountedCashFlows()** – gets an array of the bond's discounted cash flows (nominal cash flows which are discounted by the means of the bond's yield per period)
* **getBondPresentValue()** – gets the present value of the bond which is represented by sum of all the bond's discounted cash flows (i.e., all the array members returned by the method getBondDiscountedCashFlows() are summed up)
* **getBondDuration()** – gets the bond's duration in years (can be a decimal number)
* **getResultAsArray(array $propResultArray = null)** – gets the array of the pertinent property values which you can specify (e.g., if you want only a specified subset thereof) via the optional argument
* **getSerializedResult(SerializerInterface $serializer)** – gets the serialized result, according to the passed SerializerInterface object

#### BondDurationCalculatorFactory (*BondDurationCalculator's factory object*)
namespace `FinanCalc\Calculators\Factories`
* **newAnnualCouponsBond($bondFaceValue, $bondAnnualCouponRate, $bondAnnualYield, $bondYearsToMaturity)**
* **newSemiAnnualCouponsBond($bondFaceValue, $bondAnnualCouponRate, $bondAnnualYield, $bondYearsToMaturity)**
* **newQuarterlyCouponsBond($bondFaceValue, $bondAnnualCouponRate, $bondAnnualYield, $bondYearsToMaturity)**
* **newMonthlyCouponsBond($bondFaceValue, $bondAnnualCouponRate, $bondAnnualYield, $bondYearsToMaturity)**
* **newCustomCouponFrequencyBond($bondFaceValue, $bondAnnualCouponRate, $bondAnnualYield, $bondYearsToMaturity, $bondPaymentFrequency)**

* * *

### SimpleDiscountCalculator
namespace `FinanCalc\Calculators`
* **__construct($amountDue, $annualDiscountRate, TimeSpan $time)**
  * *$principal* = **'S'** – the amount due
  * *$annualInterestRate* = **'d'** – the annual discount rate (i.e., a decimal number typically lower than 1 and greater than 0)
  * *$time* = (converted to years) **'t'** – the total time as a TimeSpan object

##### Setters
* **setAmountDue($amountDue)** – sets S
* **setAnnualDiscountRate($annualDiscountRate)** – sets d
* **setTime(TimeSpan $time)** – sets the total time

##### Getters
* **getAmountDue()** – gets S
* **getAnnualDiscountRate()** – gets d
* **getTime()** – gets the total time as a TimeSpan object
* **getTimeInYears()** – gets the total time in years
* **getTimeInMonths()** – gets the total time in months
* **getTimeInDays()** – gets the total time in days
* **getDiscountAmount()** – gets the discount amount ('D')

#### SimpleDiscountCalculatorFactory (*SimpleDiscountCalculator's factory object*)
namespace `FinanCalc\Calculators\Factories`
* **newSimpleDiscount($amountDue, $annualDiscountRate, TimeSpan $time)**

* * *

### SimpleInterestCalculator
namespace `FinanCalc\Calculators`
* **__construct($principal, $annualInterestRate, TimeSpan $time)**
  * *$principal* = **'P'** – the amount of principal
  * *$annualInterestRate* = **'i'** – the annual interest rate (i.e., a decimal number typically lower than 1 and greater than 0)
  * *$time* = (converted to years) **'t'** – the total time as a TimeSpan object

##### Setters
* **setPrincipal($principal)** – sets P
* **setAnnualInterestRate($annualInterestRate)** – sets i
* **setTime(TimeSpan $time)** – sets the total time

##### Getters
* **getPrincipal()** – gets P
* **getAnnualInterestRate()** – gets i
* **getTime()** – gets the total time as a TimeSpan object
* **getTimeInYears()** – gets the total time in years
* **getTimeInMonths()** – gets the total time in months
* **getTimeInDays()** – gets the total time in days
* **getInterestNumber()** – gets the interest number ('IN')
* **getInterestDivisor()** – gets the interest divisor ('ID')
* **getInterestAmount()** – gets the interest amount ('n')

#### SimpleInterestCalculatorFactory (*SimpleInterestCalculator's factory object*)
namespace `FinanCalc\Calculators\Factories`
* **newSimpleInterest($principal, $annualInterestRate, TimeSpan $time)**

* * *

### StockDividendDiscountModelCalculator
namespace `FinanCalc\Calculators`
* **__construct(StockDDMTypes $dividendDiscountModelType, $stockVIR, $stockAnnualDividendValue, $stockAnnualDividendsGrowth = null)**
  * *$dividendDiscountModelType* = the type of the dividend discount model according to which the result will be calculated (value of the type *StockDDMTypes*)
  * *$stockVIR* = **'i'** – the stock's valuation interest rate
  * *$stockAnnualDividendsValue* = **'D'** – the absolute value of the stock's annual dividends
  * *$stockAnnualDividendsGrowth* = **'g'** – the rate by which the stock's annual dividends are annually multiplied (i.e., a decimal number between 0 and 1) [*this value applies only to the multiple growth dividend discount model*]

#### Setters
* **setDividendDiscountModelType(StockDDMTypes $dividendDiscountModelType)** – sets the type of the dividend discount model
* **setStockVIR($stockVIR)** – sets i
* **setStockAnnualDividendsValue($stockAnnualDividendsValue)** – sets D
* **setStockAnnualDividendsGrowth($stockAnnualDividendsGrowth)** – sets g

#### Getters
* **getDividendDiscountModelType()** – gets the type of the dividend discount model
* **getStockVIR()** – gets i
* **getStockAnnualDividendsValue()** – gets D
* **getStockAnnualDividendsGrowth()** – gets g
* **getStockPresentValue()** – gets the present (~ fair) value of the stock
* **getResultAsArray(array $propResultArray = null)** – gets the array of the pertinent property values which you can specify (e.g., if you want only a specified subset thereof) via the optional argument
* **getSerializedResult(SerializerInterface $serializer)** – gets the serialized result, according to the passed SerializerInterface object

#### StockDividendDiscountModelCalculatorFactory (*StockDividendDiscountModelCalculator's factory object*)
namespace `FinanCalc\Calculators\Factories`
* **newZeroGrowthDividendDiscountModel($stockVIR, $stockAnnualDividendValue)**
* **newMultipleGrowthDividendDiscountModel($stockVIR, $stockAnnualDividendValue, $stockAnnualDividendsGrowth)**

#### StockDDMTypes
namespace `FinanCalc\Constants`
* *ZERO_GROWTH* = 1
* *MULTIPLE_GROWTH* = 2

* * *

### StockInvestmentRatiosCalculator
namespace `FinanCalc\Calculators`
* **__construct($totalDividends, $earningsAfterTaxes, $noOfStocks)**
  * *$totalDividends* = the sum of dividends per a period
  * *$earningsAfterTaxes* = the amount earned after taxes
  * *$noOfStocks* = the number of stocks (total if constant, average if fluctuating)

#### Setters
* **setTotalDividends($totalDividends)** – sets the sum of dividends per a period
* **setEarningsAfterTaxes($earningsAfterTaxes)** – sets the amount earned after taxes
* **setNoOfStocks($noOfStocks)** – sets the number of stocks

#### Getters
* **getTotalDividends()** – gets the sum of dividends per a period
* **getEarningsAfterTaxes()** – gets the amount earned after taxes
* **getNoOfStocks()** – gets the number of stocks
* **getDividendPerStock()** – gets the dividend per stock (DPS) value
* **getEarningsPerStock()** – gets the earning per stock (EPS) value
* **getPayoutRatio()** – gets the payout ratio (also referred to as "dividend payout ratio")
* **getDividendRatio()** – gets the dividend ratio (the payout ratio to the power of -1)
* **getRetentionRatio()** – gets the retention ("plowback") ratio
* **getResultAsArray(array $propResultArray = null)** – gets the array of the pertinent property values which you can specify (e.g., if you want only a specified subset thereof) via the optional argument
* **getSerializedResult(SerializerInterface $serializer)** – gets the serialized result, according to the passed SerializerInterface object

#### StockInvestmentRatiosCalculatorFactory (*StockInvestmentRatiosCalculator's factory object*)
namespace `FinanCalc\Calculators\Factories`
* **newCustomStocks($totalDividends, $earningAfterTaxes, $noOfStocks)**

* * *

## DISCLAIMER
You are free to use/modify/extend the library as you please - for it to serve your purpose. As per the (un)license, the software is provided as is and the original author cannot be held liable for any losses/damages directly or indirectly resulting from using thereof.
Attribution is welcome, but certainly not required.

**NOTE**
The library is currently work-in-progress and it is certain that new features will be added in the process.Consider this, therefore, as a preview product prone to abrupt and extensive changes that may affect functionality of an external code adapted to a prior version(s) of the library.
Always explore the provisional compatibility of the library with your project in case you upgrade to a new version of the library (by means of an extensive testing of the code in which you are exerting the library's features).

**Be everything as it may, thank you for checking out FinanCalc :bowtie:**
