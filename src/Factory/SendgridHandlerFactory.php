<?php

declare(strict_types=1);

namespace Mobileia\Expressive\Mail\Factory;

use Psr\Container\ContainerInterface;

/**
 * Description of SendgridHandlerFactory
 *
 * @author matiascamiletti
 */
class SendgridHandlerFactory 
{
    public function __invoke(ContainerInterface $container) : \Mobileia\Expressive\Mail\Handler\SendgridHandler
    {
        // Creamos servicio
        $service   = $container->get(\Mobileia\Expressive\Mail\Service\Sendgrid::class);
        // Generamos el handler
        return new \Mobileia\Expressive\Mail\Handler\SendgridHandler($service);
    }
}