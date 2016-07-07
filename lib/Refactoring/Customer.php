<?php namespace Refactoring;

class Customer
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Rental[]
     */
    private $rentals;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->rentals = [];
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @param Rental $rental
     */
    public function addRental(Rental $rental)
    {
        $this->rentals[] = $rental;
    }

    /**
     * @param Statement $statement
     * @return string
     */
    public function statement(Statement $statement)
    {
        return $statement->generate([
            'name'      => $this->name,
            'rentals'   => $this->rentals,
        ], Statement::STD_OUT);
    }

    /**
     * @param Statement $statement
     * @return string
     */
    public function htmlStatement(Statement $statement)
    {
        return $statement->generate([
            'name'      => $this->name,
            'rentals'   => $this->rentals,
        ], Statement::HTML);
    }

    /**
     * @param Statement $statement
     * @return string
     */
    public function jsonStatement(Statement $statement)
    {
        return $statement->generate([
            'name'      => $this->name,
            'rentals'   => $this->rentals,
        ], Statement::JSON);
    }
}
