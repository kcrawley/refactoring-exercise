<?php

# set working directory
chdir(realpath(__DIR__ . '/../'));

if (!file_exists("./vendor/autoload.php")) {
    throw new \Exception("Unable to load autoloader. Did you run composer install?");
}

# boot autoloader
require "./vendor/autoload.php";

# register autoloader(s)
Mustache_Autoloader::register();

# define variables
$import     = new \Refactoring\Import();
$priceData  = $import->parse();
$statement  = new \Refactoring\Statement($priceData['priceCodes']);
$output     = isset($argv[1]) ? $argv[1] : 0;
$customer   = new \Refactoring\Customer('Joe Schmoe');
$rentals    = [
    'Back to the Future' => 4,
    'Office Space' => 3,
    'The Big Lebowski' => 5
];

# calculate rental data
foreach($rentals as $movieName => $rentalDays) {
    $customer->addRental(
        new \Refactoring\Rental(
            new \Refactoring\Movie(
                $movieName,
                $priceData['movies'][$movieName]['priceCode']
            ),
            $rentalDays
        )
    );
}


# output statement
switch ($output) {
    case \Refactoring\Statement::STD_OUT:
        echo $customer->statement($statement);
        break;
    case \Refactoring\Statement::HTML:
        echo $customer->htmlStatement($statement);
        break;
    case \Refactoring\Statement::JSON:
        echo $customer->jsonStatement($statement);
        break;
}

