<?php

namespace BLOG\Domain\Services;

use BLOG\Domain\Models\Tag;
use mysql_xdevapi\Exception;
use Valitron\Validator;
use BLOG\Domain\Models\Post;
use BLOG\Domain\Models\Author;
use Doctrine\ORM\EntityManager;
use BLOG\Domain\Messages\ValidationMessage;

class PostsStoreService
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
        $this->model      = new Post();
    }//end function constructor()

    /**
     * @param $request
     * @return array|ValidationMessage
     */
    public function handle($request)
    {
        try {
            $author = new Author();
            $validator = $this->validator->withData($request->getParams());
            $validator->mapFieldsRules($this->rules());
            if (!$validator->validate()) return new ValidationMessage($validator->errors());


            $this->em->persist($author->parse($request->getParams()));
            $this->em->flush();

            $this->em->persist($this->model->parse($request->getParams(),
                $this->em->getRepository(Author::class)->findOneBy(['id'=>$author->id])));
            $this->em->flush();


            if($request->getParam('tags') >= 1) {
                foreach ($request->getParam('tags') as $tag) {
                    $this->insertTags( $tag, $this->model->id);
                }
            }

            return [
                "data" => [
                    "message"  => "post successfully registered",
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
     * @param $tag
     * @param $post
     * @throws \Doctrine\DBAL\DBALException
     */
    public function insertTags($tag,$post)
    {
        $searchTag = "SELECT * FROM tags WHERE id = {$tag}";
        $stTag = $this->em->getConnection()->prepare($searchTag);
        $stTag->execute();
        if (!$stTag->fetchAll()) throw new \Exception('invalid tag');
        $query = "INSERT INTO post_tag (post_id,tag_id) VALUES ({$post},{$tag})";
        $st = $this->em->getConnection()->prepare($query);
        $st->execute();
    }

    /**
     * @return array
     */
    protected function rules()
    {
        return [
            'title'        => ['required'],
            'slug'         => ['required'],
            'body'         => ['required'],
            'author_name'  => ['required']
        ];
    }
}