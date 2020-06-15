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
        
        $sender = new \SendinBlue\Client\Model\SendSmtpEmailSender();
        $sender->setEmail($this->from);
        $sender->setName($this->name);
        $sendSmtpEmail->setSender($sender);
        
        $toEmail = new \SendinBlue\Client\Model\SendSmtpEmailTo();
        $toEmail->setEmail($addTo);
        $sendSmtpEmail->setTo([$toEmail]);
        
        $sendSmtpEmail->setHtmlContent($this->view->render($this->getViewModel($template, $params)));
        
        // Asignamos si contiene email puro texto.
        if($textWithoutHtml != ''){
            $sendSmtpEmail->setTextContent($textWithoutHtml);
        }
        
        $reply = new \SendinBlue\Client\Model\SendSmtpEmailReplyTo();
        $reply->setEmail($this->replyTo);
        $reply->setName($this->name);
        $sendSmtpEmail->setReplyTo($reply);
        // Enviamos Email
        return $this->apiInstance->sendTransacEmail($sendSmtpEmail);
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
    public function sendWithFile($addTo, $subject, $template, $params, $fileUrl, $filename, $textWithoutHtml = '')
    {
        $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail();
        $sendSmtpEmail->setSubject($subject);
        
        $sender = new \SendinBlue\Client\Model\SendSmtpEmailSender();
        $sender->setEmail($this->from);
        $sender->setName($this->name);
        $sendSmtpEmail->setSender($sender);
        
        $toEmail = new \SendinBlue\Client\Model\SendSmtpEmailTo();
        $toEmail->setEmail($addTo);
        $sendSmtpEmail->setTo([$toEmail]);
        
        $sendSmtpEmail->setHtmlContent($this->view->render($this->getViewModel($template, $params)));
        
        $file = new \SendinBlue\Client\Model\SendSmtpEmailAttachment();
        $file->setName($filename);
        $file->setUrl($fileUrl);
        $sendSmtpEmail->setAttachment([$file]);
        
        // Asignamos si contiene email puro texto.
        if($textWithoutHtml != ''){
            $sendSmtpEmail->setTextContent($textWithoutHtml);
        }
        
        $reply = new \SendinBlue\Client\Model\SendSmtpEmailReplyTo();
        $reply->setEmail($this->replyTo);
        $reply->setName($this->name);
        $sendSmtpEmail->setReplyTo($reply);
        // Enviamos Email
        return $this->apiInstance->sendTransacEmail($sendSmtpEmail);
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
