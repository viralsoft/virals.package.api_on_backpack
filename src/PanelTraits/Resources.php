<?php
namespace ViralsBackpack\BackPackAPI\PanelTraits;

use Illuminate\Support\Collection;
use ViralsBackpack\BackPackAPI\Http\Resources\ModelResource;
use ViralsBackpack\BackPackAPI\Http\Resources\ModelResourceCollection;

trait Resources
{
    protected $response = [];
    protected $message;
    protected $status;
    protected $numEntriesPerPage = 10;
    protected $listPage = 1;
    protected $extraData = [];
    protected $deleteReturnList = false;

    /**
     * set message
     * @param $message
     * @return mixed
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this->message;
    }

    /**
     * get message
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * set status
     * @param $status
     * @return mixed
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this->status;
    }

    /**
     * get status
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param array $response
     * @param bool $isCollection
     * @return array
     */
    public function setResponse($response = [])
    {
        $this->response['response'] = $response;
        return $this->response;
    }

    public function setExtraData($extraData = [])
    {
        $this->response['extraData'] = $extraData;
        return $this->response;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return int
     */
    public function getNumEntriesPerPage()
    {
        return $this->numEntriesPerPage;
    }

    /**
     * @param $num
     * @return int
     */
    public function setNumEntriesPerPage($num)
    {
        $this->numEntriesPerPage = $num;
        return $this->numEntriesPerPage;
    }

    /**
     * @return mixed
     */
    public function getListPage()
    {
        return $this->getListPage();
    }

    /**
     * @param $page
     * @return int
     */
    public function setListPage($page)
    {
        $this->listPage = $page;
        return $this->listPage;
    }

    /**
     * @param $allow
     */
    public function setDeleteReturnList($allow)
    {
        $this->deleteReturnList = $allow;
    }

    public function getDeleteReturnList()
    {
        return $this->deleteReturnList;
    }

    /**
     * create resources
     * @param $response
     * @param bool $isCollection
     * @return ModelResourceCollection|ModelResource
     */
    public function createResource($data, $isCollection = false)
    {
        if ($data) {
            if ($isCollection) {
                $data = $data instanceof Collection ? $data : collect([$data]);
                return (new ModelResourceCollection($data, $this->response))
                    ->setMessage($this->getMessage())
                    ->setStatus($this->getStatus());
            }
            return (new ModelResource($data, $this->response))
                ->setMessage($this->getMessage())
                ->setStatus($this->getStatus());
        }
        return (new ModelResourceCollection(collect([]), $this->response))
            ->setMessage($this->getMessage())
            ->setStatus($this->getStatus());
    }

    // -------
    // CREATE
    // -------
    /**
     * Gets the create response.
     * @return string name of the response
     */
    public function getCreateResponse($data)
    {
        return $this->createResource($data, true);
    }

    // -------
    // UPDATE
    // -------
    public function getUpdateResponse($data)
    {
        return $this->createResource($data, false);
    }

    // -------
    // LIST
    // -------

    /**
     * Gets the detail response.
     * @return string name of the response file
     */
    public function getListResponse()
    {
        $offset = ($this->listPage-1) * $this->numEntriesPerPage;
        $data = get_class($this->model)::query()->offset($offset)->limit($this->numEntriesPerPage)->get();
        return $this->createResource($data, true);
    }

    // -------
    // SHOW
    // -------
    /**
     * Gets the show response.
     * @return string name of the response file
     */
    public function getShowResponse($data, $isCollection = false)
    {
        return $this->createResource($data, $isCollection);
    }


}