<?php

namespace BLOG\Domain\Services;

use BLOG\Domain\Models\User;
use Doctrine\ORM\EntityManager;
use Valitron\Validator;
use BLOG\Domain\Messages\ValidationMessage;



class LoginService
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
     * LoginService constructor.
     * @param EntityManager $em
     * @param Validator $validator
     */
    public function __construct(EntityManager $em, Validator $validator)
    {
        $this->em         = $em;
        $this->validator  = $validator;
        $this->model      = new User;
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

            $searchUser = $this->exists($request->getParams());
            if(!$searchUser) throw new \Exception('user not found', 404);

            return $this->model->comparePassword($searchUser, $request->getParam('password'));
        } catch(\Exception $e){
            return [
                "error" => [
                    "data"         => null,
                    "message"      => $e->getMessage(),
                    "code"         => $e->getCode()
                ],
                "status_error" => true,
            ];
        }
    }

    /**
     * @return array
     */
    protected function rules()
    {
        return [
            'email'        => ['required','email'],
            'password'     => ['required'],
        ];
    }

    public function exists ($data)
    {
        $user = $this->em->getRepository(User::class)
            ->findOneBy(['email'=>$data]);

        return $user ? $user : false;
    }//end function exists()

}