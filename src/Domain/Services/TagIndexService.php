<?php

namespace BLOG\Domain\Services;

use BLOG\Domain\Models\Tag;
use Doctrine\ORM\EntityManager;


class TagIndexService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function handle()
    {
        try {
            return [
              "data"         => $this->parseTags(),
              "message"      => "sucess",
              "status_error" => false
            ];
        } catch(\Exception $e){
            return [
                "error" => [
                    "data"         => null,
                    "message"      => $e->getMessage(),
                ],
                "status_error" => true,
            ];
        }
    }

    public function parseTags () {
       $query = "SELECT * FROM tags";

       $st = $this->em->getConnection()->prepare($query);
       $st->execute();
       return $st->fetchAll();
    }
}