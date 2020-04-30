<?php

namespace Mobileia\Expressive\Mail\Factory;

use Psr\Container\ContainerInterface;

/**
 * Description of SendinBlueHandlerFactory
 *
 * @author matiascamiletti
 */
class SendinBlueHandlerFactory
{
    public function __invoke(ContainerInterface $container) : \Mobileia\Expressive\Mail\Handler\SendinBlueHandler
    {
        // Creamos servicio
        $service   = $container->get(\Mobileia\Expressive\Mail\Service\SendinBlue::class);
        // Generamos el handler
        return new \Mobileia\Expressive\Mail\Handler\SendinBlueHandler($service);
    }
}
