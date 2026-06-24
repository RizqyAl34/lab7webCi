<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function home()
    {
        return view('home', [
            'title' => 'Halaman Home',
            'content' => 'Ini adalah halaman Home yang menjelaskan tentang isi halaman ini.'
        ]);
    }

    public function about()
    {
        return view('about', [
            'title' => 'Halaman About',
            'content' => 'Ini adalah halaman about yang menjelaskan tentang isi halaman ini.'
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'title' => 'Halaman Contact',
            'content' => 'Ini adalah halaman contact.'
        ]);
    }

    public function artikel()
    {
        return view('artikel', [
            'title' => 'Halaman Artikel',
            'content' => 'Ini adalah halaman artikel.'
        ]);
    }

    public function faqs()
    {
        return view('faqs', [
            'title' => 'Halaman FAQ',
            'content' => 'Ini adalah halaman FAQ.'
        ]);
    }

    public function tos()
    {
        return view('tos', [
            'title' => 'Halaman Term of Services',
            'content' => 'Ini adalah halaman Term of Services.'
        ]);
    }
}