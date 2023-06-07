<?php

namespace App\Http\Controllers\Widget;

use App\Http\Controllers\Controller;
use App\Models\Widget;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageAboutUsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request):View
    {
        $pageAboutUs = Widget::query()
                        ->where('key', '=', 'page-about-us')
                        ->where('active', '=', true)
                        ->first();
        if(!$pageAboutUs){
            throw new NotFoundHttpException();
        }

        return view('widget.aboutUs', compact('pageAboutUs'));
    }
}
