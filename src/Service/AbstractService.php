<?php

namespace Mobileia\Expressive\Mail\Service;

/**
 * Description of AbstractService
 *
 * @author matiascamiletti
 */
abstract class AbstractService
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
    public $name = 'AgencyCoda';
    /**
     *
     * @var string
     */
    public $replyTo = '';
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
    abstract protected function createService();
    
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
