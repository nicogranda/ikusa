<?php

namespace Src\Domains\Shareholder;

use Src\Shared\Model;

class Shareholder extends Model
{
    protected string $table = 'shareholders';

    public function getByCompany(int $companyId)
    {
        return $this->where('company_id', $companyId);
    }
}