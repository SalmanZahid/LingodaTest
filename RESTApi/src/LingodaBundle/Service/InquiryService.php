<?php

namespace LingodaBundle\Service;


use LingodaBundle\BusinessObject\InquiryBusinessObject;
use LingodaBundle\Entity\Inquiry;
use LingodaBundle\Interfaces\Repository\IInquiryRepository;
use LingodaBundle\Interfaces\Service\IInquiryService;
use LingodaBundle\Repository\RepositoryCodes;


class InquiryService implements IInquiryService
{
    /**
     * @var IInquiryRepository
     */
    private $repository;

    /**
     * InquiryService constructor.
     * @param IInquiryRepository $inquiryRepository
     */
    public function __construct(IInquiryRepository $inquiryRepository)
    {
        $this->repository = $inquiryRepository;
    }

    /**
     * @param InquiryBusinessObject $inquiryBusinessObject
     * @return string
     */
    public function CreateInquiry(InquiryBusinessObject $inquiryBusinessObject)
    {
        try {

            $inquiry = new Inquiry();
            $inquiryBusinessObject->mapDataToModel($inquiry);
            $response = $this->repository->AddInquiry($inquiry);

            if($response === RepositoryCodes::INQUIRY_CREATE_SUCCESSFUL)
                return ServiceCodes::INQUIRY_CREATE_SUCCESSFUL;

            return ServiceCodes::INQUIRY_CREATE_FAILED;

        } catch (\Exception $ex){
            return ServiceCodes::INQUIRY_CREATE_FAILED;
        }
    }
}