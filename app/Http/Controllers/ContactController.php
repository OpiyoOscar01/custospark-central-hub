<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\StandardEmail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);
            $body = <<<TEXT
            Name: {$validated['name']}
            Email: {$validated['email']}

            Message:
            {$validated['message']}
            TEXT;


        Mail::to('info@custospark.com')->send(new StandardEmail(
            title: 'New Contact Message from Custospark Website',
            mailBody: $body,
            tip: 'Respond to this message as soon as possible.',
            ctaUrl: 'mailto:' . $validated['email'],
            ctaLabel: 'Reply to Sender'
        ));

        return view('sections.message_success');
    }
}

