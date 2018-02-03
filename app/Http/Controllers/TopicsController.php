<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    //话题列表
	public function index(Request $request, Topic $topic)
	{
        $topics = $topic->withOrder($request->order)->paginate(20);
		return view('topics.index', compact('topics'));
	}

	//话题展示
    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

    //显示话题创建页面
	public function create(Topic $topic)
	{
	    $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	//执行话题创建动作
	public function store(TopicRequest $request, Topic $topic)
	{
	    $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();
		return redirect()->route('topics.show', $topic->id)->with('message', '话题创建成功');
	}

	//显示话题修改页面
	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	//执行话题更新动作
	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', '更新成功！.');
	}

	//话题删除
	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}

	public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        $data = [
            'success' => 'false',
            'msg' => '图片上传失败！',
            'file_path' => '',
        ];
        
        if($file = $request->upload_file){
            $res = $uploader->save($file, 'topics', Auth::user()->id, 1024);

            if($res){
                $data['success'] = 'true';
                $data['msg'] = '图片上传成功';
                $data['file_path'] = $res['path'];
            }
        }

        return $data;
    }
}