<?php

declare(strict_types=1);

namespace Mobileia\Expressive\Mail\Service;

use Zend\View\Model\ViewModel;

/**
 * Description of Sendgrid
 *
 * @author matiascamiletti
 */
class Sendgrid 
{
    /**
     *
     * @var string
     */
    public $apiKey = '';
    /**
     *
     * @var string
     */
    public $from = 'no-reply@mobileia.com';
    /**
     *
     * @var string
     */
    public $name = 'MobileIA';
    /**
     *
     * @var string
     */
    public $replyTo = '';
    /**
     *
     * @var \SendGrid 
     */
    public $service = null;
    /**
     *
     * @var string
     */
    public $templateFolder = '';
    /**
     * URL Base para las imagenes
     * @var string
     */
    public $baseUrl = '';
    /**
     *
     * @var \Zend\View\Renderer\PhpRenderer
     */
    public $view = null;
    
    public function __construct($config)
    {
        // Setear configuración inicial
        $this->setConfig($config);
        // Creamos el servicio
        $this->createService();
        // Creamos el servicio de vista
        $this->createView();
    }
    /**
     * 
     * @param string $addTo
     * @param string $subject
     * @param string $template
     * @param array $params
     * @param string $textWithoutHtml
     * @return type
     */
    public function sendWithFile($addTo, $subject, $template, $params, $fileUrl, $mimetype, $filename, $textWithoutHtml = '')
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($this->from, $this->name);
        $email->setSubject($subject);
        $email->addTo($addTo);
        $email->addContent(
            "text/html", $this->view->render($this->getViewModel($template, $params))
        );
        
        $file_encoded = base64_encode(file_get_contents($fileUrl));
        $email->addAttachment(
            $file_encoded,
            $mimetype,
            $filename,
            "attachment"
        );
        
        // Asignamos si contiene email puro texto.
        if($textWithoutHtml != ''){
            $email->addContent("text/plain", $textWithoutHtml);
        }
        // Enviamos Email
        return $this->service->send($email);
    }
    /**
     * 
     * @param string $addTo
     * @param string $copyTo
     * @param string $subject
     * @param string $template
     * @param array $params
     * @param string $textWithoutHtml
     * @return type
     */
    public function sendWithCopy($addTo, $copyTo, $subject, $template, $params, $textWithoutHtml = '')
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($this->from, $this->name);
        $email->setSubject($subject);
        $email->addTo($addTo);
        $email->addContent(
            "text/html", $this->view->render($this->getViewModel($template, $params))
        );
        $email->addCc($copyTo);
        
        // Asignamos si contiene email puro texto.
        if($textWithoutHtml != ''){
            $email->addContent("text/plain", $textWithoutHtml);
        }
        // Enviamos Email
        return $this->service->send($email);
    }
    /**
     * 
     * @param \SendGrid\Mail\Mail $email
     * @param string $template
     * @param array $params
     * @param string $textWithoutHtml
     * @return type
     */
    public function sendWithObject(\SendGrid\Mail\Mail $email, $template, $params, $textWithoutHtml = '')
    {
        $email->setFrom($this->from, $this->name);
        $email->addContent(
            "text/html", $this->view->render($this->getViewModel($template, $params))
        );
        
        // Asignamos si contiene email puro texto.
        if($textWithoutHtml != ''){
            $email->addContent("text/plain", $textWithoutHtml);
        }
        // Enviamos Email
        return $this->service->send($email);
    }
    /**
     * 
     * @param string $addTo
     * @param string $subject
     * @param string $template
     * @param array $params
     * @param string $textWithoutHtml
     * @return type
     */
    public function send($addTo, $subject, $template, $params, $textWithoutHtml = '')
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($this->from, $this->name);
        $email->setSubject($subject);
        $email->addTo($addTo);
        $email->addContent(
            "text/html", $this->view->render($this->getViewModel($template, $params))
        );
        
        // Asignamos si contiene email puro texto.
        if($textWithoutHtml != ''){
            $email->addContent("text/plain", $textWithoutHtml);
        }
        // Enviamos Email
        return $this->service->send($email);
    }
    /**
     * Crea el View Model para generar el HTML
     * @param string $template
     * @param array $vars
     * @return ViewModel
     */
    public function getViewModel($template, $vars)
    {
        // Creamos view model
        $viewModel = new \Zend\View\Model\ViewModel();
        $viewModel->setTemplate($template)->setVariables(array_merge(array('baseUrl' => $this->baseUrl), $vars));
        // Devolvemos view model
        return $viewModel;
    }
    /**
     * 
     * @param string $template
     * @return \Zend\View\Resolver\TemplateMapResolver
     */
    protected function getResolver($template)
    {
        $resolver = new \Zend\View\Resolver\TemplateMapResolver();
        $resolver->setMap(array($template => $this->templateFolder . $template));
        return $resolver;
    }
    /**
     * 
     * @return \Zend\View\Resolver\TemplatePathStack
     */
    protected function getResolverStack()
    {
        return new \Zend\View\Resolver\TemplatePathStack(['script_paths' => [$this->templateFolder]]);
    }
    /**
     * Funcion que se encarga de crear el ViewRender
     */
    protected function createView()
    {
        // Creamos View Render
        $this->view = new \Zend\View\Renderer\PhpRenderer();
        // Creamos resolver
        $this->view->setResolver($this->getResolverStack());
    }
    /**
     * Funcion que se encarga de crear el servicio
     * @return boolean
     */
    protected function createService()
    {
        // Verificamos que se haya cargado una API_KEY
        if($this->apiKey == ''){
            return false;
        }
        // Creamos el servicio
        $this->service = new \SendGrid($this->apiKey);
    }
    /**
     * 
     * @return \SendGrid 
     */
    public function getService()
    {
        return $this->service;
    }
    /**
     * Funcion que se encarga de obtener los parametros necesarios
     * @param array $config
     */
    public function setConfig($config)
    {
        if(array_key_exists('api_key', $config)){
            $this->apiKey = $config['api_key'];
        }
        if(array_key_exists('from', $config)){
            $this->from = $config['from'];
        }
        if(array_key_exists('name', $config)){
            $this->name = $config['name'];
        }
        if(array_key_exists('reply_to', $config)){
            $this->replyTo = $config['reply_to'];
        }
        if(array_key_exists('template_folder', $config)){
            $this->templateFolder = $config['template_folder'];
        }
        if(array_key_exists('base_url', $config)){
            $this->baseUrl = $config['base_url'];
        }
    }
}