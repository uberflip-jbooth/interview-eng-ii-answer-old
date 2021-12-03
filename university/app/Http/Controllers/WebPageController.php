<?php

namespace App\Http\Controllers;

use App\Models\WebPage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WebPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        return WebPage::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $webpage = WebPage::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WebPage  $webPage
     * @return \Illuminate\Http\Response
     */
    public function show(WebPage $webPage): Response
    {
        return $webPage;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WebPage  $webPage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WebPage $webPage): Response
    {
        $webPage->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WebPage  $webPage
     * @return \Illuminate\Http\Response
     */
    public function destroy(WebPage $webPage): Response
    {
        $webPage->delete();
    }
}
