<?php

namespace ViralsBackpack\BackPackAPI\Http\Resources;


class ModelResourceCollection extends ResourceCollection
{
    use TraitResource;

    protected $response;
    protected $message = '';
    protected $status = '';

    public function __construct($resource, $response)
    {
        parent::__construct($resource, $response);
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

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
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
}
