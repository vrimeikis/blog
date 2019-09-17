<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

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
            'categories' => 'nullable|array',
            'cover' => 'nullable|image',
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

    /**
     * @return array
     */
    public function getCategoriesIds(): array
    {
        return $this->input('categories', []);
    }

    /**
     * @return UploadedFile|null
     */
    public function getCover(): ?UploadedFile
    {
        return $this->file('cover');
    }

    /**
     * @return int|null
     */
    public function getDeleteCoverOption(): ?int
    {
        $deleteCover = $this->input('deleteCover');

        if ($deleteCover === null) {
            return null;
        }

        return (int)$deleteCover;
    }
}
