<?php

namespace BLOG\Domain\Services;

use BLOG\Domain\Models\Author;
use BLOG\Domain\Models\Post;
use Doctrine\ORM\EntityManager;

class PostsIndexService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function handle()
    {
        try {
            $posts = $this->em->getRepository(Post::class)->findAll();

            foreach($posts as $post){
                $dataPosts[] = [
                    "id"      => $post->id,
                    "title"   => $post->title,
                    "body"    => $post->body,
                    "slug"    => $post->slug,
                    "image"   => $post->image,
                    "author"  => $this->getAuthor($post->author),
                    "tags"    => $post->tags->getValues(),
                ];
            }

            return [
              "data"         => $dataPosts,
              "message"      => "sucess",
              "status_error" => false,
              "code"         => 200
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

    /**
     * @param $data
     * @return mixed
     */
    public function getAuthor ($data)
    {
        $author = $this->em->getRepository(Author::class)->findOneBy(['id'=>$data->id]);
        return $author->name;
    }

}