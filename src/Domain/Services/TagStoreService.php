<?php

namespace BLOG\Domain\Services;

use BLOG\Domain\Models\Tag;
use Valitron\Validator;
use BLOG\Domain\Models\Post;
use Doctrine\ORM\EntityManager;
use BLOG\Domain\Messages\ValidationMessage;

class TagStoreService
{
    /**
     * @var EntityManager
     */
    protected $em;
    /**
     * @var Validator
     */
    protected $validator;
    /**
     * @var Post
     */
    protected $model;

    /**
     * PostsStoreService constructor.
     * @param EntityManager $em
     * @param Validator $validator
     */
    public function __construct(EntityManager $em, Validator $validator)
    {
        $this->em         = $em;
        $this->validator  = $validator;
        $this->model      = new Tag();
    }//end function constructor()

    /**
     * @param $request
     * @return array|ValidationMessage
     */
    public function handle($request)
    {
        try {

            $validator = $this->validator->withData($request->getParams());
            $validator->mapFieldsRules($this->rules());
            if (!$validator->validate()) return new ValidationMessage($validator->errors());

            $this->em->persist($this->model->parse($request->getParams()));
            $this->em->flush();

            return [
                "data" => [
                    "message"  => "tag successfully registered",
                    "code"     => 201
                ],
                "status_error" => false,
            ];

        } catch(\Exception $e){
            return [
                "error" => [
                    "data"         => null,
                    "message"      => $e->getMessage(),
                    "code"         => $e->getCode(),
                ],
                "status_error" => true,
            ];
        }
    }//end function handle()

    protected function rules()
    {
        return [
            'name' => ['required']
        ];
    }
}