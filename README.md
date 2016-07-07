## Installation

- Feel free to use docker to install dependencies for this application:

```
docker run --rm -v $(pwd):/app composer/composer:php5 install
```

## Execution

- Execute `php bin/index.php` to generate familar output
- Execute `php bin/index.php 1` to generate HTML output
- Execute `php bin/index.php 2` for JSON

## Core changes

- Left most things alone as they didn't need to be changed.
- Added template and YAML parsing libraries
- Output formats (HTML/STDOUT) now use mustache templates
- `customer->statement()` method to use `Statement` object to generate statements.

- Parameterized pricing algorithm (see below for mapping)
  - n: days rented
  - `((n - x) * y) + a`

- Utilize YAML configuration files to define _movies_ and _price data_
  - Pricing variables are now defined in the YAML file under `priceCodes`
    - baseAmount :: initial charge (a)
    - maxFreeDays :: the number of days before pricing algorithm is applied (x)
    - costMultiplier :: (y)
  - Bonus points may now be configured in the YAML under `frequentRenter` within each price code
    - minDays :: number of days before a bonus is applied
    - addPoints :: number of points which are applied as the bonus


## Introduction

This example comes from the book Refactoring by Martin Fowler.

There are solutions to this problem readily available on the Internet, so please adhere to the honor system: don't cheat!

## Requirements

The code uses short array syntax (`$arr = [];`), so you'll need PHP 5.4 or higher.

Feel free to include any external libraries or dependencies that you believe will add value to the project.

## Domain

The domain concerns movie rentals and customer statements.

There are 3 existing classes:

- **`Movie`** is composed of a title - `name` - and a pricing code - `priceCode`.
- **`Rental`** is composed of a `Movie` - `movie` - and a duration - `daysRented`.
- **`Customer`** is composed of a name - `name` - and, optionally, a `Rental` collection / array - `rentals`.

The `Customer` class also contains a method - `statement()` - that prints a plain-text statement containing the customer's billing and loyalty information.

## Current State

The program can be run by `$ php index.php`.

This should be the output:

```
Rental Record for Joe Schmoe
        Back to the Future              3
        Office Space                    3.5
        The Big Lebowski                15
Amount owed is 21.5
You earned 4 frequent renter points

```

## Your Tasks

1. The business requires statements in HTML - in addition to their current text output. The desired HTML output is shown below. Please implement a `Customer.htmlStatement()` method that returns this output.
2. The business wants to change the movie classifications. They may, for example, wish to remove "Children's" or add a new classification called "SciFi". Then again, they may simply wish to change the algorithms for calculating frequent renter points. **In other words, the classification / pricing / points system needs to be more flexible.** (This task is intentionally open-ended.)

### HTML Output for Task #1

```
<h1>Rental Record for <em>Joe Schmoe</em></h1>
<ul>
    <li>Back to the Future - 3</li>
    <li>Office Space - 3.5</li>
    <li>The Big Lebowski - 15</li>
</ul>
<p>Amount owed is <em>21.5</em></p>
<p>You earned <em>4</em> frequent renter points</p>
```

## Your Deliverables

1. Return your solution as a `.zip` or `.tgz` file.
2. Include a rough estimate of how much time you spent working on the assignment.
3. Also include any additional instructions / requirements for running your solution.
4. Finally, please feel free - though you're not required - to provide some "documentation" to justify any tradeoffs you might have made when writing the code and what implications those tradeoffs may have in the future - especially for the second "task" above.