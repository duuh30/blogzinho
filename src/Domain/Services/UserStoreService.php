<?php

namespace BLOG\Domain\Services;

use Valitron\Validator;
use BLOG\Domain\Models\User;
use Doctrine\ORM\EntityManager;
use BLOG\Domain\Messages\ValidationMessage;


class UserStoreService
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
     * @var User
     */
    protected $model;

    /**
     * UserStoreService constructor.
     * @param EntityManager $em
     * @param Validator $validator
     */
    public function __construct(EntityManager $em, Validator $validator)
    {
        $this->em         = $em;
        $this->validator  = $validator;
        $this->model      = new User();
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

            if($this->exists($request->getParams()))
                throw new \Exception('user already exists', '409');


            $this->em->persist($this->model->parse($request->getParams()));
            $this->em->flush();

            return [
                "data" => [
                    "message"  => "user successfully registered",
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

    /**
     * @return array
     */
    protected function rules()
    {
        return [
            'name'     => ['required'],
            'email'    => ['required','email'],
            'password' => ['required'],
        ];
    }//end function rules()

    public function exists ($data)
    {
        return $this->em->getRepository(User::class)
            ->findOneBy(['email'=>$data["email"]]) ? true : false;
    }//end function exists()

}//end class