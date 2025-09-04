<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('index'); // ここで old() を使って前回値が出ます
    }

    public function confirm(ContactRequest $request)
    {
        // 「修正」ボタン
        if ($request->has('_back')) {
            return redirect('/')->withInput();
        }

        // 「送信」ボタン（保存してサンクスへ）
        if ($request->has('_send')) {
            $data = $request->validated();

            // tel1/2/3 を結合（DB が tel カラムの場合）
            $tel = ($data['tel1'] ?? '') . ($data['tel2'] ?? '') . ($data['tel3'] ?? '');

            // ご自身のカラム構成に合わせて調整（例では detail に content を保存）
            Contact::create([
                'last_name'    => $data['last_name'],
                'first_name'   => $data['first_name'],
                'gender'       => (int)$data['gender'],
                'email'        => $data['email'],
                'tel'          => $tel,
                'address'      => $data['address'],
                'building'     => $data['building'] ?? null,
                'inquiry_type' => $data['inquiry_type'], // category_id を使うなら置換
                'detail'       => $data['content'],      // content カラムなら content に
            ]);

            return redirect('/thanks');
        }

        // ここは「確認表示」
        $contact = $request->validated();
        return view('confirm', compact('contact'));
    }

    public function thanks()
    {
        return view('thanks');
    }
}
