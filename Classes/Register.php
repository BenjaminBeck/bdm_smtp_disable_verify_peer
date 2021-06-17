<?php
namespace BDM\BdmSmtpDisableVerifyPeer;


use BDM\BdmSmtpDisableVerifyPeer\Transport\TransportFactory;

class Register
{

    /**
     * To make this also work for the typo3 mail test, registration has to be done in AdditionalConfiguration.php
     */
    public static function main()
    {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Core\Mail\TransportFactory::class] = array(
            'className' => TransportFactory::class,
        );
    }
}
