<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use App\Article;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * Class ArticleStoreRequest
 * @package App\Http\Requests
 */
class ApiArticleStoreRequest extends ApiFormRequest
{
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
     * @return Validator
     */
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->after(function(Validator $validator) {
            $article = $this->route()->parameter('article');
            $articleId = $article ? (int)$article : null;
            if (
                ($this->isMethod('put') || $this->isMethod('post')) &&
                $this->slugExists($articleId)
            ) {
                $validator->errors()
                    ->add('slug', 'This slug already exists');
            }

            return;
        });

        return $validator;
    }

    /**
     * @param int|null $articleId
     * @return bool
     */
    private function slugExists(?int $articleId = null): bool
    {
        $query = Article::query()->where('slug', '=', $this->getSlug());

        if ($articleId !== null) {
            $query->where('id', '!=', $articleId);
        }

        $article = $query->first();

        if (!empty($article)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return strip_tags($this->input('title', ''));
    }

    /**
     * @return string
     */
    public function getContext(): string
    {
        return strip_tags($this->input('content', ''));
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
