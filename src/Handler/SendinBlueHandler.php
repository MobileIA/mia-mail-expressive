<?php

namespace Mobileia\Expressive\Mail\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Description of SendinBlueHandler
 *
 * @author matiascamiletti
 */
class SendinBlueHandler implements MiddlewareInterface
{
    /**
     * @var \Mobileia\Expressive\Mail\Service\SendinBlue
     */
    private $service;

    public function __construct(\Mobileia\Expressive\Mail\Service\SendinBlue $sending) {
        $this->service = $sending;
    }
    
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        // Enviar servicio como atributo
        return $handler->handle($request->withAttribute('SendinBlue', $this->service));
    }
}