<?php

/**
 * Define an interface for creating an object, but let subclasses decide which class to instantiate.
 * -> factory is a method that can be overriden by subclasses
 * 
 * Abstract Factory is implemented by Composition; but Factory Method is implemented by Inheritance.
 */

namespace Phpatterns\Creational;

interface ParserInterface { public function parse(string $input): array; }

interface ParserFactoryInterface { public function createParser(): ParserInterface; }

class CsvParser implements ParserInterface
{
    function parse(string $input): array
    {
        return ['csv'=>'parsed'];
    }
}

class JsonParser implements ParserInterface
{
    function parse(string $input): array
    {
        return ['json'=>'parsed'];
    }
}

class CsvParserFactory implements ParserFactoryInterface
{
    function createParser(): ParserInterface
    {
        return new CsvParser();
    }
}

class JsonParserFactory implements ParserFactoryInterface
{
    function createParser(): ParserInterface
    {
        return new JsonParser();
    }
}

$json = (new JsonParserFactory())->createParser();

return $json instanceof JsonParser;
