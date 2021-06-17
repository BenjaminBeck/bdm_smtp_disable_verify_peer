<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace BDM\BdmSmtpDisableVerifyPeer\Transport;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\NullTransport;
use Symfony\Component\Mailer\Transport\SendmailTransport;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Log\LogManagerInterface;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * TransportFactory
 */
class TransportFactory extends \TYPO3\CMS\Core\Mail\TransportFactory
{
    /**
     * Gets a transport from settings.
     *
     * @param array $mailSettings from $GLOBALS['TYPO3_CONF_VARS']['MAIL']
     * @return TransportInterface
     * @throws Exception
     * @throws \RuntimeException
     */
    public function get(array $mailSettings): TransportInterface
    {
        /** @var EsmtpTransport $transport */
        $transport = parent::get($mailSettings);

        if( get_class($transport) === EsmtpTransport::class
            && get_class($transport->getStream()) === Transport\Smtp\Stream\SocketStream::class ){

            $transport->getStream()->setStreamOptions([
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ]);
        }
        return $transport;
    }

}
