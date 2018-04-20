<?php


namespace App\Models\Transformers;


use App\Models\Document;
use Illuminate\Support\Collection;

class DocumentCollectionTransformer
{
    /**
     * @var Collection
     */
    public $documents;

    /**
     * DocumentCollectionTransformer constructor.
     * @param Collection $documents
     */
    public function __construct(Collection $documents)
    {
        $this->documents = $documents;
    }

    /**
     * @return mixed
     */
    public function transform()
    {
        return $this->documents
            ->map(function (Document $model) {
                return [
                    'id' => $model->id,
                    'title' => $model->title,
                    'sender' => $model->sender,
                    'tags' => $model->tags,
                    'date' => $model->date->format("d/m/Y"),
                    'created_at' => $model->created_at->format("d/m/Y"),
                    'originalUrl' => $model->getFirstMedia()->getUrl(),
                ];
            });
    }
}