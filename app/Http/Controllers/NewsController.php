<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
use App\Models\News;
use App\Settings\Site;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news_categories = Dropdown::active()->whereCategory(Dropdown::NEWS_CATEGORY)->get();

        $heading_news = News::active()
            ->where('heading_news', true)
            ->first();

        $category_id = \request('category_id');
        $page = \request('page');

        $news = News::active()
            ->where('id', '!=', $heading_news?->id)
            ->when($category_id, function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            })
            ->when($page, function ($query) use ($page) {
                $query->offset(($page - 1) * app(Site::class)->news_page_size);
            })
            ->paginate(app(Site::class)->news_page_size);

        return $this->view('News.index', compact('news', 'news_categories', 'heading_news'));
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, News $news)
    {
        $recent_news = News::active()
            ->limit(app(Site::class)->news_page_size)
            ->where('id', '!=' , $news->id)
            ->get();

        $next_post = News::active()->where('id', '>', $news->id)->first();
        $prev_post = News::active()->where('id', '<', $news->id)->first();

        return $this->view('News.show', compact('news', 'recent_news', 'next_post', 'prev_post'));
    }
}
