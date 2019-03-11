<?php

namespace BLOG\Domain\Messages;

class ValidationMessage
{
     protected $errors;

     public function __construct(array $errors)
     {
        $this->errors = $errors;
     }

     public function toArray()
     {
        return [
            'error' => [
                'data' => null,
                'message' => $this->errors,
                'code'    => 422
            ],
            'status_error' => true
        ];    
     }
}