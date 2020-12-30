<?php 
/**
 * Factory Method Implementation
 */ 

namespace Patterns;

/**
 * Interface Logger 
 */
interface Logger
{
    public function Log(string $message);
}

/**
 * FileLogger
 */
class FileLogger implements Logger
{
    private $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function Log(string $message)
    {
        echo "write $message into {$this->filePath}"; 
    }
}

class StdoutLogger implements Logger
{
    public function Log(string $message)
    {
        echo "{$message}plus"; 
    }
}

/**
 * Interface FactoryMethod
 */
interface LoggerFactory
{
    public function createLogger();
}

class StdoutLoggerFactory implements LoggerFactory
{
    public function createLogger(): StdoutLogger
    {
        return new StdoutLogger();
    }    
}

class FileLoggerFactory implements LoggerFactory
{
    public function __construct($filePath)
    {

    }

    public function createLogger()
    {
        $filePath = '';
        return new FileLogger($filePath);
    }
}
