<?php
namespace App\Services;

use Hashids\Hashids;

class Hashid
{
    protected $hashids;

    public function __construct(array $config = [])
    {
        $this->hashids = new Hashids(
            $config['salt'],
            $config['min'],
            'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        );
    }

    public function encode($data): string
    {
        return $this->hashids->encode($data);
    }

    public function decode($data)
    {
        return $this->hashids->decode($data);
    }
}
