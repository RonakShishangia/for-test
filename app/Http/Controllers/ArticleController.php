<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(){
        try{
            $articles = Article::with([
                'user',
            ])->get();
            return view('article', compact('articles'));
        }catch(\Exception $e){
            dd($e);
        }
    }

    public function store(Request $request){
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required'
        ]);
        try{
            if($request->id==""){
                $article = new Article;
                $msg = "Record Added Successfully..";
            }else{
                $article = Article::find($request->id);
                $msg = "Record Updated Successfully..";
            }
            $article->user_id = \Auth::user()->id;
            $article->title = $request->title;
            $article->body = $request->body;
            $article->save();

            \Session::flash("success",$msg);
            return redirect()->route('article.index');
        }catch(\Exception $e){
            dd($e);
        }
    }

    public function destroy($id){
        try{
            Article::destroy($id);
            \Session::flash("success","Record Deleted Successfully..");
            return redirect()->route('article.index');
        }catch(\Exception $e){
            dd($e);
        }
    }
}
