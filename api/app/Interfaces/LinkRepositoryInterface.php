<?php
namespace App\Interfaces;

interface LinkRepositoryInterface
{
    public function getAllLinks();
    public function createLinks(array $linkRequestData);
    public function getLinkByHashKey($hashKey);
}
