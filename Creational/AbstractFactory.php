<?php

/**
 * Provide an interface for creating families of related or dependent objects without specifying their concrete classes.
 */

namespace Phpatterns\Creational;

interface ParserInterface { public function parse(string $input): array; }
interface FileDecoderInterface { public function decode(string $file): array; }

interface ManagerAbstractFactory
{
    function createCsvParser(): ParserInterface;
    function createFileDecoder(): FileDecoderInterface;
}

class Utf8CsvParser implements ParserInterface
{
    function parse(string $input): array
    {
        return ['csv'=>'parsed'];
    }
}

class Utf8JsonParser implements ParserInterface
{
    function parse(string $input): array
    {
        return ['json'=>'parsed'];
    }
}

class Utf8FileDecoder implements FileDecoderInterface
{
    public function decode(string $file): array
    {
    }
}

class Utf8Manager implements ManagerAbstractFactory
{
    function createCsvParser(): ParserInterface
    {
        return new Utf8JsonParser();
    }

    function createFileDecoder(): FileDecoderInterface
    {
        return new Utf8FileDecoder();
    }
}

$filedecoder = (new Utf8Manager())->createFileDecoder();

return $filedecoder instanceof Utf8FileDecoder; 
