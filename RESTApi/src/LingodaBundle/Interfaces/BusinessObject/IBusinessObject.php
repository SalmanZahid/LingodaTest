<?php

namespace LingodaBundle\Interfaces\BusinessObject;


interface IBusinessObject
{
    public function mapDataToModel($model);
    public function mapDataFromModel($model);
}