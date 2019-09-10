<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ArticleStoreRequest
 * @package App\Http\Requests
 */
class ArticleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'title' => 'required|string|min:5|max:191',
            'content' => 'required|string|min:10',
        ];
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return strip_tags($this->input('title'));
    }

    /**
     * @return string
     */
    public function getContext(): string
    {
        return strip_tags($this->input('content'));
    }
}
