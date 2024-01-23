# Currency formatting and conversion for Botble CMS

## Usage

```php
use SkillCraft\Supports\Money\Currency;
use SkillCraft\Supports\Money\Money;

echo Money::USD(500); // '$5.00' unconverted
echo new Money(500, new Currency('USD')); // '$5.00' unconverted
echo Money::USD(500, true); // '$500.00' converted
echo new Money(500, new Currency('USD'), true); // '$500.00' converted
```

### Advanced

```php
$m1 = Money::USD(500);
$m2 = Money::EUR(500);

$m1->getCurrency();
$m1->isSameCurrency($m2);
$m1->compare($m2);
$m1->equals($m2);
$m1->greaterThan($m2);
$m1->greaterThanOrEqual($m2);
$m1->lessThan($m2);
$m1->lessThanOrEqual($m2);
$m1->convert(Currency::GBP(), 3.5);
$m1->add($m2);
$m1->subtract($m2);
$m1->multiply(2);
$m1->divide(2);
$m1->allocate([1, 1, 1]);
$m1->isZero();
$m1->isPositive();
$m1->isNegative();
$m1->format();
```

### Helpers

```php
sc_core_money(500)
sc_core_money(500, 'USD')
sc_core_currency('USD')
```

### Blade Directives

```php
@sc_core_money(500)
@sc_core_money(500, 'USD')
@sc_core_currency('USD')
```

### Blade Component

Same as the directive, there is also a `blade` component for you to create money and currency in your views:

```html
<x-sc-core-money amount="500" />
or
<x-sc-core-money amount="500" currency="USD" />
or
<x-sc-core-money amount="500" currency="USD" convert />

<x-sc-core-currency currency="USD" />
```

### Macros

This package implements the Laravel `Macroable` trait, allowing macros and mixins on both `Money` and `Currency`.

Example use case:

```php
use SkillCraft\Supports\Money\Currency;
use SkillCraft\Supports\Money\Money;

Money::macro(
    'absolute',
    fn () => $this->isPositive() ? $this : $this->multiply(-1)
);

$money = Money::USD(1000)->multiply(-1);

$absolute = $money->absolute();
```

Macros can be called statically too:

```php
use SkillCraft\Supports\Money\Currency;
use SkillCraft\Supports\Money\Money;

Money::macro('zero', fn (?string $currency = null) => new Money(0, new Currency($currency ?? 'GBP')));

$money = Money::zero();
```

### Mixins

Along with Macros, Mixins are also supported. This allows merging another classes methods into the Money or Currency class.

Define the mixin class:

```php
use SkillCraft\Supports\Money\Money;

class CustomMoney 
{
    public function absolute(): Money
    {
        return $this->isPositive() ? $this : $this->multiply(-1);
    }
    
    public static function zero(?string $currency = null): Money
    {
        return new Money(0, new Currency($currency ?? 'GBP'));
    }
}
```

Register the mixin, by passing an instance of the class:

```php
Money::mixin(new CustomMoney);
```

The methods from the custom class will be available:

```php
$money = Money::USD(1000)->multiply(-1);
$absolute = $money->absolute();

// Static methods via mixins are supported too:
$money = Money::zero();
```