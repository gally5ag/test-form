<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminContactController extends Controller
{
    public function index(Request $request)
    {
        $q = Contact::query()->orderByDesc('created_at');

        // キーワード（名前/メール） 部分一致 or 完全一致
        $keyword = trim((string)$request->input('keyword', ''));
        $exact   = (bool)$request->input('exact', false);

        if ($keyword !== '') {
            $q->where(function ($w) use ($keyword, $exact) {
                if ($exact) {
                    $w->where('last_name', $keyword)
                        ->orWhere('first_name', $keyword)
                        ->orWhereRaw("CONCAT(last_name, first_name) = ?", [$keyword])
                        ->orWhereRaw("CONCAT(last_name, ' ', first_name) = ?", [$keyword])
                        ->orWhere('email', $keyword);
                } else {
                    $like = "%{$keyword}%";
                    $w->where('last_name', 'like', $like)
                        ->orWhere('first_name', 'like', $like)
                        ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", [$like])
                        ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", [$like])
                        ->orWhere('email', 'like', $like);
                }
            });
        }

        // 性別（'' or 'all' は絞らない）
        $gender = $request->input('gender', '');
        if ($gender !== '' && $gender !== 'all') {
            $q->where('gender', (int)$gender); // 1,2,3
        }

        // お問い合わせ種類
        $type = $request->input('inquiry_type', '');
        if ($type !== '') {
            $q->where('inquiry_type', $type); // 'document','estimate','support','other'
        }

        // 日付（created_at の日付一致）
        if ($request->filled('date')) {
            $q->whereDate('created_at', $request->input('date'));
        }

        $contacts = $q->paginate(7)->appends($request->query());

        $genderLabels = [1 => '男性', 2 => '女性', 3 => 'その他'];
        $typeLabels   = [
            'document' => '資料請求',
            'estimate' => 'お見積り',
            'support'  => 'サポート',
            'other'    => 'その他',
        ];

        // ★ admin.blade.php を使う
        return view('admin', compact('contacts', 'genderLabels', 'typeLabels'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect('/admin')->with('status', '削除しました');
    }

    public function export(Request $request): StreamedResponse
    {
        $contacts = $this->filtered($request)->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=SJIS-win',
            'Content-Disposition' => 'attachment; filename=contacts.csv',
        ];

        return response()->stream(function () use ($contacts) {
            $out = fopen('php://output', 'w');
            $put = function ($row) use ($out) {
                foreach ($row as &$v) {
                    $v = mb_convert_encoding($v, 'SJIS-win', 'UTF-8');
                }
                fputcsv($out, $row);
            };

            $put(['お名前', '性別', 'メールアドレス', '電話番号', '住所', '建物名', 'お問い合わせの種類', '内容', '日時']);

            $typeLabels   = ['document' => '商品の交換について', 'estimate' => '商品トラブル', 'support' => 'ショップへのお問い合わせ', 'other' => 'その他'];
            $genderLabels = [1 => '男性', 2 => '女性', 3 => 'その他'];

            foreach ($contacts as $c) {
                $tel = $c->tel ?? (($c->tel1 ?? '') . ($c->tel2 ?? '') . ($c->tel3 ?? ''));
                $put([
                    $c->last_name . '　' . $c->first_name,
                    $genderLabels[$c->gender] ?? '',
                    $c->email,
                    $tel,
                    $c->address,
                    $c->building,
                    $typeLabels[$c->inquiry_type] ?? $c->inquiry_type,
                    $c->detail ?? $c->content,
                    $c->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($out);
        }, 200, $headers);
    }

    private function filtered(Request $request)
    {
        $q = Contact::query()->orderByDesc('created_at');

        $keyword = trim((string)$request->input('keyword', ''));
        $exact   = (bool)$request->input('exact', false);

        if ($keyword !== '') {
            $q->where(function ($w) use ($keyword, $exact) {
                if ($exact) {
                    $w->where('last_name', $keyword)
                        ->orWhere('first_name', $keyword)
                        ->orWhereRaw("CONCAT(last_name, first_name) = ?", [$keyword])
                        ->orWhereRaw("CONCAT(last_name, ' ', first_name) = ?", [$keyword])
                        ->orWhere('email', $keyword);
                } else {
                    $like = "%{$keyword}%";
                    $w->where('last_name', 'like', $like)
                        ->orWhere('first_name', 'like', $like)
                        ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", [$like])
                        ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", [$like])
                        ->orWhere('email', 'like', $like);
                }
            });
        }

        $gender = $request->input('gender', '');
        if ($gender !== '' && $gender !== 'all') {
            $q->where('gender', (int)$gender);
        }

        $type = $request->input('inquiry_type', '');
        if ($type !== '') $q->where('inquiry_type', $type);

        if ($request->filled('date')) $q->whereDate('created_at', $request->input('date'));

        return $q;
    }
}
