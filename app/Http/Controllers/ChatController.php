<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Message;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show chats
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('chat');
    }

    /**
     * Fetch all messages
     *
     * @param int $projectId
     * @return Message
     */
    public function fetchMessages($project)
    {
        $messages =  Message::with('user');

        return $messages;
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

        // $project = Project::find($request->input('project'));
        // $project->messages()->save($message);


        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }
}
