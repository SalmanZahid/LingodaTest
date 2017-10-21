<?php

namespace LingodaBundle\BusinessObject;

use LingodaBundle\Interfaces\BusinessObject\IBusinessObject;
use Symfony\Component\Validator\Constraints as Assert;
use LingodaBundle\Entity;

class InquiryBusinessObject implements IBusinessObject
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "Your name cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank(message="Please provide email address")
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "Your email address cannot be longer than {{ limit }} characters"
     * )
     */
    private $email;

    /**
     * @var string
     * @Assert\NotBlank(message="Please provide message")
     * @Assert\Length(
     *      max = 1000,
     *      maxMessage = "Your message cannot be longer than {{ limit }} characters"
     * )
     */
    private $message;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param int $id
     * @return InquiryBusinessObject
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return InquiryBusinessObject
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return InquiryBusinessObject
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return InquiryBusinessObject
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $model Entity\Inquiry
     */
    public function mapDataToModel($model)
    {
        $model->setName($this->getName());
        $model->setEmail($this->getEmail());
        $model->setMessage($this->getMessage());
    }

    /**
     * @param $model Entity\Inquiry
     */
    public function mapDataFromModel($model)
    {
        $this->setId($model->getId());
        $this->setName($model->getName());
        $this->setEmail($model->getEmail());
        $this->setMessage($model->getMessage());
    }
}