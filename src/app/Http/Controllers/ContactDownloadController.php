<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Carbon;

class ContactDownloadController extends Controller
{
    private function filterQuery(Request $request)
    {
        return Contact::query()
            ->when(trim($request->keyword ?? '') !== '', function ($query) use ($request) {
                $keyword = $request->input('keyword');
                $query->where(function ($q) use ($keyword) {
                    $q->where('last_name', 'like', "%{$keyword}%")
                      ->orWhere('first_name', 'like', "%{$keyword}%")
                      ->orWhere('email', 'like', "%{$keyword}%");
                });
            })
            ->when(($request->gender ?? '') && $request->gender !== 'all', function ($query) use ($request) {
                $query->where('gender', $request->gender);
            })
            ->when(($request->category_id ?? '') && $request->category_id !== 'all', function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->when(trim($request->date ?? '') !== '', function ($query) use ($request) {
                $date = Carbon::parse($request->date);
                $query->whereBetween('created_at', [$date->startOfDay(), $date->endOfDay()]);
            });
    }

    public function index(Request $request)
    {
        $contacts = $this->filterQuery($request)
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin', [
            'contacts' => $contacts,
            'filters' => $request->all(),
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $filename = 'contacts_' . now()->format('Ymd_His') . '.csv';

        $response = new StreamedResponse(function () use ($request) {
            $handle = fopen('php://output', 'w');

            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, ['お名前', '性別', 'メールアドレス', '電話番号', '住所', '建物名', '種類', '内容', '作成日']);

            $this->filterQuery($request)
                ->orderBy('id')
                ->lazyById(1000)
                ->each(function ($c) use ($handle) {
                    $name = trim(($c->last_name ?? '').' '.($c->first_name ?? ''));
                    $tel  = implode('-', array_filter([$c->tel1, $c->tel2, $c->tel3]));
                    fputcsv($handle, [
                        $name,
                        $c->gender,
                        $c->email,
                        $tel,
                        $c->address,
                        $c->building,
                        optional($c->category)->content,
                        $c->detail,
                        optional($c->created_at)->format('Y-m-d H:i'),
                    ]);
                });

            fclose($handle);
        });
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
