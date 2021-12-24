<?php
/*
    The access to an object should be controlled.
    Additional functionality should be provided when accessing an object.
    
    - Remote proxy: Reference on remote object
    - Virtual proxy : memory allocation when used
    - Access proxy: Add a security layer
    - Cache proxy
*/

interface ImageLoader
{ 
    function displayImage(string $path): string;
}

class RealImage implements ImageLoader
{
    function displayImage(string $path): string
    {
        return 'Loading from disk..................';
    }
}

class ProxyImage implements ImageLoader
{
    private $imageObject = null; 
    private $file;
    
    public function __construct(ImageLoader $imageObject) { $this->imageObject = $imageObject; }
    
    function displayImage(string $path): string
    {
        $sec = $this->securityLayer();
        
        $file = 'Load from cache!';
        if (null === $this->file) {
            $file = $this->file = $this->imageObject->displayImage($path);
        }
        return $sec.$file;
    }
    
    private function securityLayer(): string
    {
        return 'Checking security. ';
    }
}

$image = new ProxyImage(new RealImage());
$file_first = $image->displayImage('my/file/path.jpg');
$file_next = $image->displayImage('my/file/path.jpg');

return 'Checking security. Load from cache!' === $file_next;
