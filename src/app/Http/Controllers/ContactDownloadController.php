<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactDownloadController extends Controller
{
    public function export()
    {
        $contacts = Contact::all();

        $response = new StreamedResponse(function () use ($contacts) {
            $out = fopen('php://output', 'w');

            $headers = ['ID','姓','名','性別','メールアドレス','電話番号1','電話番号2','電話番号3','住所','建物名','カテゴリ','詳細'];
            // ヘッダをSJIS-winへ
            $headers = array_map(fn($v) => mb_convert_encoding($v, 'SJIS-win', 'UTF-8'), $headers);
            fputcsv($out, $headers);
            // Excelが好むCRLFを明示
            fwrite($out, "\r\n");

            foreach ($contacts as $c) {
                $row = [
                    $c->id, $c->last_name, $c->first_name, $c->gender, $c->email,
                    $c->tel1, $c->tel2, $c->tel3, $c->address, $c->building,
                    $c->category_id, $c->detail,
                ];
                // 行もSJIS-winへ
                $row = array_map(fn($v) => mb_convert_encoding((string)$v, 'SJIS-win', 'UTF-8'), $row);
                fputcsv($out, $row);
                fwrite($out, "\r\n");
            }
            fclose($out);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=Shift_JIS');
        $response->headers->set('Content-Disposition', 'attachment; filename="contacts_' . date('Ymd_His') . '.csv"');

        return $response;
    }
}
