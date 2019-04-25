<?php

namespace ViralsBackpack\BackPackAPI\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ModelResource extends JsonResource
{
    use TraitResource;

    public $response;
    public $extraData = [];
    protected $message = '';
    protected $status = '';

    public function __construct($resource, $response)
    {
        parent::__construct($resource);
        $this->response = $response;
    }

    public function with($request)
    {
        $data = [
            'message' => $this->message,
            'code' => $this->status,
        ];

        if (isset($this->response['extraData']) && count($this->response['extraData'])) {
            $data = array_merge($this->response['extraData'], $data);
        }
        return $data;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];
        $response = $this->response['response'];
        foreach ($response as $key => $value) {
            if ($value instanceof \Closure) {
                $data[$key] = call_user_func($value, $this);
            } else {
                $data[$value] = @$this->$value;
            }
        }
        return $data;
    }
}
