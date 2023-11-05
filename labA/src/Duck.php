<?php // src/Duck.php
namespace Hskorupka\LabComposer;

class Duck
{
    /** @var \Monolog\Logger */
    private $logger;

    public function __construct(\Monolog\Logger $logger = null)
    {
        $this->logger = $logger;
        if ($this->logger) {
            $this->logger->info("Duck created.");
        }
    }
    public function quack()
    {
        if ($this->logger) {
            $this->logger->debug("Quack() executed.");
        }
        echo "Quack\n";
    }
}
?>