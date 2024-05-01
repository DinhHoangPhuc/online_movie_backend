<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'releaseYear' => $this->release_year,
            'scriptSummary' => $this->srcipt_summary,
            'source' => $this->source,
            'trailer' => $this->trailer,
            'movieLength' => $this->moive_length,
            'poster' => $this->poster,
            'director' => new DirectorResource($this->director),
            'actors' => ActorResource::collection($this->whenLoaded('actors')),
            'countries' => CountryResource::collection($this->whenLoaded('countries')),
            'genres' => GenreResource::collection($this->whenLoaded('genres'))
        ];
    }
}
