<?php

namespace Phpatterns\Psr;

/**
 * PSR-15 common interfaces for HTTP server request handlers
 * @see https://www.php-fig.org/psr/psr-15/meta/
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
 * 
 * @see https://docs.guzzlephp.org/en/latest/handlers-and-middleware.html
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

        $middle = array_pop($this->stack);
        $response = $middle ? $middle->process($request, $this) : $defaultResponse;
        
        return $response;
    }
}

class XmlActionMiddleWare implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        
        if ('application/pdf' === $request->headers['Type']) {
            $response->body .= '<pdf>placeholder</pdf>';
        } else {
            $response->body .= '<body>placeholder</body>';
        }
        
        return $response;
    }
}

class ContentActionMiddleWare implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        
        if ('application/pdf' === $request->headers['Type']) {
            $response->body = str_replace('placeholder', 'Reader content', $response->body);
        } else {
            $response->body = str_replace('placeholder', 'Website content html', $response->body);
        }
        
        return $response;
    }
}

// use
$httpRequest = new ServerRequest();
$httpRequest->headers['Type'] = 'application/pdf';

$httpHandler = new HttpHandler([
    new XmlActionMiddleWare(),
    new ContentActionMiddleWare(),
    // ...
]);
$response = $httpHandler->handle($httpRequest);

return $response->body === '<pdf>Reader content</pdf>';
