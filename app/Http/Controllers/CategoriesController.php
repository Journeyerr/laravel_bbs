<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Link;
use App\Models\Topic;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category, Link $link)
    {
        //读取分类 id 关联的话题 并20分页
        $topics = Topic::where('category_id', $category->id)->with('user', 'category')->paginate(20);

        // 资源链接
        $links = $link->getAllCached();

        //显示模板传递参数
        return view('topics.index', compact('topics', 'category', 'links'));
    }
}
