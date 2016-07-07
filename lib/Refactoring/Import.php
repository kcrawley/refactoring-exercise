<?php namespace Refactoring;

use Symfony\Component\Yaml\Yaml;

class Import
{
    /** @var Yaml $yaml */
    protected $yaml;

    /** @var string $file */
    protected $file;

    /**
     * Import constructor.
     * @param Yaml|null $yaml
     * @param string $file
     */
    public function __construct(Yaml $yaml = null, $file = './config/priceData.yaml')
    {
        $this->yaml = (is_null($yaml)) ? new Yaml() : $yaml;
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function parse()
    {
        return $this->yaml->parse(file_get_contents($this->file));
    }
}