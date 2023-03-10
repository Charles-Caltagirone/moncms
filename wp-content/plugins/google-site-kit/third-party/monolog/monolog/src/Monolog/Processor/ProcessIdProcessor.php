<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Google\Site_Kit_Dependencies\Monolog\Processor;

/**
 * Adds value of getmypid into records
 *
 * @author Andreas Hörnicke
 */
class ProcessIdProcessor implements \Google\Site_Kit_Dependencies\Monolog\Processor\ProcessorInterface
{
    /**
     * @param  array $record
     * @return array
     */
    public function __invoke(array $record)
    {
        $record['extra']['process_id'] = \getmypid();
        return $record;
    }
}
