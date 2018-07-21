<?php 

declare(strict_types=1);

namespace Mobileia\Expressive\Email\Factory;

use Psr\Container\ContainerInterface;

class SendgridFactory 
{
    public function __invoke(ContainerInterface $container) : \Mobileia\Expressive\Email\Service\Sendgrid
    {
        // Obtenemos configuracion
        $config = $container->get('config')['sendgrid'];
        // creamos libreria
        return new \Mobileia\Expressive\Email\Service\Sendgrid($config['sendgrid']);
    }
}