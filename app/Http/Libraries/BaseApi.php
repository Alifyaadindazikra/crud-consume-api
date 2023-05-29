<?php

namespace App\Http\Libraries;

use Illuminate\Support\Facades\Http;

class BaseApi
{ 
    //variabel cuman bisa di akses di class ini dan turunanya
    protected $baseUrl;//file sma kaya api host
    //constractor = menyiapkan isi data, dijlankan otomatis tanpa dipanggil
    public function __construct()
    {
        //var $baseurl nilainya isian evn apihost
        //var ini diisi otomatis ketika file/class base api dipanggil d controler 
        $this->baseUrl = "http://127.0.0.1:2222";
    }
    private function client()
    {
        //koneksikan ip dari var $baseurl ke depedency http
        //menggunakan depency http kaena project berbasis web(protocol http)
        return Http::baseUrl($this->baseUrl);
    }
    public function index(String $endpoint, Array $data = [])
    {
        //maggil ke func client yg diatas, trs mggil path yg dr $endpoint yg dikiirm controllernya, kalau ada yang 
        return $this->client()->get($endpoint, $data);
    }
    public function store(String $endpoint, Array $data=[])
    {
        //pake post()karna buat route tambh data di project rst api nya pake :post
        return $this->client()->post($endpoint, $data);
    }
    public function edit(String $endpoint, Array $data=[])
    {
        return $this->client()->get($endpoint, $data);
    }
    public function update(String $endpoint, Array $data=[])
    {
        //pake post()karna buat route tambh data di project rst api nya pake :post
        return $this->client()->patch($endpoint, $data);
    }
    public function delete(String $endpoint, Array $data=[])
    {
        //pake post()karna buat route tambh data di project rst api nya pake :post
        return $this->client()->delete($endpoint, $data);
    }
    public function trash(String $endpoint, Array $data=[])
    {
        return $this->client()->get($endpoint, $data);
    }
    public function restore(String $endpoint, Array $data=[])
    {
        return $this->client()->get($endpoint, $data);
    }
    public function permanent(String $endpoint, Array $data=[])
    {
        return $this->client()->get($endpoint, $data);
    }
}