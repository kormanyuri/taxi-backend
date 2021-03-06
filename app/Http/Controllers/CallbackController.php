<?php

namespace App\Http\Controllers;

use App\Callback;
use App\Mail\CallbackMail;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class CallbackController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Callback::all();
        return response()->view('callbacks', ['items' => $items]);
    }

    /**
     * @param Request $request
     */
    public function save(Request $request)
    {
        $callback = new Callback();
        $callback->name = $request->get('name');
        $callback->phone = $request->get('phone');
        $callback->email = $request->get('email');

        $callback->save();

        $mail = new Mailable();

        // send email
        Mail::to(env('EMAIL_TO'))->send(new CallbackMail($callback));
    }
}
