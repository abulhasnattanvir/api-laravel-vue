<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class PostService
{
    protected $baseUrl = 'https://dummyjson.com';

    public function all()
    {
        return Http::get("$this->baseUrl/posts")->json();
    }

    public function store($data)
    {
        return Http::post("$this->baseUrl/posts/add", $data)->json();
    }

    public function update($id, $data)
    {
        return Http::put("$this->baseUrl/posts/$id", $data)->json();
    }

    public function delete($id)
    {
        return Http::delete("$this->baseUrl/posts/$id")->json();
    }
    
    public function login($data)
    {
        return Http::post("$this->baseUrl/auth/login", $data)->json();
    }

    public function me($token)
    {
        return Http::withToken($token)
            ->get("$this->baseUrl/auth/me")
            ->json();
    }
}