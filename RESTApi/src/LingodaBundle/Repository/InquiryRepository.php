<?php

namespace LingodaBundle\Repository;

use LingodaBundle\Entity\Inquiry;
use LingodaBundle\Interfaces\Repository\IInquiryRepository;
use Doctrine\ORM\EntityManager;

/**
 * InquiryRepository
 */
class InquiryRepository  implements IInquiryRepository
{
    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Inquiry $inquiry
     * @return string
     */
    public function AddInquiry(Inquiry $inquiry)
    {
        try {
            $this->em->persist($inquiry);
            $this->em->flush();
            return RepositoryCodes::INQUIRY_CREATE_SUCCESSFUL;
        } catch (\Exception $ex){
            return RepositoryCodes::INQUIRY_CREATE_FAILED;
        }
    }
}
