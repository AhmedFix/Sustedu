<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the book is authorized to make this request.
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
    public function rules()
    {
        $rules = [
            'subject_id'        => 'required|numeric',
            'name'        => 'required|string|max:255|unique:books',
            'author'     => 'required|string',
            'url'     => 'required|string',
            'book_type'        => 'required|string',
            'description' => 'required|string|max:255',
            'poster' => 'sometimes|nullable|image',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $book = $this->route()->parameter('book');

            $rules['name'] = 'required|unique:books,id,' . $book->id;

        }//end of if

        return $rules;

    }//end of rules


}//end of request
