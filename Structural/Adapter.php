<?php

/**
 * Adapter
 *  allows the interface of an existing class to be used as another interface,
 *  used to make existing classes work with others without modifying their source code. 
 */
 
class EmailManager
{
    public function backupMail(): string {
        return 'all is good';
    }
}

class SpecialLegacyManager
{
    public function cryptedValue(): string {
        return '*cryp*ted***value*';
    }
}

class ManagerAdapter extends EmailManager
{
    private $specialManager;
    
    public function __construct(SpecialLegacyManager $specialManager) {
        $this->specialManager = $specialManager;
    }
    
    public function backupMail(): string {
        $crypted = $this->specialManager->cryptedValue();
        return 'un'.str_replace('*', '', $crypted);
    }
}

$email = (new EmailManager())->backupMail();
$emailAdaptee = (new ManagerAdapter(new SpecialLegacyManager()))->backupMail();

return "all is good uncryptedvalue" === "$email $emailAdaptee";
