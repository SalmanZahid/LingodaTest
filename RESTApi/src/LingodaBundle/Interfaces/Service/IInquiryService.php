<?php

namespace LingodaBundle\Interfaces\Service;

use LingodaBundle\BusinessObject\InquiryBusinessObject;

interface IInquiryService
{
    public function CreateInquiry(InquiryBusinessObject $inquiryBusinessObject);
}