<?php namespace Refactoring;

class Statement
{
    const STD_OUT = 0;
    const HTML = 1;
    const JSON = 2;

    /** @var \Mustache_Engine $mustache */
    protected $mustache;

    /** @var array $priceData */
    protected $priceData = [];

    public function __construct(array $priceData, $mode = 0)
    {
        if (empty($priceData)) {
            throw new \Exception(
                sprintf(
                    '`%s` may not be instantiated without price data.',
                    __CLASS__
                )
            );
        }

        $this->mustache     = new \Mustache_Engine(); // hard dependency here, don't see it changing
        $this->priceData    = $priceData;
        $this->mode         = (int) $mode;
    }

    /**
     * @param array $data
     * @return string
     */
    public function generate(array $data)
    {
        $renderData = [
            'name'      => $data['name'],
            'movies'    => [],
            'amount'    => 0,
            'points'    => 0,
        ];

        foreach($data['rentals'] as $rental) {
            $priceCode      = $rental->movie()->priceCode();
            $thisAmount     = $this->priceData[$priceCode]['baseAmount'];
            $maxFreeDays    = $this->priceData[$priceCode]['maxFreeDays'];
            $costMultiplier = $this->priceData[$priceCode]['costMultiplier'];
            $frequentRenter = array_key_exists('frequentRenter', $this->priceData[$priceCode])
                ? $this->priceData[$priceCode]['frequentRenter']
                : false;

            if ($rental->daysRented() > $maxFreeDays) {
                $thisAmount += ($rental->daysRented() - $maxFreeDays) * $costMultiplier;
            }

            $renderData['movies'][] = [
                'name'      => ($this->mode == self::STD_OUT)
                    ? str_pad($rental->movie()->name(), 30, ' ', STR_PAD_RIGHT)
                    : $rental->movie()->name(),
                'subTotal'  => $thisAmount
            ];
            $renderData['amount'] += $thisAmount;
            $renderData['points']++;

            if ($frequentRenter && $rental->daysRented() > $frequentRenter['minDays']) {
                $renderData['points'] += $frequentRenter['minDays'];
            }
        }

        switch($this->mode) {
            case self::STD_OUT:
                return $this->mustache->render(
                    file_get_contents('./templates/statement-std_out.mustache'),
                    $renderData
                );
                break;
            case self::HTML:
                return $this->mustache->render(
                    file_get_contents('./templates/statement-html.mustache'),
                    $renderData
                );
                break;
            case self::JSON:
                return json_encode($renderData);
                break;
        }
    }
}