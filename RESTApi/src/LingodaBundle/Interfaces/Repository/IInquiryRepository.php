<?php

namespace LingodaBundle\Interfaces\Repository;

use LingodaBundle\Entity\Inquiry;


interface IInquiryRepository
{
    public  function AddInquiry(Inquiry $inquiry);
}