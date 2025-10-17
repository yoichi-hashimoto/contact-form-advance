<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;
use App\Models\Category;

class ContactController extends Controller
{
    public function index(){
        $categories = Category::orderBy('id')->get(['id', 'content']);
        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request){
        $validated = $request->validated();
        $fullName= $request->last_name . '　' . $request->first_name;
        $fullTel= $request->tel1 . '-' . $request->tel2 . '-' . $request->tel3;

        $categoryLabel = Category::find($request->category_id)->content ?? '未選択';
        return view('confirm',compact('fullName','fullTel','validated','categoryLabel')
        );
    }
    public function store(Request $request){
        if($request->input('action') === 'rewrite'){
            return redirect()->route('contact.index')
            ->withInput($request->except('action', '_token'));
        }
        Contact::create($request->only([
            'last_name',
            'first_name',
            'gender',
            'email',
            'tel1',
            'tel2',
            'tel3',
            'address',
            'building',
            'category_id',
            'detail',
        ]));
        return view('thanks');
    }
}
