<?php

namespace Inn\App\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Psr\Log\InvalidArgumentException;
use ReflectionClass;

class Logger implements LoggerInterface
{
    public function __construct(
        private string $logFilePath = '/var/www/html/src/Logger/app.log'
    ){
        $dirName = dirname($this->logFilePath);

        if(!is_dir($dirName)) {
            mkdir($dirName, 0755, true);
        }
    }

    public function emergency(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    public function alert(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    public function critical(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    public function error(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    public function warning(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    public function notice(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    public function info(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    public function debug(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    public function log(mixed $level, \Stringable|string $message, array $context = []): void
    {
        $logLevelObject = new ReflectionClass(LogLevel::class);
        $logLevels = $logLevelObject->getConstants();

        if(!in_array($level, $logLevels)) {
            throw new InvalidArgumentException($level);
        }

        $timestamp = date('Y-m-d H:i:s');
        $logLine = "[$timestamp] [$level] {$this->interpolate($message, $context)}\n";

        error_log($logLine, 3, $this->logFilePath);

    }

    public function interpolate($message, array $context = array()): string
    {
        $replace = array();

        foreach ($context as $key => $val) {
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        return strtr($message, $replace);
    }
}