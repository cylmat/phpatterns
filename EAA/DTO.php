<?php

/**
 * DTO shift data in expensive remote calls
 * 
 * It arries data between processes, 
 *  aggregates the data that would have been transferred by several calls
 */

final class RemoteServiceApi
{
    // User service        // Remote User Model
    function getUser(int $id)
    {
        switch($id) {
            case 123: return (object)[
                'id' => 123, 'name' => 'John',   'phone' => '0909090', 'pass' => 'a@p', 'addressId' => 'abc'
            ];
            case 555: return (object)[
                'id' => 555, 'name' => 'Amanda', 'phone' => '0123456', 'pass' => 'p!g', 'addressId' => 'fff'
            ];
        }
    }
    
    // Address service        // Remote Address Model
    function getAddress(string $id)
    {
        switch($id) {
            case 'abc': return (object)['id' => 'abc', 'address' => '36 street down'];
            case 'fff': return (object)['id' => 'fff', 'address' => 'Oakson bd and co'];
            case '963': return (object)['id' => '963', 'address' => 'bakery johson city'];
        }
    }
}

class DTOAssembler
{
    // User model, Address model
    function toDTO(object $remoteUser, object $remoteAddress): DTObject
    {
        $dto = new DTObject();
        $dto->userName = $remoteUser->name;
        $dto->userAddress = $remoteAddress->address;
        
        return $dto;
    }
}

// only values to be used
class DTObject
{
    public $userName;
    public $userAddress;
}

$remoteUser = (new RemoteServiceApi)->getUser(555);
$remoteAddress = (new RemoteServiceApi)->getAddress($remoteUser->addressId);

$dto = (new DTOAssembler())->toDTO($remoteUser, $remoteAddress);

return 'Oakson bd and co' === $dto->userAddress;
