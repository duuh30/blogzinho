# BlogChallenge

A simple and intuitive Blog API

## Requeriments
<pre>
PHP >= 7.1
MySQL Server
Composer
</pre>

## Composer Install
<pre>
https://getcomposer.org/doc/00-intro.md#locally
</pre>

## Install

<pre>
git clone https://github.com/duuh30/blogzinho.git
cd blog-challange
composer install
</pre>

## Setup your database

You must create a <code>.env</code> file in your root directory to set up an important environment variables: <strong>DATABASE</strong>.

Some like that:
<pre>
# Blog-challange/.env.example
</pre>

<em>You can define others environment variables. <a href="#env-variables">See below</a>!</em>


## Generate Schema
MySQL Driver 
<pre>
mysql --version OR
sudo apt-get update
sudo apt-get install mysql-server
mysql_secure_installation
Testing Server - systemctl status mysql.service
</pre>
## Create your database name equals .env
<pre>
Ex : blog  .env DB_NAME="blog"
</pre>
## Generate Tables
<pre>
vendor/bin/doctrine orm:schema-tool:create
</pre>


## .env variables

<ul>
  <li>DB_HOST="YOUR_HOST"</li>
  <li>DB_PORT="YOUR_PORT"</li>
  <li>DB_NAME="YOUR_DB_NAME"</li>
  <li>DB_USER="YOUR_DB_USER"</li>
  <li>DB_PASS="YOUR_DB_PASS"</li>
<ul>


## Blog API Ready!

Now, you can start the Blog API!

<pre>
composer start
</pre>
Access http://localhost:8080! Blog is ready.

## Routes
<pre>
POST  http://localhost:8080/users
POST  http://localhost:8080/login
POST  http://localhost:8080/tags  < Authenticated
POST  http://localhost:8080/posts < Authenticated
GET   http://localhost:8080/tags
GET   http://localhost:8080/posts
</pre>

## Authenticate
To authenticate you need a registered user. To make a POST request for
<pre>
POST  http://localhost:8080/users
</pre>

Body
<pre>
name, email, password
</pre>

Error:
<pre>
{
    "error": {
        "data": null,
        "message": {
            "name": [
                "Name é obrigatório"
            ],
            "email": [
                "Email é obrigatório",
                "Email não é um email válido"
            ],
            "password": [
                "Password é obrigatório"
            ]
        },
        "code": 422
    },
    "status_error": true
}
</pre>

Success
<pre>
{
    "data": {
        "message": "user successfully registered",
        "code": 201
    },
    "status_error": false
}
</pre>

Login
<pre>
POST  http://localhost:8080/login
</pre>

Error:
<pre>
{
    "error": {
        "data": null,
        "message": {
            "email": [
                "Email é obrigatório",
                "Email não é um email válido"
            ],
            "password": [
                "Password é obrigatório"
            ]
        },
        "code": 422
    },
    "status_error": true
}
</pre>

Success
<pre>
{
    "data": {
        "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjcmVhdGVkX2F0IjoxNTUyMzAxOTY0LCJleHBpcmVfYXQiOjE1NTIzMjU5NjQsImlkIjoxfQ.Fe9HWrB00w7r0buaanqJuZFSxNl_5DtsxaPChs8lsZI"
    },
    "message": "success",
    "code": 200,
    "status_error": false
}
</pre>

## Create a Tags and Posts
<pre>
POST  http://localhost:8080/tags
</pre>
Unauthenticated
<pre>
Status Code 401
</pre>

Copy this JWT Login Success

Headers
<pre>
Authorization : paste_token
</pre>

Body
<pre>
name
</pre>

Error
<pre>
{
    "error": {
        "data": null,
        "message": {
            "name": [
                "Name é obrigatório"
            ]
        },
        "code": 422
    },
    "status_error": true
}
</pre>

Success
<pre>
{
    "data": {
        "message": "tag successfully registered",
        "code": 201
    },
    "status_error": false
}
</pre>

List all Tags
<pre>
GET http://localhost:8080/tags
</pre>

Create Post
<pre>
POST http://localhost:8080/posts
</pre>
Headers
<pre>
Authorization: paste_token
</pre>

Body
<pre>
title, slug, body,author_name
</pre>

Error
<pre>{
         "error": {
             "data": null,
             "message": {
                 "title": [
                     "Title é obrigatório"
                 ],
                 "slug": [
                     "Slug é obrigatório"
                 ],
                 "body": [
                     "Body é obrigatório"
                 ],
                 "author_name": [
                     "Author Name é obrigatório"
                 ]
             },
             "code": 422
         },
         "status_error": true
     }

</pre>
Success
<pre>
{
    "data": {
        "message": "post successfully registered",
        "code": 201
    },
    "status_error": false
}
</pre>

List all Posts
<pre>
GET http://localhost:8080/posts
</pre>

Create Posts with tags

body
<pre>
  title,slug,body,author_name,tags[tag_id],tags[tag_id]...
</pre>

Success
<pre>
{
    "data": {
        "message": "post successfully registered",
        "code": 201
    },
    "status_error": false
}
</pre>
## LICENSE

The MIT License (MIT)
