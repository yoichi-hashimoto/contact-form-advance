<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'keyword' => 'nullable|string|max:255',
            'name_exact' => 'nullable|boolean',
            'email_exact' => 'nullable|boolean',
            'gender' => 'nullable|in:all,男性,女性,その他',
            'category_id' => 'nullable|integer',
            'date' => 'nullable|date',
        ];
    }

    protected function prepareForValidation(): void
    {
        $keyword = trim((string)$this->input('keyword'));

        $gender = $this->input('gender');
        if ($gender === 'all') {
            $gender = null;
        }

        $categoryId = $this->input('category_id');
        if ($categoryId === 'all') {
            $categoryId = null;
        }

        $date = $this->input('date');
        if ($date === 'all') {
            $date = null;
        }

        $this->merge([
            'keyword' => $keyword !== '' ? $keyword : null,
            'gender' => $gender,
            'category_id' => $categoryId,
            'date' => $date,
        ]);
    }
        public function filters(): array
        {
            return [
                'keyword' => (string)($this->input('keyword') ?? ''),
                'gender' => (string)($this->input('gender') ?? ''),
                'category_id' => (string)($this->input('category_id') ?? ''),
                'date' => (string)($this->input('date') ?? ''),
            ];
        }

        public function messages(): array
        {
            return [
                'keyword.max' => 'キーワードは255文字以内で入力してください。',
                'gender.in' => '性別の選択が不正です。',
                'category_id.integer' => 'カテゴリーの選択が不正です。',
                'date.date' => '日付の形式が不正です。',
            ];
        }
    }