<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Http\Requests\ReplyRequest;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function store(ReplyRequest $request, Reply $reply)
	{
        $reply->content = $request->contents;
        $reply->user_id = Auth::id();
        $reply->topic_id = $request->topic_id;
		$reply->save();

        return redirect()->to($reply->topic->link())->with('message', '回复成功');
	}

	public function destroy(Reply $reply)
	{

        //如果是话题的作者 || 话题的回复者
        if( $reply->topic->id == Auth::id() || $reply->user_id == Auth::id()){

            $reply->delete();
            //话题回复数减1
            $reply->topic->decrement('reply_count', 1);

            return redirect()->back()->with('message', '删除成功！');
        }
        return redirect()->back()->with('danger', '无权限！');
	}
}