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
 * interface RequestHandlerInterface { public function handle(ServerRequestInterface $request): ResponseInterface; }
 * interface MiddlewareInterface { public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface; }
 */
 
interface ResponseInterface {} // PSR-7
interface ServerRequestInterface {} // PSR-7
// Handles a request and produces a response.
interface RequestHandlerInterface { public function handle(ServerRequestInterface $request): ResponseInterface; }
// acting on the request, generating the response, or forwarding the request to a middleware
interface MiddlewareInterface { public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface; }

class ServerRequest implements ServerRequestInterface
{
    public $headers = [];
    public $attributes = [];
}

class Response implements ResponseInterface
{
    public $code = 404;
    public $body = '';
}

class HttpHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        $response->body = "Response displaying " . $request->attributes['ctrl'];
        
        return $response;
    }
}

class ControllerActionMiddleWare implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (\key_exists('ctrl', $request->attributes)) {
        }
        
        return $handler->handle($request);
    }
}

class JsonActionMiddleWare implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (\key_exists('json', $request->attributes)) {
        }
        
        return $handler->handle($request);
    }
}

// use
$httpRequest = new ServerRequest();
$httpRequest->headers['XML'] = true;
$httpRequest->attributes['ctrl'] = 'UserController';

$httpHandler = new HttpHandler();
$response = $httpHandler->handle($httpRequest);
return $response->body === 'Response displaying UserController';
