<?php

namespace Phpatterns\Creational;

interface Parser
{
    public function parse(string $input): array;
}

class CsvParser implements Parser
{
    const OPTION_CSV_HEADER = true;
    const OPTION_CSV_NO_HEADER = false;
    
    private $option;
    
    function __construct(bool $option=CsvParser::OPTION_CSV_HEADER)
    {
        $this->option = $option;
    }
    
    function parse(string $input): array
    {
        return ['csv'=>'parsed '.(string)$this->option];
    }
}


class JsonParser implements Parser
{
    function parse(string $input): array
    {
        return ['json'=>'parsed'];
    }
}

class ParserFactory
{
    function createCsvParser(bool $option=CsvParser::OPTION_CSV_HEADER): CsvParser
    {
        return new CsvParser($option);
    }
    
    function createJsonParser(): JsonParser
    {
        return new JsonParser();
    }
}
