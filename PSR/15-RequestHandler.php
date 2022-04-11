<?php

namespace Phpatterns\Psr;

/**
 * PSR-15 common interfaces for HTTP server request handlers
 * 
 * Handler: application entrypoint, and inner-most handler to which the request is matched
 *   middleware
 *   middleware
 *   middleware
 * Handler
 * 
 * Single-pass "lambda" method, only request is passed
 * 
 * interface RequestHandlerInterface { public function handle(ServerRequestInterface $request): ResponseInterface; }
 * interface MiddlewareInterface { public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface; }
 */
 
interface ResponseInterface {} // PSR-7
interface ServerRequestInterface {} // PSR-7
// Handles a request and produces a response.
interface RequestHandlerInterface { public function handle(ServerRequestInterface $request): ResponseInterface; }
// acting on the request, updating the response, or forwarding the request to another middleware
interface MiddlewareInterface { public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface; }

class ServerRequest implements ServerRequestInterface
{
    public $headers = [];
    public $attributes = [];
}

class Response implements ResponseInterface
{
    public $code = 200;
    public $body = '';
}

class HttpHandler implements RequestHandlerInterface
{
    private $stack = [];
    public function __construct($stackMiddleware = [])
    {
        $this->stack = $stackMiddleware;
    }
    
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $defaultResponse = new Response();

        $middle = array_shift($this->stack);
        $response = $middle ? $middle->process($request, $this) : $defaultResponse;
        
        return $response;
    }
}

class XmlHeaderActionMiddleWare implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        $response->headers['HTTP-XML'] = 'script/xml';
        
        return $response;
    }
}

class ContentHeaderActionMiddleWare implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        $response->headers['Content-Type'] = 'application/text';
        
        return $response;
    }
}

// use
$httpRequest = new ServerRequest();
$httpHandler = new HttpHandler([
    new XmlHeaderActionMiddleWare(),
    new ContentHeaderActionMiddleWare(),
    // ...
]);
$response = $httpHandler->handle($httpRequest);
return 0; // todo
return join(', ', $response->headers) === 'application/text, script/xml';
