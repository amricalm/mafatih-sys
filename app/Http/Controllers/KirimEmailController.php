<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Mail;

class KirimEmailController extends Controller
{
    public function send()
    {
        $details = [
            'judul' => 'Email dari Ilmucoding.com',
            'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit deserunt laborum dolores at officia blanditiis commodi cupiditate nobis, totam quibusdam ullam numquam hic dolorem fugiat exercitationem consectetur, quia praesentium quas!'
        ];

        try {
            \Mail::to('muhginanjar@gmail.com')->send(new \App\Mail\Email($details));
            echo "Email berhasil dikirim.";

        } catch(\Exception $e){
            echo "Email gagal dikirim karena $e.";
        }


    }
}
