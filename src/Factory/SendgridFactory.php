<?php 

declare(strict_types=1);

namespace Mobileia\Expressive\Mail\Factory;

use Psr\Container\ContainerInterface;

class SendgridFactory 
{
    public function __invoke(ContainerInterface $container) : \Mobileia\Expressive\Mail\Service\Sendgrid
    {
        // Obtenemos configuracion
        $config = $container->get('config')['sendgrid'];
        // creamos libreria
        return new \Mobileia\Expressive\Mail\Service\Sendgrid($config);
    }
}