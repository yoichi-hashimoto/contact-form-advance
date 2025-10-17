<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactSearchRequest;

class ContactSearchController extends Controller
{
    public function index(ContactSearchRequest $request)
    {
        $filters = $request->filters();

        $v=$request->validated();

        $query = Contact::query()->with('category');

        if (!empty($v['keyword'])) {
            $query->where(function ($q) use ($v) {
                $q->where('last_name', 'like', '%' . $v['keyword'] . '%')
                  ->orWhere('first_name', 'like', '%' . $v['keyword'] . '%')
                  ->orWhere('email', 'like', '%' . $v['keyword'] . '%')
                  ->orWhereRaw("CONCAT(last_name, ' ', first_name) like ?", ['%' . $v['keyword'] . '%']);
        });
        }
        if (!empty($v['gender']) && $v['gender'] !== 'all') {
            $query->where('gender', $v['gender']);
        }
        if (!empty($v['category_id']) && $v['category_id'] !== 'all') {
            $query->where('category_id', $v['category_id']);
        }
        if (!empty($v['date'])) {
            $query->whereDate('created_at', $v['date']);
        }

        $contacts = $query->orderBy('created_at')
                ->paginate(7)
                ->withQueryString();

        $categories = Category::orderBy('id')->get(['id', 'content']);
        $genderSelect = ['all' => '全て', '男性' => '男性', '女性' => '女性', 'その他' => 'その他'];

        return view('admin', compact('contacts', 'categories', 'genderSelect', 'filters'));
        }

        public function show(Contact $contact)
        {
            $category = optional($contact->category)->content ?? ($contact->category ?? '');
            return response()->json(
                [
                    'id' => $contact->id,
                    'name' => $contact->last_name. ' ' . $contact->first_name,
                    'gender' => $contact->gender,
                    'email' => $contact->email,
                    'tel' => $contact->tel1 . '-' . $contact->tel2 . '-' . $contact->tel3,
                    'address' => $contact->address,
                    'building' => $contact->building,
                    'category' => optional($contact->category)->content,
                    'detail' => $contact->detail,
                    'created' => optional($contact->created_at)->format('Y-m-d H:i')
                ]);
        }

        public function destroy(Contact $contact)
        {
            $contact->delete();
            if (request()->wantsJson()) {
                return response()->json(['ok' => true]);
            }
            return redirect()->route('admin.contacts.index')->with('success', 'お問い合わせを削除しました。');
        }
}    

