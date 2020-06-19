<?php
namespace GSLab\Package;

abstract class Base
{
    /**
     * Print error message
     *
     * @param string $message
     * @return void
     */
    public function printError(string $message): void
    {
        //Single quote is not possible
        echo "\033[31m $message \033[0m" . PHP_EOL;
    }

    /**
     * Print info message
     *
     * @param string $message
     * @return void
     */
    public function printInfo(string $message): void
    {
        //Single quote is not possible
        echo "\033[36m $message \033[0m" . PHP_EOL;
    }

    /**
     * Print warning message
     *
     * @param string $message
     * @return void
     */
    public function printWarn(string $message): void
    {
        //Single quote is not possible
        echo "\033[33m $message \033[0m" . PHP_EOL;
    }

    /**
     * Print warning success
     *
     * @param string $message
     * @return void
     */
    public function printSuccess(string $message): void
    {
        //Single quote is not possible
        echo "\033[32m $message \033[0m" . PHP_EOL;
    }
}