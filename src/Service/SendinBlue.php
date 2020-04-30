<?php

namespace Mobileia\Expressive\Mail\Service;

/**
 * Description of SendinBlue
 *
 * @author matiascamiletti
 */
class SendinBlue extends AbstractService
{
    /**
     *
     * @var \SendinBlue\Client\Api\SMTPApi
     */
    public $apiInstance = null;
    
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
        $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail();
        $sendSmtpEmail->setSubject($subject);
        
        $toEmail = new \SendinBlue\Client\Model\SendSmtpEmailTo();
        $toEmail->setEmail($addTo);
        $sendSmtpEmail->setTo([$toEmail]);
        
        $sendSmtpEmail->setHtmlContent($this->view->render($this->getViewModel($template, $params)));
        
        // Asignamos si contiene email puro texto.
        if($textWithoutHtml != ''){
            $sendSmtpEmail->setTextContent($textWithoutHtml);
        }
        
        $sendSmtpEmail->setReplyTo($this->replyTo);
        // Enviamos Email
        return $this->apiInstance->sendTransacEmailAsync($sendSmtpEmail);
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
        // Configure API key authorization: api-key
        $config = \SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->apiKey);
        $this->apiInstance = new \SendinBlue\Client\Api\SMTPApi(new \GuzzleHttp\Client(), $config);
    }
}
