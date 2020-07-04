<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use Mail;

class PagesController extends Controller
{
    // view about
    public function about() {
    	return view('about');
    }

    // view contact
    public function contact() {
    	return view('contact');
    }

    // send mail
    public function mail(ContactRequest $request) {
    	$dataArray = $request->all();

    	Mail::send(array('text' => 'email.message'), $dataArray, function($message) use ($dataArray) {
    		$message->to($dataArray["email"])->subject($dataArray["title"]);
    	});

    	return redirect()->route('home');
    }
}
