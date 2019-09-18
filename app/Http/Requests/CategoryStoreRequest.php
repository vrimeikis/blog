<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use App\Category;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * Class CategoryStoreRequest
 * @package App\Http\Requests
 */
class CategoryStoreRequest extends FormRequest
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
    public function rules()
    {
        return [
            'title' => [
                'required',
                'string',
                'min:5',
                'max:191',
            ],
        ];
    }

    /**
     * @return Validator
     */
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->after(function(Validator $validator) {
            $category = $this->route()->parameter('category');
            $categoryId = $category ? (int)$category->id : null;
            if (
                ($this->isMethod('put') || $this->isMethod('post')) &&
                $this->slugExists($categoryId)
            ) {
                $validator->errors()
                    ->add('slug', 'This slug already exists');
            }

            return;
        });

        return $validator;
    }

    /**
     * @param int|null $categoryId
     * @return bool
     */
    private function slugExists(?int $categoryId = null): bool
    {
        $query = Category::query()->where('slug', '=', $this->getSlug());

        if ($categoryId !== null) {
            $query->where('id', '!=', $categoryId);
        }

        $category = $query->first();

        if (!empty($category)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->input('title');
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        $slugUnprepared = $this->input('slug');

        if (is_string($slugUnprepared)) {
            $slugUnprepared = trim($slugUnprepared);
        }

        if (empty($slugUnprepared)) {
            $slugUnprepared = $this->getTitle();
        }

        $slug = Str::slug($slugUnprepared);

        return $slug;
    }
}
