<?php

namespace Evozon\M2Demo\Model\Cronjob;

use Psr\Log\LoggerInterface;

class MinuteLog
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute()
    {
        $this->logger->info(date("Y-m-d H:i:s") . ' was an ideal moment for logging');
    }
}
