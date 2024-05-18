<?php

namespace App\Http\Controllers;

use App\Http\Requests\PagesRequest;
use App\Models\Pages;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $page = 'active';

    public function index()
    {
        $pages = Pages::paginate(10);
        return view('pages.index', ["pages"=>$pages, 'page_page'=>$this->page]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.create', ['page_page'=>$this->page]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PagesRequest $request)
    {
        $page = new Pages();
        $page->name = $request->name;
        $page->title = $request->title;
        $page->description = $request->description;
        $page->save();
        return redirect()->route('pages.index')->with('status', 'Successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $page = Pages::find($id);
        return view('pages.show', ["page"=>$page, 'page_page'=>$this->page]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $page = Pages::find($id);
        return view('pages.edit', ["page"=>$page, 'page_page'=>$this->page]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PagesRequest $request, string $id)
    {
        $page = Pages::find($id);
        $page->name = $request->name;
        $page->title = $request->title;
        $page->description = $request->description;
        $page->save();
        return redirect()->route('pages.index')->with('status', 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = Pages::find($id);
        $page->delete();
        return redirect()->route('pages.index')->with('status', 'Successfully deleted');
    }
}
