<?php

namespace App\Repositories;

use App\Interfaces\LinkRepositoryInterface;
use App\Models\Link;

class LinkRepository implements LinkRepositoryInterface
{
    public function getAllLinks()
    {
        return Link::orderBy('id','DESC')->get();
    }

    public function createLinks(array $linkRequestData)
    {
        return Link::create($linkRequestData);
    }

    public function getLinkByHashKey($hashkey)
    {
        return Link::where('hashKey', $hashkey)->first();
    }
}
