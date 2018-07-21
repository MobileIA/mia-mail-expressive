<?php

namespace Mobileia\Expressive\Mail\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Description of SendgridHandler
 *
 * @author matiascamiletti
 */
class SendgridHandler implements MiddlewareInterface
{
    /**
     * @var \Mobileia\Expressive\Mail\Service\Sendgrid
     */
    private $service;

    public function __construct(\Mobileia\Expressive\Mail\Service\Sendgrid $sendgrid) {
        $this->service = $sendgrid;
    }
    
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        // Enviar servicio como atributo
        return $handler->handle($request->withAttribute('Sendgrid', $this->service));
    }
}