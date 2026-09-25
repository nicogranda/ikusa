<?php

namespace Src\Domains\RelatedParty;

use Src\Shared\Model;

class RelatedParty extends Model
{
    protected string $table = 'related_parties';

    public function getByCompany(int $companyId)
    {
        return $this->where('company_id', $companyId);
    }
}